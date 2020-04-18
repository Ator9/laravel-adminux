<?php

namespace App\Adminux\Billing\Controllers;

use App\Http\Controllers\Controller;
use App\Adminux\Admin\Models\Currency;
use App\Adminux\Helper;
use App\Adminux\Account\Models\Account;
use Yajra\Datatables\Datatables;

class BillingController extends Controller
{
    public function index()
    {
        $plans = $this->getPlanPrices(); $currencies = Currency::all()->keyBy('id')->toArray();
        $date_from = (request()->filled('date_from')) ? request()->date_from : date('Y-m', strtotime('-12 months', strtotime(date('Y-m'))));
        $date_to = (request()->filled('date_to')) ? request()->date_to : date('Y-m');
        $account_id = (request()->filled('account_id')) ? (int) request()->account_id : '';

        if($date_from > $date_to) return back()->withErrors(['msg' => '"From Date" must be earlier than "To Date".']);

        $usage = $this->getUsage(['from' => $date_from, 'to' => $date_to, 'account_id' => $account_id]);
        foreach($usage as $date => $array) {
            $hours_in_month = date('t', strtotime($date)) * 24; $sales[$date] = 0; $costs[$date] = 0;

            if($array->isNotEmpty()) {
                foreach($array as $data) {
                    $hours_usage = !empty($data->minutes) ? $data->minutes / 60 : 0;

                    if($plans[$data->plan_id]->interval == 'monthly') {
                        $sales[$date]+= $plans[$data->plan_id]->price * $hours_usage / $hours_in_month;
                    }
                    if($plans[$data->plan_id]->cost_interval == 'monthly') {
                        $costs[$date]+= $plans[$data->plan_id]->cost * $hours_usage / $hours_in_month;
                    }

                    if($plans[$data->plan_id]->interval == 'perunit') {
                        $sales[$date]+= $plans[$data->plan_id]->price * @$data->units;
                    }
                    if($plans[$data->plan_id]->cost_interval == 'perunit') {
                        $costs[$date]+= $plans[$data->plan_id]->cost * @$data->units;
                    }
                }
            }

            $sales[$date] = round($sales[$date], 2);
            $costs[$date] = round($costs[$date], 2);
        }

        // dd($plans);

        return view('adminux.backend.pages.billing')->with([
            'usage' => $usage,
            'costs' => $costs,
            'sales' => $sales,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'account_id' => $account_id,
            'active_accounts' => \DB::table('accounts')->where('active', '=', 'Y')
                                ->whereIn('partner_id', Helper::getSelectedPartners())
                                ->whereRaw($account_id > 0 ? 'accounts.id = '.$account_id : '1=1')
                                ->count(),
            'active_products' => \DB::table('accounts_products')
                                ->join('accounts', 'accounts.id', '=', 'accounts_products.account_id')
                                ->whereIn('partner_id', Helper::getSelectedPartners())
                                ->where('accounts_products.active', '=', 'Y')
                                ->whereRaw($account_id > 0 ? 'accounts.id = '.$account_id : '1=1')
                                ->count(),
        ]);
    }

    public function accountsSummary(Account $account)
    {
        if(request()->ajax() || request()->filled('export')) {
            $datatables = Datatables::of($account->query()->whereIn('partner_id', Helper::getSelectedPartners()));

            if(request()->filled('export')) return Helper::exportDt($datatables, [ 'name' => 'accounts.csv' ]);

            return $datatables->addColumn('id2', 'adminux.backend.pages.inc.link_show_link')
                ->addColumn('active2', 'adminux.backend.pages.inc.status')
                ->addColumn('partner', function($row) { return @$row->partner->partner; })
                ->rawColumns(['id2', 'active2'])
                ->toJson();
        }

        return view('adminux.backend.pages.index')->withDatatables([
            'exportButton' => 1,
            'order' => '[[ 0, "desc" ]]',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th>E-mail</th>
                        <th style="min-width:120px">Partner</th>
                        <th style="min-width:60px">Active</th>',

            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "email", name: "email" },
                          { data: "partner", name: "partner", searchable: false },
                          { data: "active2", name: "active", className: "text-center" }'
        ]);
    }

    /**
     * Get Products Usage (minutes)
     *
     * @return Collection All collections also serve as iterators (no "toArray()" needed). https://laravel.com/docs/eloquent-collections
     */
    public function getUsage($params = [])
    {
        $from = (!empty($params['from'])) ? date('Y-m', strtotime($params['from'])) : date('Y-m');
        $to   = (!empty($params['to'])) ? date('Y-m', strtotime($params['to'])) : date('Y-m');

        $hours = $units = [];
        for($i = $from; $i <= $to; $i = date('Y-m', strtotime($i.' +1 month'))) {
            $dates[] = $i;
        }

        if(!empty($dates))
        foreach($dates as $date) {
            list($year, $month) = explode('-', $date);

            // Usage:
            $hours[$date] = \DB::table('billing_usage')->whereIn('partner_id', Helper::getSelectedPartners())
            ->where(function ($query) use ($year, $month) {
                $query->where([
                    ['date_start', '>=', $year.'-'.$month.'-01'],
                    ['date_start', '<', date('Y-m-01', mktime(0, 0, 0, $month+1, 1, $year))],
                ]);
                $query->orWhere('date_start', '<', $year.'-'.$month.'-01')->whereNull('date_end');
                $query->orWhere([
                    ['date_start', '<', $year.'-'.$month.'-01'],
                    ['date_end', '>=', $year.'-'.$month.'-01'],
                ]);
            })
            ->select('product_id','accounts_products.plan_id')
            ->selectRaw('SUM(TIMESTAMPDIFF(MINUTE,
                            if(date_start < "'.$year.'-'.$month.'-01", "'.$year.'-'.$month.'-01", date_start),
                            if(
                                if(date_end, date_end, CURRENT_TIMESTAMP) < "'.date('Y-m-01', mktime(0, 0, 0, $month+1, 1, $year)).'",
                                if(date_end, date_end, CURRENT_TIMESTAMP), "'.date('Y-m-01', mktime(0, 0, 0, $month+1, 1, $year)).'")
                        )) as minutes')
            ->join('accounts_products', 'accounts_products.id', '=', 'billing_usage.product_id')
            ->join('accounts', 'accounts.id', '=', 'accounts_products.account_id')
            ->whereRaw($params['account_id'] > 0 ? 'accounts.id = '.$params['account_id'] : '1=1')
            ->groupBy('product_id','plan_id')->get()->keyBy('product_id');

            // Units:
            $units[$date] = \DB::table('billing_units')->whereIn('partner_id', Helper::getSelectedPartners())
            // ->whereDate('date', $year.'-'.$month)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->select('product_id','accounts_products.plan_id')
            ->selectRaw('SUM(units) as units')
            ->join('accounts_products', 'accounts_products.id', '=', 'billing_units.product_id')
            ->join('accounts', 'accounts.id', '=', 'accounts_products.account_id')
            ->whereRaw($params['account_id'] > 0 ? 'accounts.id = '.$params['account_id'] : '1=1')
            ->groupBy('product_id','plan_id')->get()->keyBy('product_id');
        }

        foreach($units as $date => $array) {
            $hours[$date] = $hours[$date]->union($units[$date]);
            foreach($array as $pid => $data) {
                $hours[$date][$pid]->units = $units[$date][$pid]->units;
            }
        }

        return $hours;
    }

    public function getPlanPrices()
    {
        return \DB::table('services_plans')
        ->select('services_plans.id','service_id',
        'services_plans.price', 'services_plans.currency_id', 'services_plans.interval', 'services_plans.price_history',
        'services.price as cost', 'services.currency_id as cost_currency_id', 'services.interval as cost_interval', 'services.price_history as cost_history')
        ->join('services', 'services.id', '=', 'services_plans.service_id')
        ->get()->keyBy('id')->toArray();
    }
}

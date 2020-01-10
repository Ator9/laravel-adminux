<?php

namespace App\Adminux\Billing\Controllers;

use App\Http\Controllers\Controller;
use App\Adminux\Admin\Models\Currency;
use App\Adminux\Helper;

class BillingController extends Controller
{
    public function index()
    {
        $plans = $this->getPlanPrices(); $currencies = Currency::all()->keyBy('id')->toArray();
        $date_from = (request()->filled('date_from')) ? request()->date_from : date('Y-m-d', strtotime('-11 months'));
        $date_to = (request()->filled('date_to')) ? request()->date_to : date('Y-m-d');

        $usage = $this->getUsage(['from' => $date_from, 'to' => $date_to]);
        foreach($usage as $date => $array) {
            $hours_in_month = date('t', strtotime($date)) * 24;

            if($array->isNotEmpty()) {
                foreach($array as $data) {

                    $hours_usage = $data->minutes / 60;

                    $sales[$date] = number_format($plans[$data->plan_id]->price * $hours_usage / $hours_in_month, 2) + @$sales[$date];
                    $costs[$date] = number_format($plans[$data->plan_id]->cost * $hours_usage / $hours_in_month, 2) + @$costs[$date];
                }
            }
            else $costs[$date] = $sales[$date] = 0;
        }

        // dump($currencies,$plans,$usage, $costs);

        return view('adminux.pages.billing')->with([
            'usage' => $usage,
            'costs' => $costs,
            'sales' => $sales,
            'date_from' => $date_from,
            'date_to' => $date_to,
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

        $hours = [];
        for($i = $from; $i <= $to; $i = date('Y-m', strtotime($i.' +1 month'))) {
            $dates[] = $i;
        }

        if(!empty($dates))
        foreach($dates as $date) {

            list($year, $month) = explode('-', $date);

            $hours[$date] = \DB::table('accounts_products_usage')->whereIn('partner_id', Helper::getSelectedPartners())
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
            ->join('accounts_products', 'accounts_products.id', '=', 'accounts_products_usage.product_id')
            ->join('accounts', 'accounts.id', '=', 'accounts_products.account_id')
            ->groupBy('product_id','plan_id')->get()->keyBy('product_id');
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

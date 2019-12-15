<?php

namespace App\Adminux\Billing\Controllers;

use App\Http\Controllers\Controller;

class BillingController extends Controller
{
    public function index()
    {
        $prices = $this->getPlanPrices();
        $usage = $this->getUsage([
            'from' => '2019-01',
            'to' => '2019-12',
        ]);



        foreach($usage as $date => $array) {
            // $labels[$date] = date('F', strtotime($date));
            // foreach($array as $pdi => $data) {
            //     echo $pdi.': '.floor($data->minutes / 60).'<br>';
            // }
        }

        dd($prices,$usage);
        // dd($usage);

        return view('adminux.pages.billing')->withUsage($usage);
    }

    /**
     * Get Products Usage (minutes)
     *
     * @return Collection All collections also serve as iterators (no "toArray()" needed). https://laravel.com/docs/eloquent-collections
     */
    public function getUsage($params = [])
    {
        $from = (!empty($params['from'])) ? $params['from'] : date('Y-m');
        $to   = (!empty($params['to'])) ? $params['to'] : date('Y-m');

        $hours = [];
        for($i = $from; $i <= $to; $i = date('Y-m', strtotime($i.' +1 month'))) {
            $dates[] = $i;
        }

        if(!empty($dates))
        foreach($dates as $date) {

            list($year, $month) = explode('-', $date);

            $hours[$date] = \DB::table('accounts_products_usage')->where([
                ['date_start', '>=', $year.'-'.$month.'-01'],
                ['date_start', '<', date('Y-m-01', mktime(0, 0, 0, $month+1, 1, $year))],
            ])
            ->orWhere(function ($query) use ($year, $month) {
                $query->where('date_start', '<', $year.'-'.$month.'-01')->whereNull('date_end');
            })
            ->orWhere([
                ['date_start', '<', $year.'-'.$month.'-01'],
                ['date_end', '>=', $year.'-'.$month.'-01'],
            ])
            ->select('product_id','accounts_products.plan_id')
            ->selectRaw('SUM(TIMESTAMPDIFF(MINUTE,
                            if(date_start < "'.$year.'-'.$month.'-01", "'.$year.'-'.$month.'-01", date_start),
                            if(
                                if(date_end, date_end, CURRENT_TIMESTAMP) < "'.date('Y-m-01', mktime(0, 0, 0, $month+1, 1, $year)).'",
                                if(date_end, date_end, CURRENT_TIMESTAMP), "'.date('Y-m-01', mktime(0, 0, 0, $month+1, 1, $year)).'")
                        )) as minutes')
            ->join('accounts_products', 'accounts_products.id', '=', 'accounts_products_usage.product_id')
            ->groupBy('product_id','plan_id')->get()->keyBy('product_id');
        }

        return $hours;
    }

    public function getPlanPrices()
    {
        return \DB::table('services_plans')
        ->select('services_plans.id','service_id', 'services_plans.price','services_plans.price_history','services.price as cost','services.price_history as cost_history')
        ->join('services', 'services.id', '=', 'services_plans.service_id')
        ->get()->keyBy('id')->toArray();
    }
}

<?php

namespace App\Adminux\Billing\Controllers;

use App\Http\Controllers\Controller;

class BillingController extends Controller
{
    public function index()
    {
        $usage = $this->getUsage([
            'from' => '2019-11',
            'to' => '2019-12',
        ]);


        foreach($usage as $date => $array) {
            echo $date.'<hr>';
            foreach($array as $pdi => $data) {
                echo $pdi.': '.floor($data->minutes / 60).'<br>';
            }
        }

        dd($usage);

        return view('adminux.pages.billing');
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

        for($i = $from; $i <= $to; $i = date('Y-m', strtotime($i.' +1 month'))) {
            $dates[] = $i;
        }

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
            ->selectRaw('SUM(TIMESTAMPDIFF(MINUTE,
                            if(date_start < "'.$year.'-'.$month.'-01", "'.$year.'-'.$month.'-01", date_start),
                            if(
                                if(date_end, date_end, CURRENT_TIMESTAMP) < "'.date('Y-m-01', mktime(0, 0, 0, $month+1, 1, $year)).'",
                                if(date_end, date_end, CURRENT_TIMESTAMP), "'.date('Y-m-01', mktime(0, 0, 0, $month+1, 1, $year)).'")
                        )) as minutes')
            ->selectRaw('product_id')->groupBy('product_id')
            ->get()->keyBy('product_id');
        }

        return $hours;
    }
}

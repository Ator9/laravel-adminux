<?php

namespace App\Adminux\Billing\Controllers;

use App\Http\Controllers\Controller;

class BillingController extends Controller
{
    public function index()
    {
        $res = \DB::table('accounts_products_usage')->where([
            ['date_start', '>=', '2019-12-01'],
            ['date_start', '<=', '2019-12-31 23:59:59'],
        ])->orWhere([
            ['date_start', '>=', '2019-12-01'],
            ['date_start', '<=', '2019-12-31 23:59:59'],
        ])
        ->selectRaw('SUM(TIMESTAMPDIFF(HOUR, date_start, if(date_end, date_end, CURRENT_TIMESTAMP))) as hours')
        ->selectRaw('product_id')->groupBy('product_id')
        ->get()->keyBy('product_id')->toArray();

        dd($res);

        return view('adminux.pages.billing');
    }
}

<?php

namespace App\Adminux\Admin\Controllers;

use App\Adminux\Admin\Models\Admin;
use App\Adminux\Partner\Models\Partner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPartnerController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Admin $admin)
    {
        $request->validate([
            'name'   => 'required|unique:'.$partner->getTable(),
            'active' => 'in:Y,""',
        ]);

        // $admin->partners()->attach(($request->all());

        //         $shop = Shop::find($shop_id);
        // $shop->products()->attach($product_id);

        if(!$request->filled('active')) $request->merge(['active' => 'N']);

        $partner = $partner->create($request->all());

        return back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @param  \App\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin, Partner $partner)
    {
        dd(request()->partner);
        $admin->partners()->detach($partner->id);

        return back();
    }
}

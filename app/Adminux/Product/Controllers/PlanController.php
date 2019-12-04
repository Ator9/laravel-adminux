<?php

namespace App\Adminux\Product\Controllers;

use App\Adminux\Product\Models\Plan;
use App\Adminux\Helper;
use Illuminate\Http\Request;
use App\Adminux\AdminuxController;
use Yajra\Datatables\Datatables;

class PlanController extends AdminuxController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Plan $plan)
    {
        if(request()->ajax()) return Datatables::of($plan::query()
            ->join('products', 'products.id', '=', 'products_plans.product_id')
            ->join('partners', 'partners.id', '=', 'products.partner_id')
            ->join('software', 'software.id', '=', 'products.software_id')
            ->whereIn('products_plans.product_id', Helper::getSelectedProducts())
            ->select('products_plans.id', 'products_plans.plan','products_plans.currency_id','products_plans.price','products_plans.interval',
            'products.product','software.software','partners.partner','products_plans.created_at'))
            ->addColumn('currency_price', function($row) {
                return '<small>'.$row->interval.'</small> '.@$row->currency->currency.' '.$row->price;
            })
            ->addColumn('id2', 'adminux.pages.inc.link_show_link')
            ->rawColumns(['id2', 'currency_price'])
            ->toJson();

        return view('adminux.pages.index')->withDatatables([
            'order' => '[[ 0, "asc" ]]',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-75">Plan</th>
                        <th style="min-width:120px">Price</th>
                        <th style="min-width:120px">Product</th>
                        <th style="min-width:120px">Software</th>
                        <th style="min-width:120px">Partner</th>
                        <th style="min-width:120px">Created At</th>',

            'columns' => '{ data: "id2", name: "products_plans.id", className: "text-center" },
                          { data: "plan", name: "products_plans.plan" },
                          { data: "currency_price", name: "currency_price", className: "text-right" },
                          { data: "product", name: "products.product" },
                          { data: "software", name: "software.software" },
                          { data: "partner", name: "partners.partner" },
                          { data: "created_at", name: "products_plans.created_at", className: "text-center" }'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Plan $plan)
    {
        return parent::createView($plan);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Plan $plan)
    {
        $request->validate([
            'product_id' => 'required|in:'.implode(',', Helper::getEnabledProductsKeys()),
            'plan' => 'required',
            'currency_id' => 'required',
            'price' => 'numeric|between:0,9999999.99',
            'interval' => 'required',
        ]);

        $plan = $plan->create($request->all());

        return parent::saveRedirect($plan);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        Helper::validateProduct($plan);
        return view('adminux.pages.show')->withModel($plan);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        Helper::validateProduct($plan);
        return parent::editView($plan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plan $plan)
    {
        $request->validate([
            'plan' => 'required',
            'currency_id' => 'required',
            'price' => 'numeric|between:0,9999999.99',
            'interval' => 'required',
        ]);

        $plan->update($request->only(['plan', 'currency_id', 'price', 'interval'])); // no extra validation required with this field

        return parent::saveRedirect($plan);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        Helper::validateProduct($plan);
        return parent::destroyRedirect($plan);
    }

    /**
     * Build Blade edit & create form fields
     *
     * @return Array
     */
    public function getFields(Plan $plan)
    {
        $form = new \App\Adminux\Form($plan);
        return [
            $form->display([ 'label' => 'ID' ]),
            $form->select([ 'label' => 'Product', 'editable' => false, 'allows' => Helper::getEnabledProductsKeys() ]),
            $form->text([ 'label' => 'Plan' ]),
            $form->select([ 'label' => 'Currency' ]),
            $form->text([ 'label' => 'Price' ]),
            $form->enum([ 'label' => 'Interval' ]),
        ];
    }
}

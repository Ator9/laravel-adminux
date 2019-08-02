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
            ->join('services', 'services.id', '=', 'products.service_id')
            ->whereIn('products_plans.product_id', Helper::getSelectedProducts())
            ->select('products_plans.id', 'products_plans.plan','products.product','services.service','partners.partner','products_plans.created_at'))
            ->addColumn('id2', 'adminux.pages.inc.link_show_link')
            ->rawColumns(['id2'])
            ->toJson();

        return view('adminux.pages.index')->withDatatables([
            'order' => '[[ 0, "asc" ]]',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-75">Plan</th>
                        <th style="min-width:120px">Product</th>
                        <th style="min-width:120px">Service</th>
                        <th style="min-width:120px">Partner</th>
                        <th style="min-width:120px">Created At</th>',

            'columns' => '{ data: "id2", name: "products_plans.id", className: "text-center" },
                          { data: "plan", name: "products_plans.plan" },
                          { data: "product", name: "products.product" },
                          { data: "service", name: "services.service" },
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
        return view('adminux.pages.create')->withModel($plan)->withFields($this->getFields($plan));
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
            'plan' => 'required'
        ]);

        $plan = $plan->create($request->all());

        return redirect(route(explode('/', $request->path())[1].'.show', $plan));
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
        $request->validate(['plan' => 'required']);

        $plan->update($request->only(['plan'])); // no extra validation required with this field

        return redirect(route(explode('/', $request->path())[1].'.show', $plan));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        Helper::validateProduct($plan);
        $plan->delete();

        return redirect(route(explode('/', request()->path())[1].'.index'));
    }

    /**
     * Build Blade edit & create form fields
     *
     * @return Array
     */
    public function getFields(Plan $plan)
    {
        $form = new \App\Adminux\Form($plan);
        $form->addFields([
            $form->display([ 'label' => 'ID' ]),
            $form->select([ 'label' => 'Product', 'editable' => false, 'allows' => Helper::getEnabledProductsKeys() ]),
            $form->text([ 'label' => 'Plan' ]),
        ]);

        return $form->getFields();
    }
}

<?php

namespace App\Adminux\Partner\Controllers;

use App\Adminux\Product\Models\Product;
use App\Adminux\Product\Controllers\PlanProductController;
use App\Adminux\Helper;
use Illuminate\Http\Request;
use App\Adminux\AdminuxController;
use Yajra\Datatables\Datatables;

class ProductController extends AdminuxController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        if(request()->ajax()) return Datatables::of($product::query()->whereIn('partner_id', Helper::getSelectedPartners()))
            ->addColumn('id2', 'adminux.pages.inc.link_show_link')
            ->addColumn('partner', function($row) { return @$row->partner->partner; })
            ->addColumn('service', function($row) { return @$row->service->service; })
            ->addColumn('currency_price', function($row) {
                return '<small>'.$row->interval.'</small> '.@$row->currency->currency.' '.$row->price;
            })
            ->rawColumns(['id2', 'currency_price'])
            ->toJson();

        return view('adminux.pages.index')->withDatatables([
            'order' => '[[ 0, "asc" ]]',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-75">Product</th>
                        <th style="min-width:120px">Price</th>
                        <th style="min-width:120px">Service</th>
                        <th style="min-width:120px">Partner</th>
                        <th style="min-width:120px">Created At</th>',

            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "product", name: "product" },
                          { data: "currency_price", name: "currency_price", className: "text-right" },
                          { data: "service", name: "service" },
                          { data: "partner", name: "partner" },
                          { data: "created_at", name: "created_at", className: "text-center" }'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        return parent::createView($product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'partner_id' => 'required|in:'.implode(',', Helper::getEnabledPartnersKeys()),
            'service_id' => 'required',
            'product' => 'required',
            'domain' => 'nullable|url',
            'currency_id' => 'required',
            'price' => 'numeric|between:0,9999999.99',
            'interval' => 'required',
        ]);

        $product = $product->create($request->all());

        return parent::saveRedirect($product);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        Helper::validatePartner($product);

        if(request()->ajax()) return (new PlanProductController)->getIndex($product);

        return view('adminux.pages.show')->withModel($product)->withRelations([(new PlanProductController)->getIndex($product)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        Helper::validatePartner($product);
        return parent::editView($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product' => 'required',
            'domain' => 'nullable|url',
            'currency_id' => 'required',
            'price' => 'numeric|between:0,9999999.99',
            'interval' => 'required',
        ]);
        Helper::validatePartner($product);

        $product->update($request->only(['product', 'domain', 'currency_id', 'price', 'interval']));

        return parent::saveRedirect($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Helper::validatePartner($product);
        $product->delete();

        return parent::destroyRedirect();
    }

    /**
     * Build Blade edit & create form fields
     *
     * @return Array
     */
    public function getFields(Product $product)
    {
        $form = new \App\Adminux\Form($product);
        return [
            $form->display([ 'label' => 'ID' ]),
            $form->select([ 'label' => 'Partner', 'editable' => false, 'allows' => Helper::getEnabledPartnersKeys() ]),
            $form->select([ 'label' => 'Service', 'editable' => false ]),
            $form->text([ 'label' => 'Product' ]),
            $form->text([ 'label' => 'Domain' ]),
            $form->select([ 'label' => 'Currency' ]),
            $form->text([ 'label' => 'Price' ]),
            $form->enum([ 'label' => 'Interval' ]),
        ];
    }
}

<?php

namespace App\Adminux\Product\Controllers;

use App\Adminux\Product\Models\Product;
use App\Adminux\Admin\Controllers\AdminPartnerController;
// use App\Adminux\Partner\Controllers\PartnerProductController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        if(request()->ajax()) return Datatables::of($product::query())
            ->addColumn('id2', 'adminux.components.datatables.link_show_link')
            ->addColumn('partner', function($row) { return @$row->partner->partner; })
            ->addColumn('service', function($row) { return @$row->service->service; })
            ->rawColumns(['id2'])
            ->toJson();

        return view('adminux.components.datatables.index')->withDatatables([
            'order' => '[[ 0, "asc" ]]',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th style="min-width:120px">Partner</th>
                        <th style="min-width:300px">Service</th>
                        <th class="w-75">Product</th>
                        <th style="min-width:120px">Created At</th>',

            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "partner", name: "partner" },
                          { data: "service", name: "service" },
                          { data: "product", name: "product" },
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
        return view('adminux.components.create')->withModel($product)->withFields($this->getFields($product));
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
            'partner_id' => 'required|in:'.implode(',', (new AdminPartnerController)->getEnabledPartnersKeys()),
            'service_id' => 'required',
            'product' => 'required'
        ]);

        $product = $product->create($request->all());

        return redirect(route(explode('/', $request->path())[1].'.show', $product));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        if(request()->ajax()) return (new PartnerProductController)->getIndex($product);

        return view('adminux.components.show')->withModel($product)->withMany([(new PartnerProductController)->getIndex($product)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('adminux.components.edit')->withModel($product)->withFields($this->getFields($product));
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
            'partner_id' => 'required|in:'.implode(',', (new AdminPartnerController)->getEnabledPartnersKeys()),
            'service_id' => 'required',
            'product' => 'required'
        ]);

        $product->update($request->all());

        return redirect(route(explode('/', $request->path())[1].'.show', $product));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect(route(explode('/', request()->path())[1].'.index'));
    }

    /**
     * Build Blade edit & create form fields
     *
     * @return Array
     */
    public function getFields(Product $product)
    {
        $form = new \App\Adminux\Form($product);
        $form->addFields([
            $form->display([ 'label' => 'ID' ]),
            $form->select([ 'label' => 'Partner', 'allows' => (new AdminPartnerController)->getEnabledPartnersKeys() ]),
            $form->select([ 'label' => 'Service' ]),
            $form->text([ 'label' => 'Product' ]),
        ]);

        return $form->getFields();
    }
}

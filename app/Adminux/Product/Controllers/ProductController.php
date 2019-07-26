<?php

namespace App\Adminux\Product\Controllers;

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
            ->addColumn('id2', 'adminux.components.datatables.link_show_link')
            ->addColumn('partner', function($row) { return @$row->partner->partner; })
            ->addColumn('service', function($row) { return @$row->service->service; })
            ->rawColumns(['id2'])
            ->toJson();

        return view('adminux.components.datatables.index')->withDatatables([
            'order' => '[[ 0, "asc" ]]',
            'disableCreateButton' => 1,
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-75">Product</th>
                        <th style="min-width:120px">Service</th>
                        <th style="min-width:120px">Partner</th>
                        <th style="min-width:120px">Created At</th>',

            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "product", name: "product" },
                          { data: "service", name: "service" },
                          { data: "partner", name: "partner" },
                          { data: "created_at", name: "created_at", className: "text-center" }'
        ]);
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

        return view('adminux.components.show')->withModel($product)->withRelations([(new PlanProductController)->getIndex($product)]);
    }
}

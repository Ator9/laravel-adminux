<?php

namespace App\Adminux\Partner\Controllers;

use App\Adminux\Partner\Models\Partner as BaseModel;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class PartnerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BaseModel $model)
    {
        if(request()->ajax()) return Datatables::of($partner::query())
            ->addColumn('id2', 'adminux.components.datatables.link_show_link')
            ->addColumn('active2', 'adminux.components.datatables.status')
            ->addColumn('actions', 'adminux.components.datatables.link_edit_button')
            ->rawColumns(['id2', 'active2', 'actions'])
            ->toJson();

        return view('adminux.components.datatables.index')->withDatatables([
            'order' => '[[ 1, "asc" ]]',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-75">Partner</th>
                        <th style="min-width:60px">Active</th>
                        <th style="min-width:120px">Created At</th>
                        <th>Action</th>',

            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "partner", name: "partner" },
                          { data: "active2", name: "active", className: "text-center" },
                          { data: "created_at", name: "created_at", className: "text-center" },
                          { data: "actions", name: "actions", className: "text-center", orderable: false }'
        ]);
    }

    public function getIndex($obj)
    {
        if(new \ReflectionClass(new BaseModel) == new \ReflectionClass($obj)) {
            $model = $obj->products();
            $title = __('adminux.product');
            $column = 'product';
        } else {
            $model = $obj->partners();
            $title = 'Partner';
            $column = 'partner';
        }

        if(request()->ajax()) {
            if(request()->filled('search.value')) {
                $dt = Datatables::of($model->getRelated()::query())->addColumn('actions', function($row) use ($obj) {
                    $params['action'] = url(request()->route()->getPrefix().'/partner_partnerproduct');
                    $params['table'] = $obj->getTable();
                    $params['id'] = $obj->id;
                    $params['related_id'] = $row->id;
                    return view('adminux.components.datatables.link_add_button', compact('params'));
                });
            } else {
                $dt = Datatables::of($model)->addColumn('actions', function($row) use ($column) {
                    $params['action'] = url(request()->route()->getPrefix().'/partner_partnerproduct/'.$row->id);
                    $params['title']  = 'Delete '.$row->{$column}.'?';
                    return view('adminux.components.datatables.link_delete_button', compact('params'));
                });
            }

            return $dt->rawColumns(['actions'])->toJson();
        }

        return [
            'model' => $model,
            'thead' => '<th class="w-25">'.$title.'</th>
                        <th>Name</th>
                        <th style="min-width:100px">Action</th>',
            'columns' => '{ data: "'.$column.'", name: "'.$column.'" },
                          { data: "name", name: "partner_product.name", searchable: false, defaultContent: "" },
                          { data: "actions", name: "actions", className: "text-center", orderable: false }'
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BaseModel $model)
    {
        if(request()->get('table') == $model->getTable()) {
            $relation = $model->find(request()->get('id'))->products();
        } else {
            $relation = $model->products()->getRelated()->find(request()->get('id'))->partners();
        }

        $relation->attach(request()->get('related_id'));

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(BaseModel $model)
    {
        return view('adminux.components.show')->withModel($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \DB::table((new BaseModel)->products()->getTable())->where('id', '=', $id)->update(['deleted_at' => \Carbon\Carbon::now()]);

        return back();
    }
}

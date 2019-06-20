<?php

namespace App\Adminux\Partner\Controllers;

use App\Adminux\Partner\Models\Partner as BaseModel;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class PartnerProductController extends Controller
{
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
                    $params['action'] = url(request()->route()->getPrefix().'/partnerproduct');
                    $params['table'] = $obj->getTable();
                    $params['id'] = $obj->id;
                    $params['related_id'] = $row->id;
                    return view('adminux.components.datatables.link_add_button', compact('params'));
                });
            } else {
                $dt = Datatables::of($model)->addColumn('actions', function($row) use ($column) {
                    $params['action'] = url(request()->route()->getPrefix().'/partnerproduct/'.$row->id);
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

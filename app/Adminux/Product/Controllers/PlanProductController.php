<?php

namespace App\Adminux\Product\Controllers;

use App\Adminux\Product\Models\Product as BaseModel;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class PlanProductController extends Controller
{
    public function getIndex($obj)
    {
        if(new \ReflectionClass(new BaseModel) == new \ReflectionClass($obj)) {
            $model = $obj->plans();
            $title = __('adminux.plan');
            $column = 'plan';
        } else {
            $model = $obj->products();
            $title = 'Product';
            $column = 'product';
        }

        if(request()->ajax()) {
            $dt = Datatables::of($model)->addColumn('actions', function($row) use ($column) {
                $params['action'] = url(request()->route()->getPrefix().'/adminpartner/'.$row->id);
                $params['title']  = 'Delete '.$row->{$column}.'?';
                return view('adminux.components.datatables.link_delete_button', compact('params'));
            });
            return $dt->rawColumns(['actions'])->toJson();
        }

        return [
            'model' => $model,
            'dom' => '<"float-left">rt<"float-left"i>',
            'thead' => '<th class="w-100">'.$title.'</th>
                        <th style="min-width:100px">Action</th>',
            'columns' => '{ data: "'.$column.'", name: "'.$column.'" },
                          { data: "actions", name: "actions", className: "text-center", orderable: false }'
        ];
    }
}

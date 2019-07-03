<?php

namespace App\Adminux\Product\Controllers;

use App\Adminux\Product\Models\Product as BaseModel;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class PlanProductController extends Controller
{
    public function getIndex($obj)
    {
        $model = $obj->plans();
        $column = 'plan';

        if(request()->ajax()) {
            $dt = Datatables::of($model)->addColumn('actions', function($row) use ($column) {
                $params['action'] = '';
                $params['title']  = 'Delete '.$row->{$column}.'?';
                return view('adminux.components.datatables.link_delete_button', compact('params'));
            });
            return $dt->rawColumns(['actions'])->toJson();
        }

        return [
            'model' => $model,
            'dom' => 'rt<"float-left"i>',
            'thead' => '<th class="w-100">'.__('adminux.plan').'</th>
                        <th style="min-width:100px">Action</th>',
            'columns' => '{ data: "'.$column.'", name: "'.$column.'" },
                          { data: "actions", name: "actions", className: "text-center", orderable: false }'
        ];
    }
}

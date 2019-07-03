<?php

namespace App\Adminux\Product\Controllers;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class PlanProductController extends Controller
{
    public function getIndex($obj)
    {
        $model = $obj->plans();
        $column = 'plan';

        if(request()->ajax()) {
            $dt = Datatables::of($model)->addColumn('id2', function($row) use ($obj) {
                $params['action'] = url(request()->route()->getPrefix().'/product_plan/'.$row->id);
                $id = $row->id;
                return view('adminux.components.datatables.link_show_link', compact('params', 'id'));
            });

            return $dt->rawColumns(['id2'])->toJson();
        }

        return [
            'model' => $model,
            'title' => 'Plans',
            'dom' => 'rt<"float-left"i>',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-100">'.__('adminux.plan').'</th>
                        <th style="min-width:120px">Created At</th>',
            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "'.$column.'", name: "'.$column.'" },
                          { data: "created_at", name: "created_at", className: "text-center" }'
        ];
    }
}

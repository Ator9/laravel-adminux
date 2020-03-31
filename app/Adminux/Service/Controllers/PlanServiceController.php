<?php

namespace App\Adminux\Service\Controllers;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class PlanServiceController extends Controller
{
    public function getIndex($obj)
    {
        $model = $obj->plans();

        if(request()->ajax()) {
            $dt = Datatables::of($model)->addColumn('id2', function($row) use ($model) {
                $params['action'] = url(request()->route()->getPrefix().'/'.$model->getRelated()->getTable().'/'.$row->id);
                $id = $row->id;
                return view('adminux.backend.pages.inc.link_show_link', compact('params', 'id'));
            });

            return $dt->rawColumns(['id2'])->toJson();
        }

        return [
            'model' => $model,
            'dom' => 'rt<"float-left"i>',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-100">'.__('adminux.plan').'</th>
                        <th style="min-width:120px">Created At</th>',
            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "plan", name: "plan" },
                          { data: "created_at", name: "created_at", className: "text-center" }'
        ];
    }
}

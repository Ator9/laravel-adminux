<?php

namespace App\Adminux\Account\Controllers;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class AccountPlanController extends Controller
{
    public function getIndex($obj)
    {
        $model = $obj->plans();

        if(request()->ajax()) {
            $dt = Datatables::of($model)->addColumn('id2', function($row) use ($obj) {
                $params['action'] = url(request()->route()->getPrefix().'/accounts_plans/'.$row->id);
                $id = $row->id;
                return view('adminux.components.datatables.link_show_link', compact('params', 'id'));
            });

            return $dt->rawColumns(['id2'])->toJson();
        }

        return [
            'model' => $model,
            'dom' => 'rt<"float-left"i>',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-100">'.__('adminux.active').'</th>
                        <th style="min-width:120px">Created At</th>',
            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "active", name: "active" },
                          { data: "created_at", name: "created_at", className: "text-center" }'
        ];
    }
}

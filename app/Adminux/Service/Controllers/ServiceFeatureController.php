<?php

namespace App\Adminux\Service\Controllers;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class ServiceFeatureController extends Controller
{
    public function getIndex($obj)
    {
        $model = $obj->features();

        if(request()->ajax()) {
            $dt = Datatables::of($model)->addColumn('id2', function($row) use ($obj) {
                $params['action'] = url(request()->route()->getPrefix().'/services_features/'.$row->id);
                $id = $row->id;
                return view('adminux.pages.inc.link_show_link', compact('params', 'id'));
            });

            return $dt->rawColumns(['id2'])->toJson();
        }

        return [
            'model' => $model,
            'dom' => 'rt<"float-left"i>',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-100">'.__('adminux.feature').'</th>
                        <th style="min-width:120px">Created At</th>',
            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "feature", name: "feature" },
                          { data: "created_at", name: "created_at", className: "text-center" }'
        ];
    }
}

<?php

namespace App\Adminux\Admin\Controllers;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class AdminRoleController extends Controller
{
    public function getIndex($obj)
    {
        if(request()->ajax()) return Datatables::of($obj->admins())->toJson();

        return [
            'model' => $obj->admins(),
            'dom' => 'rt<"float-left"i>p',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-100">Admin</th>',
            'columns' => '{ data: "id", name: "id", className: "text-center" },
                          { data: "email", name: "email" }'
        ];
    }
}

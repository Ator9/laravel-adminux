<?php

namespace App\Adminux\Admin\Controllers;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class AdminRoleController extends Controller
{
    public function getIndex($obj)
    {
        if(request()->ajax()) return Datatables::of($obj->roles())->toJson();

        return [
            'model' => $obj->roles(),
            'dom' => 'rt<"float-start"i>p',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-100">Role</th>',
            'columns' => '{ data: "role_id", name: "role_id", className: "text-center" },
                          { data: "name", name: "name" }',
        ];
    }
}

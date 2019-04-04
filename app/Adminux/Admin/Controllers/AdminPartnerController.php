<?php

namespace App\Adminux\Admin\Controllers;

use App\Adminux\Admin\Models\Admin;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class AdminPartnerController extends Controller
{
    public function getIndex($obj)
    {
        if(new \ReflectionClass(new Admin) == new \ReflectionClass($obj)) {
            $model = $obj->partners();
            $title = __('adminux.name');
            $column = 'name';
        } else {
            $model = $obj->admins();
            $title = 'Admin';
            $column = 'email';
        }

        if(request()->ajax()) {
            if(request()->filled('search.value')) {
                $dt = Datatables::of($model->getRelated()::query())->addColumn('actions', function($row) use ($obj) {
                    $params['action'] = url('/admin/adminpartner');
                    $params['id'] = $obj->id;
                    $params['related_id'] = $row->id;
                    return view('adminux.components.datatables.link_add_button', compact('params'));
                });
            } else {
                $dt = Datatables::of($model)->addColumn('actions', function($row) {
                    $params['action'] = url('/admin/adminpartner/'.$row->id);
                    $params['title']  = 'Delete item #'.$row->id.'?';
                    return view('adminux.components.datatables.link_delete_button', compact('params'));
                });
            }

            return $dt->rawColumns(['actions'])->toJson();
        }

        return [
            'model' => $model,
            'thead' => '<th class="w-100">'.$title.'</th>
                        <th style="min-width:100px">Action</th>',
            'columns' => "{ data: '".$column."', name: '".$column."' },
                          { data: 'actions', name: 'actions', className: 'text-center', orderable: false }"

        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Admin $admin)
    {
        dd(request());
        $request->validate([
            'name'   => 'required|unique:'.$partner->getTable(),
            'active' => 'in:Y,""',
        ]);

        // $admin->partners()->attach(($request->all());

        //         $shop = Shop::find($shop_id);
        // $shop->products()->attach($product_id);

        if(!$request->filled('active')) $request->merge(['active' => 'N']);

        $partner = $partner->create($request->all());

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \DB::table((new Admin)->partners()->getTable())->where('id', '=', $id)->delete();

        return back();
    }
}

<?php

namespace App\Adminux\Account\Controllers;

use App\Adminux\Account\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Account $account)
    {
        if(request()->ajax()) return Datatables::of($account::query())
            ->addColumn('id2', 'adminux.components.datatables.link_show_link')
            ->addColumn('active2', 'adminux.components.datatables.status')
            ->addColumn('partner', function($row) { return @$row->partner->partner; })
            ->rawColumns(['id2', 'active2'])
            ->toJson();

        return view('adminux.components.datatables.index')->withDatatables([
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-25">E-mail</th>
                        <th>Name</th>
                        <th style="min-width:120px">Partner</th>
                        <th style="min-width:60px">Active</th>
                        <th style="min-width:120px">Created At</th>',

            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "email", name: "email" },
                          { data: "name", name: "name" },
                          { data: "partner", name: "partner" },
                          { data: "active2", name: "active", className: "text-center" },
                          { data: "created_at", name: "created_at", className: "text-center" }'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Account $account)
    {
        return view('adminux.components.create')->withModel($account)->withFields($this->getFields($account));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Account $account)
    {
        $request->validate([
            'partner_id' => 'required',
            'email' => 'required|email|unique:'.$account->getTable(),
            'password' => 'required',
            'active' => 'in:Y,""',
        ]);

        $request->merge(['password' => Hash::make($request->password)]);
        if(!$request->filled('name')) $request->merge(['name' => '']);
        if(!$request->filled('active')) $request->merge(['active' => 'N']);

        $account = $account->create($request->all());

        return redirect(route(explode('/', $request->path())[1].'.show', $account));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        return view('adminux.components.show')->withModel($account);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        return view('adminux.components.edit')->withModel($account)->withFields($this->getFields($account));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        $request->validate([
            'partner_id' => 'required',
            'email' => 'required|email|unique:'.$account->getTable().',email,'.$account->id,
            'active' => 'in:Y,""',
        ]);

        if($request->filled('password') && !Hash::check($request->password, $account->password)) {
            $request->merge(['password' => Hash::make($request->password)]);
        } else $request->request->remove('password');

        if(!$request->filled('name')) $request->merge(['name' => '']);
        if(!$request->filled('active')) $request->merge(['active' => 'N']);

        $account->update($request->all());

        return redirect(route(explode('/', $request->path())[1].'.show', $account));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        $account->delete();

        return redirect(route(explode('/', request()->path())[1].'.index'));
    }

    /**
     * Build Blade edit & create form fields
     *
     * @return Array
     */
    public function getFields(Account $account)
    {
        $form = new \App\Adminux\Form($account);
        $form->addFields([
            $form->display([ 'label' => 'ID' ]),
            $form->select([ 'label' => 'Partner' ]),
            $form->email([ 'label' => 'E-mail' ]),
            $form->password([ 'label' => 'Password' ]),
            $form->text([ 'label' => 'Name' ]),
            $form->switch([ 'label' => 'Active' ]),
        ]);

        return $form->getFields();
    }
}

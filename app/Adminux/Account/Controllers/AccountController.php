<?php

namespace App\Adminux\Account\Controllers;

use App\Adminux\Account\Models\Account;
use App\Adminux\Account\Controllers\AccountProductController;
use App\Adminux\Helper;
use App\Adminux\AdminuxController;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class AccountController extends AdminuxController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Account $account)
    {
        if(request()->filled('csv')) {
            request()->query->remove('start'); request()->query->remove('length');
            
            $array = collect(Datatables::of($account->query()->whereIn('partner_id', Helper::getSelectedPartners())))['data'];
            return Excel::download(new \App\Adminux\AdminuxExportArray($array), 'accounts.csv');
        }

        if(request()->ajax()) return Datatables::of($account::query()->whereIn('partner_id', Helper::getSelectedPartners()))
            ->addColumn('id2', 'adminux.pages.inc.link_show_link')
            ->addColumn('active2', 'adminux.pages.inc.status')
            ->addColumn('partner', function($row) { return @$row->partner->partner; })
            ->rawColumns(['id2', 'active2'])
            ->toJson();

        return view('adminux.pages.index')->withDatatables([
            'exportButton' => 1,
            'thead' => '<th style="min-width:30px">ID</th>
                        <th>E-mail</th>
                        <th class="w-25">Account</th>
                        <th style="min-width:120px">Partner</th>
                        <th style="min-width:60px">Active</th>
                        <th style="min-width:120px">Created At</th>',

            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "email", name: "email" },
                          { data: "account", name: "account" },
                          { data: "partner", name: "partner", searchable: false },
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
        return parent::createView($account);
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
            'partner_id' => 'required|in:'.implode(',', Helper::getEnabledPartnersKeys()),
            'email' => 'required|email|unique:'.$account->getTable().',email,NULL,NULL,partner_id,'.$request->partner_id,
            'password' => 'required',
            'account' => 'nullable|unique:'.$account->getTable().',account,NULL,NULL,partner_id,'.$request->partner_id,
            'active' => 'in:Y,""',
        ]);

        $request->merge(['password' => Hash::make($request->password)]);
        if(!$request->filled('active')) $request->merge(['active' => 'N']);

        $account = $account->create($request->all());

        return parent::saveRedirect($account);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        Helper::validatePartner($account);

        if(request()->ajax()) return (new AccountProductController)->getIndex($account);

        return view('adminux.pages.show')->withModel($account)->withRelations([(new AccountProductController)->getIndex($account)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        Helper::validatePartner($account);
        return parent::editView($account);
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
            'partner_id' => 'required|in:'.implode(',', Helper::getEnabledPartnersKeys()),
            'email' => 'required|email|unique:'.$account->getTable().',email,'.$account->id.',id,partner_id,'.$request->partner_id,
            'account' => 'nullable|unique:'.$account->getTable().',account,'.$account->id.',id,partner_id,'.$request->partner_id,
            'active' => 'in:Y,""',
        ]);

        if($request->filled('password') && !Hash::check($request->password, $account->password)) {
            $request->merge(['password' => Hash::make($request->password)]);
        } else $request->request->remove('password');

        if(!$request->filled('active')) $request->merge(['active' => 'N']);

        $account->update($request->all());

        return parent::saveRedirect($account);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        Helper::validatePartner($account);
        return parent::destroyRedirect($account);
    }

    /**
     * Build Blade edit & create form fields
     *
     * @return Array
     */
    public function getFields(Account $account)
    {
        $form = new \App\Adminux\Form($account);
        return [
            $form->display([ 'label' => 'ID' ]),
            $form->select([ 'label' => 'Partner', 'allows' => Helper::getEnabledPartnersKeys() ]),
            $form->email([ 'label' => 'E-mail' ]),
            $form->password([ 'label' => 'Password' ]),
            $form->text([ 'label' => 'Account' ]),
            $form->moduleConfig([ 'label' => 'Default Config' ]),
            $form->switch([ 'label' => 'Active' ]),
        ];
    }
}

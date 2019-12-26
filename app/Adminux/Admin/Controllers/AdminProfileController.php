<?php

namespace App\Adminux\Admin\Controllers;

use App\Adminux\Admin\Models\Admin;
use Illuminate\Http\Request;
use App\Adminux\AdminuxController;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends AdminuxController
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        $admin = $admin->find(auth('adminux')->user()->id);

        return view('adminux.pages.show')->withModel($admin);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        $admin = $admin->find(auth('adminux')->user()->id);

        return parent::editView($admin);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $admin = $admin->find(auth('adminux')->user()->id);

        $request->validate([
            'id' => 'in:'.$admin->id,
            'email'    => 'required|email|unique:'.$admin->getTable().',email,'.$admin->id,
            'language_id' => 'required',
        ]);

        if($request->filled('password') && !Hash::check($request->password, $admin->password)) {
            $request->merge(['password' => Hash::make($request->password)]);
        } else $request->request->remove('password');

        if(!$request->filled('firstname')) $request->merge(['firstname' => '']);
        if(!$request->filled('lastname')) $request->merge(['lastname' => '']);

        $admin->update($request->only(['email', 'password', 'firstname', 'lastname', 'language_id']));

        return redirect(route(explode('/', request()->path())[1].'.show'));
    }

    /**
     * Build Blade edit & create form fields
     *
     * @return Array
     */
    public function getFields(Admin $admin)
    {
        $form = new \App\Adminux\Form($admin);
        return [
            $form->display([ 'label' => 'ID' ]),
            $form->email([ 'label' => 'E-mail' ]),
            $form->password([ 'label' => 'Password' ]),
            $form->text([ 'label' => 'First Name' ]),
            $form->text([ 'label' => 'Last Name' ]),
            $form->select([ 'label' => 'Language' ]),
        ];
    }
}

<?php

namespace App\Adminux\Admin\Controllers;

use App\Adminux\Admin\Models\Currency;
use Illuminate\Http\Request;
use App\Adminux\AdminuxController;
use Yajra\Datatables\Datatables;

class CurrencyController extends AdminuxController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Currency $currency)
    {
        if(request()->ajax()) return Datatables::of($currency::query())
            ->addColumn('id2', 'adminux.components.datatables.link_show_link')
            ->rawColumns(['id2'])
            ->toJson();

        return view('adminux.components.datatables.index')->withDatatables([
            'order' => '[[ 0, "asc" ]]',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-75">Currency</th>
                        <th style="min-width:120px">Created At</th>',

            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "currency", name: "currency" },
                          { data: "created_at", name: "created_at", className: "text-center" }'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Currency $currency)
    {
        return view('adminux.components.create')->withModel($currency)->withFields($this->getFields($currency));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Currency $currency)
    {
        $request->validate([
            'currency' => 'required|max:3|unique:'.$currency->getTable(),
        ]);

        $currency = $currency->create($request->all());

        return redirect(route(explode('/', $request->path())[1].'.show', $currency));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        return view('adminux.components.show')->withModel($currency);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        return parent::editView(func_get_arg(0));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency)
    {
        $request->validate([
            'currency'   => 'required|max:3|unique:'.$currency->getTable().',currency,'.$currency->id,
        ]);

        $currency->update($request->all());

        return redirect(route(explode('/', $request->path())[1].'.show', $currency));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();

        return redirect(route(explode('/', request()->path())[1].'.index'));
    }

    /**
     * Build Blade edit & create form fields
     *
     * @return Array
     */
    public function getFields(Currency $currency)
    {
        $form = new \App\Adminux\Form($currency);
        $form->addFields([
            $form->display([ 'label' => 'ID' ]),
            $form->text([ 'label' => 'Currency' ]),
        ]);

        return $form->getFields();
    }
}

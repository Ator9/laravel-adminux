<?php

namespace App\Adminux\Product\Controllers;

use App\Adminux\Product\Models\Plan;
use App\Adminux\Helper;
use App\Adminux\Admin\Controllers\AdminPartnerController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Plan $plan)
    {
        if(request()->ajax()) return Datatables::of($plan::query()->whereIn('partner_id', (new AdminPartnerController)->getSelectedPartners()))
            ->addColumn('id2', 'adminux.components.datatables.link_show_link')
            ->addColumn('partner', function($row) { return @$row->partner->partner; })
            ->addColumn('service', function($row) { return @$row->service->service; })
            ->rawColumns(['id2'])
            ->toJson();

        return view('adminux.components.datatables.index')->withDatatables([
            'order' => '[[ 0, "asc" ]]',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-75">Plan</th>
                        <th style="min-width:300px">Service</th>
                        <th style="min-width:120px">Partner</th>
                        <th style="min-width:120px">Created At</th>',

            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "product", name: "product" },
                          { data: "service", name: "service" },
                          { data: "partner", name: "partner" },
                          { data: "created_at", name: "created_at", className: "text-center" }'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Plan $plan)
    {
        return view('adminux.components.create')->withModel($plan)->withFields($this->getFields($plan));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Plan $plan)
    {
        $request->validate([
            'partner_id' => 'required|in:'.implode(',', (new AdminPartnerController)->getEnabledPartnersKeys()),
            'service_id' => 'required',
            'product' => 'required'
        ]);

        $plan = $plan->create($request->all());

        return redirect(route(explode('/', $request->path())[1].'.show', $plan));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        Helper::validatePartner($plan);
        return view('adminux.components.show')->withModel($plan);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        Helper::validatePartner($plan);
        return view('adminux.components.edit')->withModel($plan)->withFields($this->getFields($plan));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plan $plan)
    {
        $request->validate([ 'product' => 'required' ]);

        $plan->update($request->only(['product']));

        return redirect(route(explode('/', $request->path())[1].'.show', $plan));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        Helper::validatePartner($plan);
        $plan->delete();

        return redirect(route(explode('/', request()->path())[1].'.index'));
    }

    /**
     * Build Blade edit & create form fields
     *
     * @return Array
     */
    public function getFields(Plan $plan)
    {
        $form = new \App\Adminux\Form($plan);
        $form->addFields([
            $form->display([ 'label' => 'ID' ]),
            $form->select([ 'label' => 'Partner', 'editable' => false, 'allows' => (new AdminPartnerController)->getEnabledPartnersKeys() ]),
            $form->select([ 'label' => 'Service', 'editable' => false ]),
            $form->text([ 'label' => 'Plan' ]),
        ]);

        return $form->getFields();
    }
}

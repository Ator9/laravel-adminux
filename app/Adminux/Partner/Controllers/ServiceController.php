<?php

namespace App\Adminux\Partner\Controllers;

use App\Adminux\Service\Models\Service;
use App\Adminux\Service\Controllers\PlanServiceController;
use App\Adminux\Helper;
use Illuminate\Http\Request;
use App\Adminux\AdminuxController;
use Yajra\Datatables\Datatables;

class ServiceController extends AdminuxController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Service $service)
    {
        if(request()->ajax()) return Datatables::of($service::query()->whereIn('partner_id', Helper::getSelectedPartners()))
            ->addColumn('id2', 'adminux.pages.inc.link_show_link')
            ->addColumn('partner', function($row) { return @$row->partner->partner; })
            ->addColumn('software', function($row) { return @$row->software->software; })
            ->addColumn('currency_price', function($row) {
                return '<small>'.$row->interval.'</small> '.@$row->currency->currency.' '.$row->price;
            })
            ->rawColumns(['id2', 'currency_price'])
            ->toJson();

        return view('adminux.pages.index')->withDatatables([
            'order' => '[[ 0, "asc" ]]',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-75">Service</th>
                        <th style="min-width:120px">Price</th>
                        <th style="min-width:120px">Software</th>
                        <th style="min-width:120px">Partner</th>
                        <th style="min-width:120px">Created At</th>',

            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "service", name: "service" },
                          { data: "currency_price", name: "currency_price", className: "text-right" },
                          { data: "software", name: "software" },
                          { data: "partner", name: "partner" },
                          { data: "created_at", name: "created_at", className: "text-center" }'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Service $service)
    {
        return parent::createView($service);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Service $service)
    {
        $request->validate([
            'partner_id' => 'required|in:'.implode(',', Helper::getEnabledPartnersKeys()),
            'software_id' => 'required',
            'service' => 'required',
            'domain' => 'nullable|url',
            'currency_id' => 'required',
            'price' => 'numeric|between:0,9999999.99',
            'interval' => 'required',
        ]);

        $service = $service->create($request->all());

        return parent::saveRedirect($service);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        Helper::validatePartner($service);

        if(request()->ajax()) return (new PlanServiceController)->getIndex($service);

        return view('adminux.pages.show')->withModel($service)->withRelations([(new PlanServiceController)->getIndex($service)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        Helper::validatePartner($service);
        return parent::editView($service);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'service' => 'required',
            'domain' => 'nullable|url',
            'currency_id' => 'required',
            'price' => 'numeric|between:0,9999999.99',
            'interval' => 'required',
        ]);
        Helper::validatePartner($service);

        // Price History:
        if(date('Ym') > $service->created_at->format('Ym')) {
            $history = (array) $service->price_history;
            if(!array_key_exists(date('Ym', strtotime('last month')), $history)) {
                $history[date('Ym', strtotime('last month'))] = [
                    'price' => $service->price,
                    'currency_id' => $service->currency_id,
                    'interval' => $service->interval
                ];
            }
            $request->merge(['price_history' => $history]);
        }

        $service->update($request->only(['service', 'domain', 'currency_id', 'price', 'interval', 'price_history']));

        return parent::saveRedirect($service);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        Helper::validatePartner($service);
        return parent::destroyRedirect($service);
    }

    /**
     * Build Blade edit & create form fields
     *
     * @return Array
     */
    public function getFields(Service $service)
    {
        $form = new \App\Adminux\Form($service);
        return [
            $form->display([ 'label' => 'ID' ]),
            $form->select([ 'label' => 'Partner', 'editable' => false, 'allows' => Helper::getEnabledPartnersKeys() ]),
            $form->select([ 'label' => 'Software', 'editable' => false ]),
            $form->text([ 'label' => 'Service' ]),
            $form->text([ 'label' => 'Domain' ]),
            $form->select([ 'label' => 'Currency' ]),
            $form->text([ 'label' => 'Price' ]),
            $form->enum([ 'label' => 'Interval' ]),
        ];
    }
}

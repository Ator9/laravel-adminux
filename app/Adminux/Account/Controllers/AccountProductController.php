<?php

namespace App\Adminux\Account\Controllers;

use App\Adminux\Account\Models\AccountProduct;
use App\Adminux\Helper;
use Illuminate\Http\Request;
use App\Adminux\AdminuxController;
use Yajra\Datatables\Datatables;

class AccountProductController extends AdminuxController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AccountProduct $product)
    {
        if(request()->ajax()) return Datatables::of($product::query()
            ->join('services_plans', 'services_plans.id', '=', 'accounts_products.plan_id')
            ->join('services', 'services.id', '=', 'services_plans.service_id')
            ->join('partners', 'partners.id', '=', 'services.partner_id')
            ->join('software', 'software.id', '=', 'services.software_id')
            ->join('accounts', 'accounts.id', '=', 'accounts_products.account_id')
            ->whereIn('services_plans.service_id', Helper::getSelectedServices())
            ->select('accounts_products.id','accounts_products.active','accounts.email','services_plans.plan','services.service','software.software','partners.partner','accounts_products.created_at'))
            ->addColumn('active2', 'adminux.pages.inc.status')
            ->addColumn('id2', 'adminux.pages.inc.link_show_link')
            ->rawColumns(['id2', 'active2'])
            ->toJson();

        return view('adminux.pages.index')->withDatatables([
            'order' => '[[ 0, "asc" ]]',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-75">E-mail</th>
                        <th style="min-width:120px">Plan</th>
                        <th style="min-width:120px">Service</th>
                        <th style="min-width:120px">Software</th>
                        <th style="min-width:120px">Partner</th>
                        <th style="min-width:60px">Active</th>
                        <th style="min-width:120px">Created At</th>',

            'columns' => '{ data: "id2", name: "accounts_products.id", className: "text-center" },
                          { data: "email", name: "accounts.email" },
                          { data: "plan", name: "services_plans.plan" },
                          { data: "service", name: "services.service" },
                          { data: "software", name: "software.software" },
                          { data: "partner", name: "partners.partner" },
                          { data: "active2", name: "active", className: "text-center" },
                          { data: "created_at", name: "accounts_products.created_at", className: "text-center" }'
        ]);
    }

    public function getIndex($obj)
    {
        $model = $obj->products();

        if(request()->ajax()) {
            $dt = Datatables::of($model)->addColumn('id2', function($row) use ($model) {
                $params['action'] = url(request()->route()->getPrefix().'/'.$model->getRelated()->getTable().'/'.$row->id);
                $id = $row->id;
                return view('adminux.pages.inc.link_show_link', compact('params', 'id'));
            });

            return $dt->rawColumns(['id2'])->toJson();
        }

        return [
            'model' => $model,
            'dom' => 'rt<"float-left"i>',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-100">'.__('adminux.active').'</th>
                        <th style="min-width:120px">Created At</th>',
            'columns' => '{ data: "id2", name: "id", className: "text-center" },
                          { data: "active", name: "active" },
                          { data: "created_at", name: "created_at", className: "text-center" }'
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(AccountProduct $product)
    {
        return parent::createView($product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AccountProduct $product)
    {
        $request->validate([
            'account_id' => 'required',
            'plan_id' => 'required',
            'active' => 'in:Y,""',
        ]);

        Helper::validateAccount($request);
        Helper::validateAccountWithService($request->account_id, $request->plan_id);

        if(!$request->filled('active')) $request->merge(['active' => 'N']);

        $product = $product->create($request->all());

        return parent::saveRedirect($product);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(AccountProduct $product)
    {
        Helper::validateAccount($product);

        if($this->checkSoftwareClass($product)) return $this->getSoftwareClass($product);

        return view('adminux.pages.show')->withModel($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountProduct $product)
    {
        Helper::validateAccount($product);

        if($this->checkSoftwareClass($product)) return $this->getSoftwareClass($product);

        return parent::editView($product, [ 'fields' => $this->getSoftwareFields($product)]);
    }

    public function editSoftware(AccountProduct $product)
    {
        Helper::validateAccount($product);

        if($this->checkSoftwareClass($product)) return $this->getSoftwareClass($product);
        return abort(500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(AccountProduct $product)
    {
        request()->validate([
            'account_id' => 'required',
            'active' => 'in:Y,N,""',
        ]);

        Helper::validateAccount(request());
        Helper::validateAccountWithService(request()->account_id, $product->plan_id);

        if(!request()->filled('active')) request()->merge(['active' => 'N']);

        if($this->checkSoftwareClass($product)) return $this->getSoftwareClass($product);

        $product->update(request()->only(['account_id','module_config','active']));

        return parent::saveRedirect($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountProduct $product)
    {
        Helper::validateAccount($product);
        return parent::destroyRedirect($product);
    }

    public function checkSoftwareClass(AccountProduct $product)
    {
        $software_class = (clone $product)->plan->service->software->software_class;
        if(class_exists($software_class)) {
            $class = class_basename((new \ReflectionClass($software_class))->getMethod(debug_backtrace()[1]['function'])->class);
            if($class != 'AccountProductController') return true;
        }
        return false;
    }

    public function getSoftwareClass(AccountProduct $product)
    {
        $software_class = (clone $product)->plan->service->software->software_class;
        return (new $software_class)->{debug_backtrace()[1]['function']}($product);
    }

    public function getSoftwareFields(AccountProduct $product)
    {
        $software_class = (clone $product)->plan->service->software->software_class;
        if(class_exists($software_class)) return (new $software_class)->getFields($product);
    }

    /**
     * Build Blade edit & create form fields
     *
     * @return Array
     */
    public function getFields(AccountProduct $product)
    {
        $form = new \App\Adminux\Form($product);
        return [
            $form->display([ 'label' => 'ID' ]),
            $form->select([ 'label' => 'Account', 'allows' => Helper::getEnabledAccountsKeys() ]),
            $form->select([ 'label' => 'Plan', 'editable' => false ]),
            $form->moduleConfig([ 'label' => 'Default Config' ]),
            $form->switch([ 'label' => 'Active' ]),
        ];
    }
}

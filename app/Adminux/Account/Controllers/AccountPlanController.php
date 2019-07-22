<?php

namespace App\Adminux\Account\Controllers;

use App\Adminux\Account\Models\AccountPlan;
use App\Adminux\Helper;
use Illuminate\Http\Request;
use App\Adminux\AdminuxController;
use Yajra\Datatables\Datatables;

class AccountPlanController extends AdminuxController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AccountPlan $plan)
    {
        if(request()->ajax()) return Datatables::of($plan::query()
            ->join('products_plans', 'products_plans.id', '=', 'accounts_plans.plan_id')
            ->join('products', 'products.id', '=', 'products_plans.product_id')
            ->join('partners', 'partners.id', '=', 'products.partner_id')
            ->join('services', 'services.id', '=', 'products.service_id')
            ->join('accounts', 'accounts.id', '=', 'accounts_plans.account_id')
            ->whereIn('products_plans.product_id', Helper::getSelectedProducts())
            ->select('accounts_plans.id','accounts_plans.active','accounts.email','products_plans.plan','products.product','services.service','partners.partner','accounts_plans.created_at'))
            ->addColumn('active2', 'adminux.components.datatables.status')
            ->addColumn('id2', 'adminux.components.datatables.link_show_link')
            ->rawColumns(['id2', 'active2'])
            ->toJson();

        return view('adminux.components.datatables.index')->withDatatables([
            'order' => '[[ 0, "asc" ]]',
            'thead' => '<th style="min-width:30px">ID</th>
                        <th class="w-75">E-mail</th>
                        <th style="min-width:120px">Plan</th>
                        <th style="min-width:120px">Product</th>
                        <th style="min-width:120px">Service</th>
                        <th style="min-width:120px">Partner</th>
                        <th style="min-width:60px">Active</th>
                        <th style="min-width:120px">Created At</th>',

            'columns' => '{ data: "id2", name: "accounts_plans.id", className: "text-center" },
                          { data: "email", name: "accounts.email" },
                          { data: "plan", name: "products_plans.plan" },
                          { data: "product", name: "products.product" },
                          { data: "service", name: "services.service" },
                          { data: "partner", name: "partners.partner" },
                          { data: "active2", name: "active", className: "text-center" },
                          { data: "created_at", name: "accounts_plans.created_at", className: "text-center" }'
        ]);
    }

    public function getIndex($obj)
    {
        $model = $obj->plans();

        if(request()->ajax()) {
            $dt = Datatables::of($model)->addColumn('id2', function($row) use ($model) {
                $params['action'] = url(request()->route()->getPrefix().'/'.$model->getRelated()->getTable().'/'.$row->id);
                $id = $row->id;
                return view('adminux.components.datatables.link_show_link', compact('params', 'id'));
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
    public function create(AccountPlan $plan)
    {
        return view('adminux.components.create')->withModel($plan)->withFields($this->getFields($plan));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AccountPlan $plan)
    {
        $request->validate([
            'account_id' => 'required',
            'plan_id' => 'required',
            'active' => 'in:Y,""',
        ]);

        Helper::validateAccount($request);
        Helper::validateAccountWithProduct($request->account_id, $request->plan_id);

        if(!$request->filled('active')) $request->merge(['active' => 'N']);

        $plan = $plan->create($request->all());

        return redirect(route(explode('/', $request->path())[1].'.show', $plan));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(AccountPlan $plan)
    {
        if($this->checkServiceClass($plan)) return $this->getServiceClass($plan);

        Helper::validateAccount($plan);
        return view('adminux.components.show')->withModel($plan);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountPlan $plan)
    {
        if($this->checkServiceClass($plan)) return $this->getServiceClass($plan);

        Helper::validateAccount($plan);
        return parent::editView($plan, [ 'fields' => $this->getServiceFields($plan)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccountPlan $plan)
    {
        $request->validate([
            'account_id' => 'required',
            'active' => 'in:Y,""',
        ]);

        Helper::validateAccount($request);
        Helper::validateAccountWithProduct($request->account_id, $plan->plan_id);

        if(!$request->filled('active')) $request->merge(['active' => 'N']);

        $plan->update($request->only(['account_id','active']));

        return redirect(route(explode('/', $request->path())[1].'.show', $plan));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountPlan $plan)
    {
        Helper::validateAccount($plan);
        $plan->delete();

        return redirect(route(explode('/', request()->path())[1].'.index'));
    }

    public function checkServiceClass(AccountPlan $plan)
    {
        $service_class = (clone $plan)->plan->product->service->class_name;
        if(class_exists($service_class)) {
            $class = class_basename((new \ReflectionClass($service_class))->getMethod(debug_backtrace()[1]['function'])->class);
            if($class != 'AccountPlanController') return true;
        }
        return false;
    }

    public function getServiceClass(AccountPlan $plan)
    {
        $service_class = (clone $plan)->plan->product->service->class_name;
        return (new $service_class)->{debug_backtrace()[1]['function']}($plan);
    }

    public function getServiceFields(AccountPlan $plan)
    {
        $service_class = (clone $plan)->plan->product->service->class_name;
        if(class_exists($service_class)) return (new $service_class)->getFields($plan);
    }

    /**
     * Build Blade edit & create form fields
     *
     * @return Array
     */
    public function getFields(AccountPlan $plan)
    {
        $form = new \App\Adminux\Form($plan);
        $form->addFields([
            $form->display([ 'label' => 'ID' ]),
            $form->select([ 'label' => 'Account', 'allows' => Helper::getEnabledAccountsKeys() ]),
            $form->select([ 'label' => 'Plan', 'editable' => false ]),
            $form->switch([ 'label' => 'Active' ]),
        ]);

        return $form->getFields();
    }
}

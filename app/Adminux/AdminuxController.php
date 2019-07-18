<?php

namespace App\Adminux;

class AdminuxController extends \App\Http\Controllers\Controller
{
    // public function showView($model, ...$args)
    // {
    //     foreach($args as $controller) {
    //         dd($controller);
    //
    //     }
    //     if(request()->ajax()) return (new AccountPlanController)->getIndex($account);
    //
    //     return view('adminux.components.show')->withModel($account)->withRelations([(new AccountPlanController)->getIndex($account)]);
    // }

    public function editView($model, $params = [])
    {
        return view('adminux.components.edit')->withModel($model)->withFields(!empty($params['fields']) ? $params['fields'] : $this->getFields($model));
    }
}

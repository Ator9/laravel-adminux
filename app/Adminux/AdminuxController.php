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
    //     return view('adminux.pages.show')->withModel($account)->withRelations([(new AccountPlanController)->getIndex($account)]);
    // }

    public function editView($model, $params = [])
    {
        $fields = !empty($params['fields']) ? $params['fields'] : $this->getFields($model);

        return view('adminux.pages.edit')->withModel($model)->withFields($fields);
    }

    public function updateRedirect($model)
    {
        if(request()->filled('continue_editing_form')) return back();
        return redirect(route(explode('/', request()->path())[1].'.show', $model));
    }
}

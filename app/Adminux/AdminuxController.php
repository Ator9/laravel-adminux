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

    public function createView($model, $params = [])
    {
        $fields = !empty($params['fields']) ? $params['fields'] : $this->getFields($model);

        return view('adminux.pages.create')->withModel($model)->withFields($fields);
    }

    public function editView($model, $params = [])
    {
        $fields = !empty($params['fields']) ? $params['fields'] : $this->getFields($model);

        return view('adminux.pages.edit')->withModel($model)->withFields($fields);
    }

    // Store / Update Redirect:
    public function saveRedirect($model)
    {
        if(request()->filled('continue_editing_form')) return back();
        return redirect(route(explode('/', request()->path())[1].'.show', $model));
    }

    // Destroy Redirect:
    public function destroyRedirect()
    {
        return redirect(route(explode('/', request()->path())[1].'.index'));
    }
}

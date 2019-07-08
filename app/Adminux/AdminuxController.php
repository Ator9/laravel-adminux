<?php

namespace App\Adminux;

class AdminuxController extends \App\Http\Controllers\Controller
{
    // public function showView($model)
    // {
    //     return view('adminux.components.edit')->withModel($model)->withFields($this->getFields($model));
    // }

    public function editView($model, ...$args)
    {
        return view('adminux.components.edit')->withModel($model)->withFields($this->getFields($model));
    }
}

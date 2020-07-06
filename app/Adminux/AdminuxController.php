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
    //     return view('adminux.backend.pages.show')->withModel($account)->withRelations([(new AccountPlanController)->getIndex($account)]);
    // }

    public function createView($model, $params = [])
    {
        $fields = !empty($params['fields']) ? $params['fields'] : $this->getFields($model);

        return view('adminux.backend.pages.create')->withModel($model)->withFields($fields);
    }

    public function editView($model, $params = [])
    {
        $fields = !empty($params['fields']) ? $params['fields'] : $this->getFields($model);

        return view('adminux.backend.pages.edit')->withModel($model)->withFields($fields);
    }

    // Store / Update Redirect:
    public function saveRedirect($model)
    {
        if(request()->filled('continue_editing_form')) return back();
        return redirect(route(explode('/', request()->path())[1].'.show', $model)); // model with data: $model = $model->create();
    }

    // Destroy Redirect:
    public function destroyRedirect($model = '')
    {
        if(!empty($model)) $model->delete();
        return redirect(route(explode('/', request()->path())[1].'.index'));
    }

    public function fileManagerUpload($model)
    {
        request()->validate([
            'files.*' => 'required|max:'.min((int) ini_get('upload_max_filesize'), (int) ini_get('post_max_size')) * 1024,
        ]);

        $path = 'public/'.$model->getTable().'/'.$model->id;

        foreach(request()->file('files') as $file) {
            $name = $file->getClientOriginalName();
            if(file_exists(storage_path('app/'.$path.'/'.$name))) $name = time().'_'.$name;
            $file->storeAs($path, $name);
        }

        return back();
    }

    public function fileManagerDelete($model)
    {
        $path = 'public/'.$model->getTable().'/'.$model->id.'/'.request()->name;
        \Storage::delete($path);

        return back();
    }
}

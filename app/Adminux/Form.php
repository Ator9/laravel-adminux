<?php

namespace App\Adminux;

class Form
{
    static function input($params = [])
    {
        return '<div class="form-group row">
                    '.self::getLabel($params).'
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="email@example.com">
                    </div>
                </div>';
    }

    static function text($params = [])
    {
        return '<div class="form-group row">
                    '.self::getLabel($params).'
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="email@example.com">
                    </div>
                </div>';
    }

    static function textarea($params = [])
    {

    }

    static function getLabel($params = [])
    {
        $id = (!empty($params['id'])) ? $params['id'] : $params['label'];

        return '<label class="col-sm-2 col-form-label text-muted" for="'.$id.'">'.$params['label'].'</label>';
    }
}

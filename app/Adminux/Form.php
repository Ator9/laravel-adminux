<?php

namespace App\Adminux;

class Form
{
    public function __construct($model = '')
    {
        $this->_model = $model;
    }

    public function display($params = [])
    {
        return '<div class="form-group row">
                    '.self::getLabel($params).'
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" id="'.$this->getValidId($params).'" value="'.$this->_model->getAttributes()[$params['name']].'">
                    </div>
                </div>';
    }

    public function boolean($params = [])
    {
        return '<div class="form-group row">
                    '.self::getLabel($params).'
                    <div class="col-sm-10 custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="'.$this->getValidId($params).'">
                        <label class="custom-control-label" for="'.$this->getValidId($params).'">Toggle this switch element</label>
                    </div>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" id="'.$this->getValidId($params).'" value="'.$this->_model->getAttributes()[$params['name']].'">
                    </div>
                </div>';
    }

    public function email($params = [])
    {
        return '<div class="form-group row">
                    '.self::getLabel($params).'
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="'.$this->getValidId($params).'" name="'.$params['name'].'" value="'.$this->_model->getAttributes()[$params['name']].'">
                    </div>
                </div>';
    }

    public function text($params = [])
    {
        return '<div class="form-group row">
                    '.self::getLabel($params).'
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="'.$this->getValidId($params).'" name="'.$params['name'].'" value="'.$this->_model->getAttributes()[$params['name']].'">
                    </div>
                </div>';
    }

    public function textarea($params = [])
    {

    }

    public function getLabel($params = [])
    {
        return '<label class="col-sm-2 col-form-label text-muted" for="'.$this->getValidId($params).'">'.$params['label'].'</label>';
    }

    public function getValidId($params = [])
    {
        return (!empty($params['id'])) ? $params['id'] : $params['name'];
    }
}

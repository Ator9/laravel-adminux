<?php

namespace App\Adminux;

class Form
{
    private $_model;
    private $_fields = [];

    public $_label_cls = 'col-sm-2 col-form-label text-muted';
    public $_checkbox_value = 'Y';
    public $_checked_if = [1, 'on', 'true', 'y', 'yes'];

    public function __construct($model = '')
    {
        $this->_model = $model;
    }

    public function display($params = [])
    {
        return '<div class="form-group row">
                    '.self::getLabel($params).'
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" id="'.$this->getValidId($params).'" name="'.$this->getName($params).'" value="'.$this->getValue($params).'">
                    </div>
                </div>';
    }

    public function switch($params = [])
    {
        $value   = (!empty($params['value'])) ? $params['value'] : $this->_checkbox_value;
        $checked = (in_array(strtolower($this->getValue($params)), $this->_checked_if)) ? ' checked' : '';

        return '<div class="form-group row">
                    '.self::getLabel($params).'
                    <div class="col-sm-10 custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="'.$this->getValidId($params).'" name="'.$this->getName($params).'" value="'.$value.'"'.$checked.'>
                        <label class="custom-control-label ml-3 mt-1" for="'.$this->getValidId($params).'"></label>
                    </div>
                </div>';
    }

    public function email($params = [])
    {
        return '<div class="form-group row">
                    '.self::getLabel($params).'
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="'.$this->getValidId($params).'" name="'.$this->getName($params).'" value="'.$this->getValue($params).'">
                    </div>
                </div>';
    }

    public function text($params = [])
    {
        return '<div class="form-group row">
                    '.self::getLabel($params).'
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="'.$this->getValidId($params).'" name="'.$this->getName($params).'" value="'.$this->getValue($params).'">
                    </div>
                </div>';
    }

    public function textarea($params = [])
    {

    }

    public function html($text = '')
    {
        return $text;
    }

    public function getLabel($params = [])
    {
        return '<label class="'.$this->_label_cls.'" for="'.$this->getValidId($params).'">'.$params['label'].'</label>';
    }

    public function getValidId($params = [])
    {
        if(!empty($params['id'])) return $params['id'];
        elseif(!empty($params['name'])) return $params['name'];
        else return $this->getName($params);
    }

    public function getName($params = [])
    {
        if(!empty($params['name'])) return $params['name'];

        if(!empty($params['label'])) {
            foreach($this->_model->getAttributes() as $key => $value) {
                if(strcasecmp($key, $params['label']) == 0) return $key;
                elseif(strcasecmp($key, str_replace(['-', ' '], '', $params['label'])) == 0) return $key;
                elseif(strcasecmp($key, str_replace(['-', ' '], '_', $params['label'])) == 0) return $key;
            }
        }

        return '';
    }

    public function getValue($params = [])
    {
        if(!empty($params['value'])) return $params['value'];

        return old($this->getName($params), $this->_model->getAttributes()[$this->getName($params)]);
    }

    public function addFields($fields = [])
    {
        $this->_fields = array_merge($this->_fields, $fields);
    }

    public function getFields($fields = [])
    {
        return $this->_fields;
    }
}

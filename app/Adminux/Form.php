<?php

namespace App\Adminux;

class Form
{
    protected $_model;
    protected $_fields = [];

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
                    '.$this->getLabel($params).'
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" id="'.$this->getId($params).'" name="'.$this->getName($params).'" value="'.$this->getValue($params).'">
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
                        <input type="hidden" name="'.$this->getName($params).'">
                        <input type="checkbox" class="custom-control-input" id="'.$this->getId($params).'" name="'.$this->getName($params).'" value="'.$value.'"'.$checked.'>
                        <label class="custom-control-label ml-3 mt-1" for="'.$this->getId($params).'"></label>
                    </div>
                </div>';
    }

    public function email($params = [])
    {
        return '<div class="form-group row">
                    '.self::getLabel($params).'
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="'.$this->getId($params).'" name="'.$this->getName($params).'" value="'.$this->getValue($params).'">
                    </div>
                </div>';
    }

    public function password($params = [])
    {
        return '<div class="form-group row">
                    '.self::getLabel($params).'
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="'.$this->getId($params).'" name="'.$this->getName($params).'" value="'.$this->getValue($params).'">
                    </div>
                </div>';
    }

    public function text($params = [])
    {
        return '<div class="form-group row">
                    '.self::getLabel($params).'
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="'.$this->getId($params).'" name="'.$this->getName($params).'" value="'.$this->getValue($params).'">
                    </div>
                </div>';
    }

    public function textarea($params = [])
    {

    }

    public function html($html = '')
    {
        return $html;
    }

    public function getLabel($params = [])
    {
        return '<label class="'.$this->_label_cls.'" for="'.$this->getId($params).'">'.$params['label'].'</label>';
    }

    public function getId($params = [])
    {
        if(!empty($params['id'])) return $params['id'];
        elseif(!empty($params['name'])) return $params['name'];
        else return $this->getName($params);
    }

    public function getName($params = [])
    {
        if(!empty($params['name'])) return $params['name'];

        if(!empty($params['label'])) {
            if(strcasecmp($params['label'], 'id') == 0) return 'id';

            foreach($this->_model->getFillable() as $key) {
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

        return old($this->getName($params), @$this->_model->getAttributes()[$this->getName($params)]);
    }

    public function addFields($fields = [])
    {
        $this->_fields = array_merge($this->_fields, $fields);
    }

    public function getFields()
    {
        return $this->_fields;
    }
}

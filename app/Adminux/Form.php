<?php

namespace App\Adminux;

class Form
{
    protected $_model;
    protected $_fields = [];

    public $_label_cls = 'col-sm-2 col-form-label text-muted';
    public $_input_cls = 'col-sm-10';
    public $_checkbox_value = 'Y';
    public $_checked_if = [1, 'on', 'true', 'y', 'yes'];

    public function __construct($model = '')
    {
        $this->_model = $model;
    }

    public function display($params)
    {
        $params['input'] = '<input type="text" readonly class="form-control-plaintext" id="'.$this->getId($params).'" name="'.$this->getName($params).'" value="'.$this->getValue($params).'">';
        return $this->getFormGroup($params);
    }

    public function email($params)
    {
        $params['input'] = '<input type="email" class="form-control" id="'.$this->getId($params).'" name="'.$this->getName($params).'" value="'.$this->getValue($params).'">';
        return $this->getFormGroup($params);
    }

    public function moduleConfig($params)
    {
        $path = (!empty($params['path'])) ? $params['path'] : class_basename($this->_model);
        $config = \App\Adminux\Helper::getConfig($path);

        if(!empty($config[$path]['default_config'])) {
            $values = json_decode($this->getValue($params), true);
            foreach($config[$path]['default_config'] as $key => $desc) {
                $params['input'][] = '<tr>
                                        <td>'.$key.'</td>
                                        <td class="w-50"><input type="text" class="form-control" id="'.$this->getId($params).'" name="'.$this->getName($params).'['.$key.']" value="'.@$values[$key].'"></td>
                                        <td class="pl-3"><small>'.$desc.'</small></td>
                                    </tr>';
            }

            $params['input'] = '<table class="w-100">'.implode('<br>', $params['input']).'</table>';
            return $this->getFormGroup($params);
        }
    }

    public function password($params)
    {
        $params['input'] = '<input type="password" class="form-control" id="'.$this->getId($params).'" name="'.$this->getName($params).'">';
        return $this->getFormGroup($params);
    }

    public function select($params)
    {
        if(empty($params['options'])) {
            foreach($this->_model->{strtolower($params['label'])}()->getRelated()->all() as $val) { // withTrashed()->get()

                if(isset($params['allows']) && !in_array($val->id, $params['allows'])) continue;

                $sel = ($val->id == $this->getValue($params)) ? ' selected' : '';
                $options[] = '<option value="'.$val->id.'"'.$sel.'>'.$val->id.' - '.$val->{strtolower($params['label'])}.'</option>';
            }
        } else $options = $params['options'];

        $params['input'] = '<select class="form-control" id="'.$this->getId($params).'" name="'.$this->getName($params).'" '.$this->getEditable($params).'>
                            <option value="">'.__('adminux.select').'...</option>
                            '.@implode('', $options).'
                            </select>';
        return $this->getFormGroup($params);
    }

    public function switch($params)
    {
        $value   = (!empty($params['value'])) ? $params['value'] : $this->_checkbox_value;
        $checked = (in_array(strtolower($this->getValue($params)), $this->_checked_if)) ? ' checked' : '';

        $this->_input_cls.= ' custom-control custom-switch';
        $params['input'] = '<input type="hidden" name="'.$this->getName($params).'">
                            <input type="checkbox" class="custom-control-input" id="'.$this->getId($params).'" name="'.$this->getName($params).'" value="'.$value.'"'.$checked.'>
                            <label class="custom-control-label ml-3 mt-1" for="'.$this->getId($params).'"></label>';
        return $this->getFormGroup($params);
    }

    public function text($params)
    {
        $params['input'] = '<input type="text" class="form-control" id="'.$this->getId($params).'" name="'.$this->getName($params).'" value="'.$this->getValue($params).'">';
        return $this->getFormGroup($params);
    }

    public function textarea($params)
    {

    }

    public function url($params)
    {
        $params['input'] = '<input type="url" class="form-control" id="'.$this->getId($params).'" name="'.$this->getName($params).'" value="'.$this->getValue($params).'">';
        return $this->getFormGroup($params);
    }

    public function getFormGroup($params = [])
    {
        return '<div class="form-group row">
                    <label class="'.$this->_label_cls.'" for="'.$this->getId($params).'">'.$params['label'].'</label>
                    <div class="'.$this->_input_cls.'">'.$params['input'].'</div>
                </div>';
    }

    public function getEditable($params = [])
    {
        return ($this->_model->id && isset($params['editable']) && $params['editable'] === false) ? ' disabled' : '';
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
            foreach(\Schema::getColumnListing($this->_model->getTable()) as $key) {
                if(strcasecmp($key, $params['label']) == 0) return $key;
                elseif(strcasecmp($key, str_replace(['-', ' '], '', $params['label'])) == 0) return $key;
                elseif(strcasecmp($key, str_replace(['-', ' '], '_', $params['label'])) == 0) return $key;
                elseif(strcasecmp($key, $params['label'].'_id') == 0) return $key;
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

    public function html($html = '')
    {
        return $html;
    }
}

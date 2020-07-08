<?php

namespace App\Adminux;

use Illuminate\Contracts\Validation\Rule;

class FileManagerExistsRule implements Rule
{
    public function __construct($model)
    {
        $this->dir = $model->getTable().'/'.$model->id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return file_exists(storage_path('app/public/'.$this->dir.'/'.$value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Image not found on files :attribute';
    }
}

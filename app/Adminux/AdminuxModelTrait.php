<?php

namespace App\Adminux;

trait AdminuxModelTrait
{
    // This change only affects serialization of models and model collections to arrays and JSON.
    // This change has no effect on how dates are stored in your database.
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}

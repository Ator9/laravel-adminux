<?php

namespace App\Adminux\Config\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use SoftDeletes;

    protected $table = 'configs_currencies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'currency'
    ];

    /**
     * Get the services for the currency.
     */
    // public function services()
    // {
    //     return $this->hasMany('App\Adminux\Service\Models\Service');
    // }
}

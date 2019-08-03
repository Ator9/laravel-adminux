<?php

namespace App\Adminux\Service\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service', 'service_class'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at'
    ];

    /**
     * Get the currency.
     */
    public function currency()
    {
        return $this->belongsTo('App\Adminux\Admin\Models\Currency')->withTrashed();
    }

    /**
     * Get the features.
     */
    public function features()
    {
        return $this->hasMany('App\Adminux\Service\Models\Feature');
    }

    /**
     * Get the partners for the product.
     */
    // public function partners()
    // {
    //     return $this->belongsToMany('App\Adminux\Partner\Models\Partner')->whereNull('partner_product.deleted_at');
    // }
}

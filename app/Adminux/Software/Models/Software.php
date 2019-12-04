<?php

namespace App\Adminux\Software\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Software extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'software', 'software_class'
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
     * Get the features.
     */
    public function features()
    {
        return $this->hasMany('App\Adminux\Software\Models\Feature');
    }

    /**
     * Get the partners for the product.
     */
    // public function partners()
    // {
    //     return $this->belongsToMany('App\Adminux\Partner\Models\Partner')->whereNull('partner_product.deleted_at');
    // }
}

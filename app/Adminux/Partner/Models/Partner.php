<?php

namespace App\Adminux\Partner\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'partner', 'active'
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
     * Get the admins for the partner.
     */
    public function admins()
    {
        return $this->belongsToMany('App\Adminux\Admin\Models\Admin')->withPivot('created_at');
    }

    /**
     * Get the products for the partner.
     */
    public function products()
    {
        return $this->belongsToMany('App\Adminux\Product\Models\Product')->whereNull('partner_product.deleted_at')->withPivot('name');
    }
}

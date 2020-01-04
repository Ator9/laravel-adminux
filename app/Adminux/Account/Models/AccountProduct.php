<?php

namespace App\Adminux\Account\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountProduct extends Model
{
    use SoftDeletes;

    protected $table = 'accounts_products';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [ 'id' ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ 'product', 'software_config', 'deleted_at' ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [ 'module_config' => 'array', 'software_config' => 'array' ];

    // Custom field:
    protected $appends = array('product');
    public function getProductAttribute()
    {
        return @(clone $this)->plan->plan; // @ to avoid datatables error
    }

    /**
     * Get the account.
     */
    public function account()
    {
        return $this->belongsTo('App\Adminux\Account\Models\Account')->withTrashed();
    }

    /**
     * Get the plan.
     */
    public function plan()
    {
        return $this->belongsTo('App\Adminux\Service\Models\Plan')->withTrashed();
    }
}

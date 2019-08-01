<?php

namespace App\Adminux\Account\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountPlan extends Model
{
    use SoftDeletes;

    protected $table = 'accounts_plans';

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
    protected $hidden = [ 'service_config', 'deleted_at' ];

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
        return $this->belongsTo('App\Adminux\Product\Models\Plan')->withTrashed();
    }

    // Get array from json.
    public function getServiceConfigAttribute($value)
    {
        return json_decode($value, true);
    }
}

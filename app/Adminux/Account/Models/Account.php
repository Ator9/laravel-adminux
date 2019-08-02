<?php

namespace App\Adminux\Account\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'partner_id', 'email', 'password', 'account', 'module_config', 'active' ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ 'password', 'remember_token', 'deleted_at' ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [  'module_config' => 'array' ];

    /**
     * Get the partner.
     */
    public function partner()
    {
        return $this->belongsTo('App\Adminux\Partner\Models\Partner')->withTrashed();
    }

    /**
     * Get the plans.
     */
    public function plans()
    {
        return $this->hasMany('App\Adminux\Account\Models\AccountPlan');
    }
}

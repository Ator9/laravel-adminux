<?php

namespace App\Adminux\Account\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Authenticatable
{
    use \App\Adminux\AdminuxModelTrait;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'partner_id', 'email', 'password', 'account', 'language_id', 'module_config', 'active' ];

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
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Adminux\Panel\ResetPasswordNotification($token, $this->email));
    }

    // Custom field:
    protected $appends = array('panel');
    public function getPanelAttribute()
    {
        if($this->active == 'N') return '<small class="text-danger">Account not active</small>';

        return '<small><a href="'.request()->url().'/login_panel" target="_blank">Control Panel <span class="ml-1" data-feather="external-link"></span></a></small>';
    }

    /**
     * Get the partner.
     */
    public function partner()
    {
        return $this->belongsTo('App\Adminux\Partner\Models\Partner')->withTrashed();
    }

    /**
     * Get the products.
     */
    public function products()
    {
        return $this->hasMany('App\Adminux\Account\Models\AccountProduct');
    }

    /**
     * Get the language.
     */
    public function language()
    {
        return $this->belongsTo('App\Adminux\Admin\Models\Language')->withTrashed();
    }
}

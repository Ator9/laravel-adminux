<?php

namespace App\Adminux\Admin\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'firstname', 'lastname', 'role_id', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'deleted_at'
    ];

    /**
     * Get the partners for the admin.
     */
    public function partners()
    {
        return $this->belongsToMany('App\Adminux\Partner\Models\Partner')->withPivot('created_at');
    }

    /**
     * Get the role.
     */
    public function role()
    {
        return $this->belongsTo('App\Adminux\Admin\Models\Role');
    }
}

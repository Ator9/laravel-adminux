<?php

namespace App\Adminux\Admin\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'firstname', 'lastname', 'language_id', 'role_id', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'superuser', 'remember_token', 'deleted_at'
    ];

    /**
     * Get the partners for the admin.
     */
    public function partners()
    {
        return $this->belongsToMany('App\Adminux\Partner\Models\Partner')->withPivot('created_at');
    }

    /**
     * Get the language.
     */
    public function language()
    {
        return $this->belongsTo('App\Adminux\Admin\Models\Language')->withTrashed();
    }
}

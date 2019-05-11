<?php

namespace App\Adminux\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'admins_roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role'
    ];

    /**
     * Get the admins for the partner.
     */
    public function admins()
    {
        return $this->hasMany('App\Adminux\Admin\Models\Admin');
    }
}

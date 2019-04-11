<?php

namespace App\Adminux\Role\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get the admins for the partner.
     */
    public function admins()
    {
        return $this->belongsToMany('App\Adminux\Admin\Models\Admin')->withPivot('created_at');
    }
}

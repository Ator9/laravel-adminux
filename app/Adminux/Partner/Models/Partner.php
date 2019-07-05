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
        'language_id', 'partner', 'config', 'active'
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
     * Get the language.
     */
    public function language()
    {
        return $this->belongsTo('App\Adminux\Admin\Models\Language')->withTrashed();
    }

    /**
     * Get the products for the partner.
     */
    // public function products()
    // {
    //     return $this->hasMany('App\Adminux\Product\Models\Product');
    // }
}

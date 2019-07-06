<?php

namespace App\Adminux\Service\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use SoftDeletes;

    protected $table = 'services_features';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_id', 'feature'
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
     * Get the service.
     */
    public function service()
    {
        return $this->belongsTo('App\Adminux\Service\Models\Service')->withTrashed();
    }
}

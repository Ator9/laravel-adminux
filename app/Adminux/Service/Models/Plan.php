<?php

namespace App\Adminux\Service\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;

    protected $table = 'services_plans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'service_id', 'plan', 'currency_id', 'price', 'interval' ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ 'deleted_at' ];

    /**
     * Get the service.
     */
    public function service()
    {
        return $this->belongsTo('App\Adminux\Service\Models\Service')->withTrashed();
    }

    /**
     * Get the currency.
     */
    public function currency()
    {
        return $this->belongsTo('App\Adminux\Admin\Models\Currency')->withTrashed();
    }
}

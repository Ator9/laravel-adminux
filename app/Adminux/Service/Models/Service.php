<?php

namespace App\Adminux\Service\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'partner_id', 'software_id', 'service', 'domain', 'currency_id', 'price', 'interval', 'price_history' ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ 'deleted_at' ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [ 'price_history' => 'array' ];

    /**
     * Get the partner.
     */
    public function partner()
    {
        return $this->belongsTo('App\Adminux\Partner\Models\Partner')->withTrashed();
    }

    /**
     * Get the software.
     */
    public function software()
    {
        return $this->belongsTo('App\Adminux\Software\Models\Software')->withTrashed();
    }

    /**
     * Get the currency.
     */
    public function currency()
    {
        return $this->belongsTo('App\Adminux\Admin\Models\Currency')->withTrashed();
    }

    /**
     * Get the plans.
     */
    public function plans()
    {
        return $this->hasMany('App\Adminux\Service\Models\Plan');
    }
}

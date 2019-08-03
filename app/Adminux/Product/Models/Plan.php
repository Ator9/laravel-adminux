<?php

namespace App\Adminux\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;

    protected $table = 'products_plans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'product_id', 'plan', 'currency_id', 'price', 'interval' ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ 'deleted_at' ];

    /**
     * Get the product.
     */
    public function product()
    {
        return $this->belongsTo('App\Adminux\Product\Models\Product')->withTrashed();
    }

    /**
     * Get the currency.
     */
    public function currency()
    {
        return $this->belongsTo('App\Adminux\Admin\Models\Currency')->withTrashed();
    }
}

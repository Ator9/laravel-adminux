<?php

namespace App\Adminux\Billing\Models;

use Illuminate\Database\Eloquent\Model;

class BillingUnit extends Model
{
    protected $table = 'billing_units';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'product_id', 'units', 'date' ];
}

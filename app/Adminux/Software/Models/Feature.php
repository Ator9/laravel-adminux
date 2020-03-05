<?php

namespace App\Adminux\Software\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use \App\Adminux\AdminuxModelTrait;
    use SoftDeletes;

    protected $table = 'software_features';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'software_id', 'feature'
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
     * Get the software.
     */
    public function software()
    {
        return $this->belongsTo('App\Adminux\Software\Models\Software')->withTrashed();
    }
}

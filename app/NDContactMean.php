<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NDContactMean extends Model
{
    use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nd_contact_means';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    /**
    * To allow soft deletes
    */
    use SoftDeletes;

    protected $dates = ['deleted_at'];
}

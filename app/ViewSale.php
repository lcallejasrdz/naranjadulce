<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ViewSale extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'slug',
        'user_id',
        'proof_of_payment',
        'quantity',
        'seller_package',
        'seller_modifications',
        'delivery_type',
        'preferential_schedule',
        'seller_observations',
        'shipping_cost',
        'created_at',
        'updated_at',
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

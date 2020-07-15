<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NDCustomerForm extends Model
{
    use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nd_customer_forms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nd_buys_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'postal_code',
        'state',
        'municipality',
        'colony',
        'street',
        'no_ext',
        'no_int',
        'nd_address_types_id',
        'references',
        'nd_parkings_id',
        'package',
        'nd_themathics_id',
        'modifications',
        'observations',
        'nd_contact_means_id',
        'contact_mean_other',
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

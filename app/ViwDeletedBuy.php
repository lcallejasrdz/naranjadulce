<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViwDeletedBuy extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'phone',
        'postal_code',
        'state',
        'municipality',
        'colony',
        'street',
        'no_ext',
        'no_int',
        'package',
        'modifications',
        'message',
        'delivery_date',
        'delivery_schedule',
        'how_know_us',
        'how_know_us_other',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function scopeData($query)
    {
        return $query->get();
    }
}

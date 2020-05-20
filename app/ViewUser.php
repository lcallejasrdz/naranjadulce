<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewUser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'id',
        'slug',
        'last_login',
        'first_name',
        'last_name',
        'email',
        'role_id',
        'created_at',
        'updated_at',
    ];

    public function scopeData($query)
    {
        return $query->where('id', '!=', 1)->get();
    }
}

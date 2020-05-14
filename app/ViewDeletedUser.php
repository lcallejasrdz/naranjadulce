<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewDeletedUser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'id',
        'slug',
        'username',
        'last_login',
        'first_name',
        'last_name',
        'email',
        'role_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function scopeData($query)
    {
        return $query->get();
    }
}

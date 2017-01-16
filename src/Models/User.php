<?php

namespace So2platform\Publicprofile\Models;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    public $fillable = [
        'name', 'email', 'email', 'password'
    ];

}

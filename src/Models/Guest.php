<?php

namespace So2platform\Publicprofile\Models;


use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $table = 'Guests';

    public $fillable = [
        'nickname', 'email'
    ];

}

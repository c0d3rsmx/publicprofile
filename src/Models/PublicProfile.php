<?php

namespace So2platform\Publicprofile\Models;


use Illuminate\Database\Eloquent\Model;

class PublicProfile extends Model
{
    protected $table = 'Public_Profiles';

    public $fillable = [
        'user_id', 'name', 'lastname', 'email', 'phone', 'cover_image', 'profile_image', 'status', 'nickname'
    ];

}

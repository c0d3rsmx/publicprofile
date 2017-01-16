<?php

namespace So2platform\Publicprofile\Models;


use Illuminate\Database\Eloquent\Model;

class ProfileFeedback extends Model
{
    protected $table = 'Profile_Feedbacks';

    public $fillable = [
        'public_profile_id'
    ];

}

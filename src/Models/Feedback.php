<?php

namespace So2platform\Publicprofile\Models;


use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'Feedbacks';

    public $fillable = [
            'feedback', 'profile_feedback_id', 'guest_id', 'guest_nickname', 'status'
    ];



}

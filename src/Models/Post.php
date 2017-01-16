<?php

namespace So2platform\Publicprofile\Models;


use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'Posts';

    public $fillable = [
        'public_profile_id', 'title', 'content', 'video', 'image', 'youtube'
    ];

}

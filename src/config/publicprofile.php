<?php
/**
 * Created by PhpStorm.
 * User: antoniobg
 * Date: 2/1/17
 * Time: 3:54 PM
 */
return [

    /* Node server url */
    'node_server' => 'http://your-app-url:3000', //Feel free to edit socket port. (socket.js)

    'default_auth_model_id' => 1,
    'default_public_profile_id' => 1,
    'auth_model_key' => "user_id",
    'auth_guard' => "web",
    'views_to_use' => 'publicprofile_base',  //"publicprofile" for published ones.

    /* Public profile backend Home view */
    'backend_home_view' => 'public_profile',

    /* Public session settings */
    'public_session_instance' => '',

    /* S3 Config */
    's3_public_profile' => [
        'S3_KEY' => '',
        'S3_SECRET' => '',
        'S3_REGION' => '',
        'S3_BUCKET' => 'https://{{your-bucket}}.s3.amazonaws.com/',
        'S3_BUCKET_POSTS_DIRECTORY' => '',  // With slash at end.
        'S3_BUCKET_IMAGES_DIRECTORY' => '',  // With slash at end.
        'S3_BUCKET_COVER_DIRECTORY' => '',  // With slash at end.
    ]

];
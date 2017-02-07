# Public Profile for Laravel 5.3
![Alt text](https://img.shields.io/badge/build-passing%2Fdeveloping-yellowgreen.svg)![Alt text](https://img.shields.io/badge/beta%20version-1.3-yellow.svg )
### Synergy O2


  ####How Install
  1. Add package information to repository section in composer.json

  
         "require": {
             "so2platform/publicprofile": "*"
         },
         "repositories":[
             {
                 "type":"vcs",
                 "url":"git@gitlab.com:so2platform/publicprofile.git"
             }
         ],

  2. Run.
 
 
        npm install express ioredis socket.io --save
        #Or if using yarn : yarn add express ioredis socket.io --save
  3. Run.
  
  
        composer require predis/predis
        composer require league/flysystem-aws-s3-v3 ~1.0

  4. Configure your aws s3 bucket credentials
  
  5. At env file change change BROADCAST_DRIVER driver
  
  
        BROADCAST_DRIVER=redis
        

  6. Add package ServiceProvider to conf/app.php <b>providers</b>
     
     
        So2platform\Publicprofile\Providers\PublicProfileServiceProvider::class,


  7. Add autoload ServiceProvider to composer.json psr-4
     
     
        "So2platform\\Publicprofile\\": "vendor/so2platform/publicprofile/src/"
 
  8. Run dump-autoload
     
     
     
        composer dump-autoload

  9. Publish package content
     
     
        php artisan vendor:publish --provider="So2platform\Publicprofile\Providers\PublicProfileServiceProvider"

  10. Now in the browser navigate to <b>http://"projectname"/profile/installer</b> and select <b>install</b>.<br>
     This will generate the required tables on configured database connection.

  11. Start the nodejs server


        node vendor/so2platform/publicprofile/socket.js
      
  12. Configure auth model, model primary id and s3 settings in config/publicprofile.php
  
       
       /* Node server url */
           'node_server' => 'http://cmsmodule.local:3000',
       
           'default_auth_model_id' => 1,
           'default_public_profile_id' => 1,
           'auth_model_key' => "id_cliente",
           'auth_guard' => "web",
       
           /* Public profile backend Home view */
           'backend_home_view' => 'public_profile',
       
           /* Public session settings */
           'public_session_instance' => '',
       
           /* S3 Config */
           's3_public_profile' => [
               'S3_KEY' => env('AWS_KEY'),
               'S3_SECRET' => env('AWS_SECRET'),
               'S3_REGION' => env('AWS_REGION'),
               'S3_BUCKET' => 'https://'.env('AWS_BUCKET').'.s3.amazonaws.com/',
               'S3_BUCKET_POSTS_DIRECTORY' => 'public/publicprofiles/profileposts/',  // With slash at end.
               'S3_BUCKET_IMAGES_DIRECTORY' => 'public/publicprofiles/profileimages/',  // With slash at end.
               'S3_BUCKET_COVER_DIRECTORY' => 'public/publicprofiles/profilecovers/',  // With slash at end.
           ]
  
  13. Now you've installed the Public Profiles App.

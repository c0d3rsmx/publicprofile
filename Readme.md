# Public Profile for Laravel 5.3
![Alt text](https://img.shields.io/badge/build-passing%2Fdeveloping-yellowgreen.svg)![Alt text](https://img.shields.io/badge/beta%20version-1.4.3-yellow.svg )
### Synergy O2


  ####How Install
  1. Important, this package requieres <b>node.js</b> and <b>npm</b> installed.

         
  2. Run 
            composer require so2platform/publicprofile
            composer require league/flysystem-aws-s3-v3
            composer require predis/predis
            composer require league/flysystem-aws-s3-v3 ~1.0


  3. Run.
 
 
        npm install express ioredis socket.io --save
        #Or if using yarn : yarn add express ioredis socket.io --save
        

  4. Configure your aws s3 bucket credentials at <b>config/publicprofile.php</b>
  
  5. In env file change BROADCAST_DRIVER driver to redis
  
  
        BROADCAST_DRIVER=redis
        

  6. Add package ServiceProvider to conf/app.php <b>providers</b>
     
     
        So2platform\Publicprofile\Providers\PublicProfileServiceProvider::class,

 
  7. Run dump-autoload
     
     
     
        composer dump-autoload

  8. Publish package content
     
     
        php artisan vendor:publish --provider="So2platform\Publicprofile\Providers\PublicProfileServiceProvider"

  9. Now in the browser navigate to <b>http://"projectname"/profile/installer</b> and select <b>install</b>.<br>
     This will generate the required tables on configured database connection.

  10. Start the nodejs server


        node vendor/so2platform/publicprofile/socket.js
      
  11. Configure auth model, model primary id and s3 settings in config/publicprofile.php
  
       
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
  
  12. Now you've installed the Public Profiles App, now goto to <b>http://yourlocal/profile/installer</b>
  
  
  
  
  
  ####Setup
  This package requieres a little configuration at conf/publicprofiles file
  parameters:
  
   * <b>default_auth_model_id</b> = If there's not an active session then we use this.
   * <b>default_public_profile_id</b> = We need an id (session, login, etc...) in order to associate a profile to it, if's doesn't exists then the package will use this.
   * <b>auth_model_key</b> = session/model id key name.
   * <b>auth_guard</b> = guard name.
   * <b>views_to_use</b> = This configuration parameter is in order use the base views (within package) or publised views. this is important parameter because we
   will not extend or publish controllers. (views can override this at extends line).
   * <b>backend_home_view</b> = Default backend view.
   * <b>backend_home_view</b> = This is because if a user is searched by id or his nickname at url bar the package creates a instance of session of his profile to show (like a default profile in the browser).
                                            
                                            
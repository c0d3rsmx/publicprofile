<?php

namespace So2platform\Publicprofile\Controllers\PublicProfile\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use So2platform\Publicprofile\Events\PostsEvent;
use So2platform\Publicprofile\Helpers\imageUpload;
use So2platform\Publicprofile\Models\Post;
use So2platform\Publicprofile\Models\PublicProfile;

class ProfileController extends Controller
{
    /**
     * Show the application index.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /* If there's a active session then get the id from it. */
        if(!empty(auth(config('publicprofile.auth_guard'))->user())){
            // Change session id name.
            $user_id = auth(config('publicprofile.auth_guard'))->user()[config('publicprofile.auth_model_key')];
        }else{
            /* Use your own logic to set the user id to the new post */
            $user_id = config('publicprofile.default_auth_model_id');
        }
        $public_profile = PublicProfile::where('user_id', $user_id)->first();
        if(!empty($public_profile)){
            return redirect()->route('backend_profile_edit', array('profile_id', $public_profile->id));
        }
        return view('publicprofile::backend.profile.create', array('user_id' => $user_id));

    }

    /**
     * Show the application store.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'profile_user_id' => 'required',
            'user_name' => 'required',
            'user_lastname' => 'required',
            'user_email' => 'required|email',
            'user_phone' => 'required',
            'user_status' => 'required',
            'user_nickname' => 'required',
        ]);

        $profile = PublicProfile::create([
            'user_id' => $request->profile_user_id,
            'name' => $request->user_name,
            'lastname' => $request->user_lastname,
            'nickname' => $request->user_nickname,
            'email' => $request->user_email,
            'phone' => $request->user_phone,
            'status' => $request->user_status == "true" ? true : false
        ]);
        if(isset($request->user_profile_image)){
            if($request->user_profile_image != null){
                $imageup = new imageUpload();
                $img = new \stdClass();
                $i[] = $request->user_profile_image;
                $img->post_image = $i;
                $check = $imageup->validateUpload($img);
                if($check != null){
                    return back()->withErrors([$check]);
                }
                $name = $imageup->s3Upload($request->user_profile_image, config('publicprofile.s3_public_profile.S3_BUCKET_IMAGES_DIRECTORY'));
                $profile->profile_image = config('publicprofile.s3_public_profile.S3_BUCKET').config('publicprofile.s3_public_profile.S3_BUCKET_IMAGES_DIRECTORY'). $name;

            }
        }
        if (isset($request->user_cover_image)){
            if($request->user_cover_image != null){
                $imageup = new imageUpload();
                $img = new \stdClass();
                $i[] = $request->user_cover_image;
                $img->post_image = $i;
                $check = $imageup->validateUpload($img);
                if($check != null){
                    return back()->withErrors([$check]);
                }
                $name = $imageup->s3Upload($request->user_cover_image, config('publicprofile.s3_public_profile.S3_BUCKET_COVER_DIRECTORY'));
                $profile->cover_image = config('publicprofile.s3_public_profile.S3_BUCKET').config('publicprofile.s3_public_profile.S3_BUCKET_COVER_DIRECTORY'). $name;

            }
        }
        $profile->save();



        return redirect()->route('backend_profile_create');

    }


    /**
     * Show the application edit form.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($profile_id)
    {
        $profile = PublicProfile::find($profile_id);
        if(empty($profile)){
            return view("publicprofile::backend.layout.error", array(
                'error' => "
                        <div>
                            <h1>Sin perfil</h1>
                            <a class='btn btn-default' href='".route('backend_profile_create')."'>
                                Crear
                            </a>
                        </div>"
            ));
        }
        return view('publicprofile::backend.profile.edit', array('profile' => $profile));
    }


    /**
     * Update the application data.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'profile_user_id' => 'required',
            'user_name' => 'required',
            'user_lastname' => 'required',
            'user_email' => 'required|email',
            'user_phone' => 'required',
            'user_status' => 'required',
            'user_nickname' => 'required|unique:Public_Profiles,nickname',
        ]);

        $profile = PublicProfile::find($request->profile_user_id);

        $profile->name = $request->user_name;
        $profile->lastname = $request->user_lastname;
        $profile->nickname = $request->user_nickname;
        $profile->email = $request->user_email;
        $profile->phone =  $request->user_phone;
        $profile->status = $request->user_status == "true" ? true : false;

        if(isset($request->user_profile_image)){
            if($request->user_profile_image != null && $profile->user_profile_image != $request->user_profile_image){
                $imageup = new imageUpload();
                $img = new \stdClass();
                $i[] = $request->user_profile_image;
                $img->post_image = $i;
                $check = $imageup->validateUpload($img);
                if($check != null){
                    return back()->withErrors([$check]);
                }
                $name = $imageup->s3Upload($request->user_profile_image, config('publicprofile.s3_public_profile.S3_BUCKET_IMAGES_DIRECTORY'));
                $profile->profile_image = config('publicprofile.s3_public_profile.S3_BUCKET').config('publicprofile.s3_public_profile.S3_BUCKET_IMAGES_DIRECTORY'). $name;

            }
        }
        if (isset($request->user_cover_image)){
            if($request->user_cover_image != null && $profile->user_cover_image != $request->user_cover_image){
                $imageup = new imageUpload();
                $img = new \stdClass();
                $i[] = $request->user_cover_image;
                $img->post_image = $i;
                $check = $imageup->validateUpload($img);
                if($check != null){
                    return back()->withErrors([$check]);
                }
                $name = $imageup->s3Upload($request->user_cover_image, config('publicprofile.s3_public_profile.S3_BUCKET_COVER_DIRECTORY'));
                $profile->cover_image = config('publicprofile.s3_public_profile.S3_BUCKET').config('publicprofile.s3_public_profile.S3_BUCKET_COVER_DIRECTORY'). $name;
            }
        }
        $profile->save();



        return back();

    }


}

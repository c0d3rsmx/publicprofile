<?php

namespace So2platform\Publicprofile\Controllers\PublicProfile\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use So2platform\Publicprofile\Events\PostsEvent;
use So2platform\Publicprofile\Helpers\imageUpload;
use So2platform\Publicprofile\Helpers\Slugify;
use So2platform\Publicprofile\Models\Post;
use So2platform\Publicprofile\Models\PublicProfile;

class ProfileController extends BackendBaseController
{
    /**
     * Show the application index.
     *
     * @return \Illuminate\Http\Response
     */
    protected function home()
    {

        return view(config('publicprofile.backend_home_view'));
    }

    /**
     * Show the application index.
     *
     * @return \Illuminate\Http\Response
     */
    protected function create()
    {
        $user_id = $this->auth_user_id;
        $public_profile = PublicProfile::where('user_id', $user_id)->first();
        if(!empty($public_profile)){
            return redirect()->route('backend_profile_edit', array('profile_id', $public_profile->id));
        }
        return view('publicprofile::backend.profile.create', array('user_id' => $user_id));

    }


    /**
     * Show the application store.
     *
     * @return Response | RedirectResponse
     */
    protected function store(Request $request)
    {
        $this->validate($request, [
            'user_name' => 'required',
            'user_lastname' => 'required',
            'user_email' => 'required|email',
            'user_phone' => 'required',
            'user_status' => 'required',
            'user_nickname' => 'required|unique:Public_Profiles,nickname',
        ]);
        $slugify = new Slugify();
        $profile = PublicProfile::create([
            'user_id' => $this->auth_user_id,
            'name' => $request->user_name,
            'lastname' => $request->user_lastname,
            'nickname' => $slugify->slugString($request->user_nickname),
            'email' => $request->user_email,
            'phone' => $request->user_phone,
            'status' => true
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
    protected function edit()
    {
        $user_id = $this->auth_user_id;
        $profile = PublicProfile::where('user_id', $user_id)->first();
        if(empty($profile)){
            return view("publicprofile::backend.layout.error", array(
                'error' => $this->missing_profile_html_error
            ));
        }
        return view('publicprofile::backend.profile.edit', array('profile' => $profile));
    }

    /**
     * Update the application data.
     *
     * @return Response | RedirectResponse
     */
    protected function update(Request $request)
    {
        $user_id = $this->auth_user_id;
        $this->validate($request, [
            'user_name' => 'required',
            'user_lastname' => 'required',
            'user_email' => 'required|email',
            'user_phone' => 'required',
            'user_status' => 'required',
            'user_nickname' => [
                'required',
                Rule::unique('Public_Profiles','nickname')->ignore($user_id,'user_id')
            ],
        ]);
        $slugify = new Slugify();
        $profile = PublicProfile::where('user_id', $this->auth_user_id)->first();
        $profile->name = $request->user_name;
        $profile->lastname = $request->user_lastname;
        $profile->nickname = $slugify->slugString($request->user_nickname);
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

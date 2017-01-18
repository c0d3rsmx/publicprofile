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
        /* Use your own logic to set the user id to the new post */
        $user_id = 1;
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
        ]);

        $profile = PublicProfile::create([
            'user_id' => $request->profile_user_id,
            'name' => $request->user_name,
            'lastname' => $request->user_lastname,
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
                $name = $imageup->s3Upload($request->user_profile_image, 'public/publicprofiles/profileimages');
                $profile->profile_image = "https://dtx7clubcom.s3.amazonaws.com/public/publicprofiles/profileimages/".$name;
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
                $name = $imageup->s3Upload($request->user_cover_image, 'public/publicprofiles/profilecovers');
                $profile->cover_image = "https://dtx7clubcom.s3.amazonaws.com/public/publicprofiles/profilecovers/".$name;
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
        ]);

        $profile = PublicProfile::find($request->profile_user_id);

        $profile->name = $request->user_name;
        $profile->lastname = $request->user_lastname;
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
                $name = $imageup->s3Upload($request->user_profile_image, 'public/publicprofiles/profileimages');
                $profile->profile_image = "https://dtx7clubcom.s3.amazonaws.com/public/publicprofiles/profileimages/".$name;
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
                $name = $imageup->s3Upload($request->user_cover_image, 'public/publicprofiles/profilecovers');
                $profile->cover_image = "https://dtx7clubcom.s3.amazonaws.com/public/publicprofiles/profilecovers/".$name;
            }
        }
        $profile->save();



        return back();

    }


}

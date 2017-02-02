<?php

namespace So2platform\Publicprofile\Controllers\PublicProfile\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use So2platform\Publicprofile\Events\PostsEvent;
use So2platform\Publicprofile\Helpers\imageUpload;
use So2platform\Publicprofile\Models\Post;
use So2platform\Publicprofile\Models\PublicProfile;

class PostController extends Controller
{
    /**
     * Show the application create form.
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
        /* Get public profile with the session user_id */
        $public_profile = PublicProfile::where('user_id', $user_id)->first();
        if(!empty($public_profile)) {
            $public_profile_id = $public_profile->id;
        }else {
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
        return view('publicprofile::backend.post.index', array('public_profile_id' => $public_profile_id));

    }

    /**
     * Show the application store.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
           'post_public_profile_id' => 'required',
           'post_title' => 'required',
           'post_content' => 'required',
        ]);
        /* Check if request has at least an image or video */
        $nomedia = true;
        if(isset($request->post_video)){
            if($request->post_video == null ){
                $nomedia = true;
            }else{
                $nomedia = false;
            }
        }
        if (isset($request->post_image)){
            if($request->post_image == null ){
                $nomedia = true;
            }else{
                $nomedia = false;
            }
        }
        if(!$nomedia) {
            $post = Post::create([
                'public_profile_id' => $request->post_public_profile_id,
                'title' => $request->post_title,
                'content' => $request->post_content,
                'youtube' => $request->post_type == "true" ? true : false
            ]);
            if (isset($request->post_video)) {
                if ($request->post_video != null) {
                    $post->video = $request->post_video;
                }
            }
            if (isset($request->post_image)) {
                if ($request->post_image != null) {
                    $imageup = new imageUpload();
                    $img = new \stdClass();
                    $i[] = $request->post_image;
                    $img->post_image = $i;
                    $check = $imageup->validateUpload($img);
                    if ($check != null) {
                        return back()->withErrors([$check]);
                    }
                    $name = $imageup->s3Upload($request->post_image, config('publicprofile.s3_public_profile.S3_BUCKET_DIRECTORY'));
                    $post->image = config('publicprofile.s3_public_profile.S3_BUCKET').config('publicprofile.s3_public_profile.S3_BUCKET_POSTS_DIRECTORY'). $name;
                }
            }
            $post->save();
            event(new PostsEvent('channel_' . $request->post_public_profile_id));
        }

        return redirect()->route('backend_profile_post_create');

    }



}

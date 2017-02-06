<?php

namespace So2platform\Publicprofile\Controllers\PublicProfile\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use So2platform\Publicprofile\Events\PostsEvent;
use So2platform\Publicprofile\Helpers\imageUpload;
use So2platform\Publicprofile\Models\Post;
use So2platform\Publicprofile\Models\PublicProfile;

class PostController extends BackendBaseController
{
    /**
     * Show the application create form.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = $this->auth_user_id;
        $public_profile = PublicProfile::where('user_id', $user_id)->first();
        if(!empty($public_profile)) {
            $public_profile_id = $public_profile->id;
        }else {
            return view("publicprofile::backend.layout.error", array(
                'error' => $this->missing_profile_html_error
            ));
        }

        return view('publicprofile::backend.post.index', array('public_profile_id' => \Crypt::encrypt($public_profile_id)));
    }

    /**
     * Show the application store.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
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

        $public_profile = PublicProfile::where('user_id', $this->auth_user_id)->first();

        if(!empty($public_profile) ) {
            $posvideo = null;
            if (isset($request->post_video)) {
                if ($request->post_video != null) {
                    $posvideo = $request->post_video;
                }
            }
            $post = Post::create([
                'public_profile_id' => $public_profile->id,
                'title' => $request->post_title,
                'content' => $request->post_content,
                'youtube' => !empty($posvideo) ? true : false
            ]);
            if( !empty($posvideo) ){
                $post->video = $posvideo;
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
                    $name = $imageup->s3Upload($request->post_image, config('publicprofile.s3_public_profile.S3_BUCKET_POSTS_DIRECTORY'));
                    $post->image = config('publicprofile.s3_public_profile.S3_BUC   KET').config('publicprofile.s3_public_profile.S3_BUCKET_POSTS_DIRECTORY'). $name;
                }
            }
            $post->save();
            event(new PostsEvent('channel_' . $public_profile->id));
        }


        return redirect()->route('backend_profile_post_create');

    }

}

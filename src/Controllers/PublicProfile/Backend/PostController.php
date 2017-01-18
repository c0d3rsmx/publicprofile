<?php

namespace So2platform\Publicprofile\Controllers\PublicProfile\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use So2platform\Publicprofile\Events\PostsEvent;
use So2platform\Publicprofile\Helpers\imageUpload;
use So2platform\Publicprofile\Models\Post;

class PostController extends Controller
{
    /**
     * Show the application create form.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /* Use your own logic to set the public profile id to the new post */
        $public_profile_id = 1;
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
        $nomedia = false;
        if(isset($request->post_video)){
            if($request->user_profpost_videoile_image != null ){
                $nomedia = false;
            }else{
                $nomedia = true;
            }
        }
        if (isset($request->post_image)){
            if($request->post_image != null ){
                $nomedia = false;
            }else{
                $nomedia = true;
            }
        }

        if(!$nomedia) {
            $post = Post::create([
                'public_profile_id' => $request->post_public_profile_id,
                'title' => $request->post_title,
                'content' => $request->post_content,
                'youtube' => $request->post_type
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
                    $name = $imageup->s3Upload($request->post_image, 'public/publicprofiles');
                    $post->image = "https://dtx7clubcom.s3.amazonaws.com/public/publicprofiles/" . $name;
                }
            }
            $post->save();
            event(new PostsEvent('channel_' . $request->post_public_profile_id));
        }

        return redirect()->route('backend_profile_post_create');

    }



}

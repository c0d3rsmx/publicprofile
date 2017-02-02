<?php

namespace So2platform\Publicprofile\Controllers\PublicProfile\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use So2platform\Publicprofile\Events\FeedbacksEvent;
use So2platform\Publicprofile\Events\PostsEvent;
use So2platform\Publicprofile\Helpers\imageUpload;
use So2platform\Publicprofile\Models\Feedback;
use So2platform\Publicprofile\Models\Post;
use So2platform\Publicprofile\Models\ProfileFeedback;
use So2platform\Publicprofile\Models\PublicProfile;

class FeedbackController extends Controller
{
    /**
     * Show the application index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* If there's a active session then get the id from it. */
        if(!empty(auth(config('publicprofile.auth_guard'))->user())){
            // Change session id name.
            $user_id = auth(config('publicprofile.auth_guard'))->user()[config('publicprofile.auth_model_key')];
        }else{
            /* Use your own logic to set the user id to the new post */
            $user_id = config('publicprofile.default_auth_model_id'); // test id.
        }
        /* Get public profile with the session user_id */
        $public_profile = PublicProfile::where('user_id', $user_id)->first();
        if(!empty($public_profile)) {
            $profile_feedback = ProfileFeedback::where('public_profile_id', $public_profile->id)->first();
        }
        if(!empty($profile_feedback)){
            $feedbacks = Feedback::where('profile_feedback_id', $profile_feedback->id)->get();
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
        return view('publicprofile::backend.feedback.index', array(
            'profile_feedbacks' => $feedbacks,
        ));
    }

    /**
     * Update the application data.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update($feedback_id)
    {
        $feedback = Feedback::find($feedback_id);
        if($feedback != null){
            $feedback->status = $feedback->status == true ? false : true;
            $feedback->save();
            event(new FeedbacksEvent('feedback_'.$feedback->profile_feedback_id));
        }
        return back();
    }

    /**
     * Destroy the application data.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy($feedback_id)
    {
        $feedback = Feedback::find($feedback_id);
        if($feedback != null){
            event(new FeedbacksEvent('feedback_'.$feedback->profile_feedback_id));
        }
        $feedback->delete();
        return back();
    }



}

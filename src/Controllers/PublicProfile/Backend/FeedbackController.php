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

class FeedbackController extends BackendBaseController
{
    /**
     * Show the application index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $public_profile = PublicProfile::where('user_id', $this->auth_user_id )->first();
        if(!empty($public_profile)) {
            $profile_feedback = ProfileFeedback::where('public_profile_id', $public_profile->id)->first();
        }
        if(!empty($profile_feedback)){
            $feedbacks = Feedback::where('profile_feedback_id', $profile_feedback->id)->get();
            if( $feedbacks->isEmpty() ){
                return view("publicprofile::backend.layout.error", array(
                    'error' => $this->no_feedbacks
                ));
            }
        } else {
            return view("publicprofile::backend.layout.error", array(
                'error' => $this->no_feedbacks
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
        $public_profile = PublicProfile::where('user_id', $this->auth_user_id )->first();
        if(!empty($public_profile)) {
            $profile_feedback = ProfileFeedback::where('public_profile_id', $public_profile->id)->first();
            if(!empty($profile_feedback)){
                $feedback = Feedback::where('profile_feedback_id', $profile_feedback->id)->where('id',$feedback_id)->first();
                if(!empty($feedback)){
                    $feedback->status = $feedback->status == true ? false : true;
                    $feedback->save();
                    event(new FeedbacksEvent('feedback_'. $feedback->profile_feedback_id));
                }
            }
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
        $public_profile = PublicProfile::where('user_id', $this->auth_user_id )->first();
        if(!empty($public_profile)) {
            $profile_feedback = ProfileFeedback::where('public_profile_id', $public_profile->id)->first();
            if(!empty($profile_feedback)){
                $feedback = Feedback::where('profile_feedback_id', $profile_feedback->id)->where('id',$feedback_id)->first();
                if(!empty($feedback)){
                    event(new FeedbacksEvent('feedback_'.$feedback->profile_feedback_id));
                    $feedback->delete();
                }
            }
        }
        return back();
    }

}

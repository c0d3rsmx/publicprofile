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

class FeedbackController extends Controller
{
    /**
     * Show the application index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* Use your own logic to set the user id to the new post */
        $public_profile_id = 1;
        $profile_feedback = ProfileFeedback::where('public_profile_id', $public_profile_id)->first();
        $feedbacks = Feedback::where('profile_feedback_id', $profile_feedback->id)->get();
        $data = [
            'profile_feedback' => $profile_feedback,
            'feedback' => $feedbacks,
        ];

        return view('publicprofile::backend.feedback.index', array(
            'public_profile_id' => $public_profile_id,
            'profile_feedbacks' => $data,
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

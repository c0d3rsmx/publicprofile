<?php

namespace So2platform\Publicprofile\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use So2platform\Publicprofile\Events\FeedbacksEvent;
use So2platform\Publicprofile\Helpers\TimeFormat;
use So2platform\Publicprofile\Models\Feedback;
use So2platform\Publicprofile\Models\Guest;
use So2platform\Publicprofile\Models\Post;
use So2platform\Publicprofile\Models\ProfileFeedback;
use So2platform\Publicprofile\Models\PublicProfile;

class PublicProfileController extends Controller
{

    /**
     * Show the application index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* User your own logic to get the user id */
        $user_id = 1;
        $profile = PublicProfile::where('user_id',$user_id)->first();
        return view('publicprofile::frontend.index', array('profile' => $profile));

    }
    /**
     * Return given user id posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function posts(Request $request)
    {

        $this->validate($request, [
            'public_profile_id' => 'required',
        ]);

        /* User your own logic to get the user id */
        $public_profile_id = $request->public_profile_id;
        $posts = Post::orderBy('created_at', 'desc')->where('public_profile_id', $public_profile_id)->get();
        $procesed_posts = null;
        $timeformatter =  new TimeFormat();

        foreach ($posts as $p){
            $pp = $p;
            $pp->since = $timeformatter->time_ago(strtotime($p->created_at));
            $procesed_posts[] = $pp;
        }


        return json_encode($procesed_posts);

    }

    /**
     * Return auth for guest user.
     *
     * @return \Illuminate\Http\Response
     */
    public function authGuest(Request $request)
    {

        $this->validate($request, [
            'nickname' => 'required',
            'email' => 'required'
        ]);

        $guest = Guest::where('email', $request->email)->first();
        if($guest == null){
            $guest = Guest::create([
                'nickname' => $request->nickname,
                'email' => $request->email,
            ]);
        }else {
            if($guest->nickname != $request->nickname){
                $guest->nickname = $request->nickname;
                $guest->save();
            }
        }

        return json_encode($guest);
    }

    /**
     * Return user feedback.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFeedback(Request $request)
    {
        $this->validate($request, [
            'public_profile_id' => 'required',
        ]);

        $profile_feedbacks = ProfileFeedback::where('public_profile_id', $request->public_profile_id)->first();
        if($profile_feedbacks == null){
            $profile_feedbacks = ProfileFeedback::create([
                'public_profile_id' => $request->public_profile_id,
            ]);
        }
        $feedback = Feedback::orderBy('created_at', 'desc')
            ->where('profile_feedback_id', $profile_feedbacks->id)
            ->where('status', true)->get();

        $procesed_feedbacks = null;
        $timeformatter =  new TimeFormat();

        foreach ($feedback as $f){
            $pf = $f;
            $pf->since = $timeformatter->time_ago(strtotime($f->created_at));
            $procesed_feedbacks[] = $pf;
        }


        $data = [
            'profile_feedbacks' => $profile_feedbacks,
            'feedbacks' => $procesed_feedbacks,
        ];

        return json_encode($data);
    }

    /**
     * Store new user feedback.
     *
     * @return \Illuminate\Http\Response
     */
    public function newFeedback(Request $request)
    {
        $this->validate($request, [
            'profile_feedback_id' => 'required',
            'guest_id' => 'required',
            'feedback' => 'required',
        ]);

        Feedback::create([
            'profile_feedback_id' => $request->profile_feedback_id,
            'feedback' => $request->feedback,
            'guest_id' => $request->guest_id,
            'guest_nickname' => $request->guest_nickname
        ]);

        /* Event goes here */
        event(new FeedbacksEvent('feedback_'.$request->user_id));


        return json_encode("Success");
    }






}

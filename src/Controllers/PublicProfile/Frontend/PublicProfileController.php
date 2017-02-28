<?php

namespace So2platform\Publicprofile\Controllers\PublicProfile\Frontend;

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
    public function index($nickname = null)
    {

        /* If there's a active session then get the id from it. */
        if(!empty(auth(config('publicprofile.auth_guard'))->user())){
            // Change session id name.
            $user_id = auth(config('publicprofile.auth_guard'))->user()[config('publicprofile.auth_model_key')];
        }else{
            /* Use your own logic to set the user id to the new post */
            $user_id = config('publicprofile.default_auth_model_id'); // test id.
        }
        /* If request has a nickname then search by nickname */
        if($nickname != null) {
            $profile = PublicProfile::where('nickname', $nickname)->first();
        }else {
            $public_session_id = session(config('publicprofile.public_session_instance'));
            if(!empty($public_session_id)){
                /* Search user profile by finding his nickname in order to get his Id */
                $user_nickname = PublicProfile::where('user_id',$public_session_id)->first();
                if(!empty($user_nickname)){
                    return redirect()->route('frontend_profile_index', array('nickname' => $user_nickname->nickname));
                }
            }
            $profile = PublicProfile::where('user_id',$user_id)->first();
            if(empty($profile)) {
                $profile = PublicProfile::first();
            }
        }
        if(empty($profile)){
            return redirect("/");
        }
        $profile_feedbacks = ProfileFeedback::where('public_profile_id', $profile['id'] )->first();
        if($profile_feedbacks == null){
            $profile_feedbacks = ProfileFeedback::create([
                'public_profile_id' => $profile['id'],
            ]);
        }
        $profile_feedbacks['encrypted_id'] = \Crypt::encrypt($profile_feedbacks['id']);
        $profile['encrypted_id'] = \Crypt::encrypt($profile['id']);
        return view(config('publicprofile.views_to_use').'::frontend.index', ['profile' => $profile, 'profile_feedbacks' => $profile_feedbacks]);
    }

    /**
     * Return given user id posts.
     *
     * @return \Illuminate\Http\Response
     */
    protected function posts(Request $request)
    {
        $this->validate($request, [
            'public_profile_id' => 'required',
        ]);
        /* User your own logic to get the user id */
        $public_profile_id = \Crypt::decrypt($request->public_profile_id);
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
    protected function authGuest(Request $request)
    {
        $this->validate($request, [
            'nickname' => 'required',
            'email' => 'required'
        ]);
        $guest = Guest::where('email', $request->email)->first();
        if(empty($guest)){
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
    protected function getFeedback(Request $request)
    {
        $this->validate($request, [
            'public_profile_id' => 'required',
        ]);
        $public_profile_id = \Crypt::decrypt($request->public_profile_id);
        $profile_feedbacks = ProfileFeedback::where('public_profile_id', $public_profile_id )->first();
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
            //'profile_feedbacks' => $profile_feedbacks,
            'encrypted_id' => \Crypt::encrypt($profile_feedbacks['id']),
            'feedbacks' => $procesed_feedbacks,
        ];

        return json_encode($data);
    }

    /**
     * Store new user feedback.
     *
     * @return \Illuminate\Http\Response
     */
    protected function newFeedback(Request $request)
    {
        $this->validate($request, [
            'profile_feedback_id' => 'required',
            'guest_id' => 'required',
            'feedback' => 'required',
        ]);
        $feedback_profile_id = \Crypt::decrypt($request->profile_feedback_id);
        Feedback::create([
            'profile_feedback_id' => $feedback_profile_id,
            'feedback' => $request->feedback,
            'guest_id' => $request->guest_id,
            'guest_nickname' => $request->guest_nickname
        ]);

        /* Event goes here */
        event(new FeedbacksEvent('feedback_'.$feedback_profile_id));

        return json_encode("Success");
    }

}

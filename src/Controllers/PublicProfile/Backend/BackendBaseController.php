<?php

namespace So2platform\Publicprofile\Controllers\PublicProfile\Backend;

use App\Http\Controllers\Controller;

class BackendBaseController extends Controller
{
    protected $authguard;
    protected $user_authenticated;
    protected $auth_user_id;
    protected $missing_profile_html_error;
    protected $no_feedbacks;

    function __construct(){
        $this->middleware(function($request,$next) {
            $this->authguard = config('publicprofile.auth_guard');
            $this->user_authenticated = auth()->guard($this->authguard)->check();
            $this->auth_user_id = $this->user_authenticated ?
                auth()->guard($this->authguard)->user()[config('publicprofile.auth_model_key')] :
                config('publicprofile.default_auth_model_id');

            $this->missing_profile_html_error = "<div class='container'> <h4>Profile missing</h4>
            <h1>First create your profile</h1>
            <a class='btn btn-default' href='" . route('backend_profile_create') . "'> Click here to create it </a> </div>";

            $this->no_feedbacks = "<div class='container'><h1>No comments from your visitors yet</h1></div>";
            return $next($request);
        });
    }
}
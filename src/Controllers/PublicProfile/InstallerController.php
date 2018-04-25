<?php

/**
 * Created by PhpStorm.
 * User: antoniobg
 * Date: 12/19/16
 * Time: 11:53 AM
 */
namespace So2platform\Publicprofile\Controllers\PublicProfile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use So2platform\Cms\Models\CMSContentType;
use So2platform\Cms\Models\CMSLocale;
use So2platform\Cms\Models\CMSSectionType;
use So2platform\Cms\Models\CMSTemplate;

class InstallerController extends Controller
{
    /**
     * Index of installer.
     * @return void
     */
    function installer(){
        return view(config('publicprofile.views_to_use').'::index');
    }

    /**
     * Installer set up.
     * @return void
     */
    function setUp(){
        Artisan::call('migrate');
        return redirect()->route('profile_installer');
    }
}


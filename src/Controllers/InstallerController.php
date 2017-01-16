<?php

/**
 * Created by PhpStorm.
 * User: antoniobg
 * Date: 12/19/16
 * Time: 11:53 AM
 */
namespace So2platform\Publicprofile\Controllers;

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
        return view('publicprofile::index');
    }

    /**
     * Installer set up.
     * @return void
     */
    function setUp(){
        Artisan::call('migrate');
        if(count(CMSTemplate::get())  == 0){
            CMSTemplate::create([
                'name' => 'Pivot',
                'file_name' => 'pivot'
            ]);
            CMSTemplate::create([
                'name' => 'Bootstrap 3',
                'file_name' => 'bootstrap_3'
            ]);
        }
        if(count(CMSSectionType::get()) == 0){
            CMSSectionType::create([
                'name' => 'PivotHeaderRow',
                'file_name' => 'pivot/header_row',
                'template_id' => 1
            ]);
            CMSSectionType::create([
                'name' => 'PivotContentRow',
                'file_name' => 'pivot/content_row',
                'template_id' => 1
            ]);
            CMSSectionType::create([
                'name' => 'Bootstrap3HeaderRow',
                'file_name' => 'bootstrap3/header_row',
                'template_id' => 2
            ]);
            CMSSectionType::create([
                'name' => 'Bootstrap3ContentRow',
                'file_name' => 'bootstrap3/content_row',
                'template_id' => 2
            ]);
        }
        if(count(CMSContentType::get()) == 0){
            CMSContentType::create([
                'name' => 'Header Section'
            ]);
            CMSContentType::create([
                'name' => 'Content Section'
            ]);
        }
        if(count(CMSLocale::get()) == 0){
            CMSLocale::create([
                'locale' => 'en'
            ]);
            CMSContentType::create([
                'locale' => 'es'
            ]);
        }

        return redirect()->route('cms_index');
    }
}


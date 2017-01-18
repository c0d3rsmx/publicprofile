<?php
/**
 * Created by PhpStorm.
 * User: antoniobg
 * Date: 12/8/16
 * Time: 3:47 PM
 */


/* Installer index */
Route::get('profile/installer', 'So2platform\Publicprofile\Controllers\PublicProfile\InstallerController@installer')->name('profile_installer');
Route::get('profile/setup', 'So2platform\Publicprofile\Controllers\PublicProfile\InstallerController@setUp')->name('profile_setup');


/* Backend routes */
Route::get( 'profile/post/create', 'So2platform\Publicprofile\Controllers\PublicProfile\Backend\PostController@create' )->name('backend_profile_post_create');
Route::post( 'profile/posts/store', 'So2platform\Publicprofile\Controllers\PublicProfile\Backend\PostController@store' )->name('backend_profile_post_store');
Route::get( 'profile/create', 'So2platform\Publicprofile\Controllers\PublicProfile\Backend\ProfileController@create' )->name('backend_profile_create');
Route::post( 'profile/store', 'So2platform\Publicprofile\Controllers\PublicProfile\Backend\ProfileController@store' )->name('backend_profile_store');

Route::get( 'profile/edit/{profile_id}', 'So2platform\Publicprofile\Controllers\PublicProfile\Backend\ProfileController@edit' )->name('backend_profile_edit');
Route::post( 'profile/update', 'So2platform\Publicprofile\Controllers\PublicProfile\Backend\ProfileController@update' )->name('backend_profile_update');

Route::get( 'profile/feedbacks', 'So2platform\Publicprofile\Controllers\PublicProfile\Backend\FeedbackController@index' )->name('backend_profile_feedbacks');
Route::get( 'profile/feedbacks/enable/{feedback_id}', 'So2platform\Publicprofile\Controllers\PublicProfile\Backend\FeedbackController@update' )->name('backend_profile_feedbacks_enable');
Route::get( 'profile/feedbacks/destroy/{feedback_id}', 'So2platform\Publicprofile\Controllers\PublicProfile\Backend\FeedbackController@destroy' )->name('backend_profile_feedbacks_destroy');

/* Frontend routes */
Route::get( 'profile/index', 'So2platform\Publicprofile\Controllers\PublicProfile\Frontend\PublicProfileController@index' )->name('frontend_profile_index');
Route::post( 'profile/get/posts', 'So2platform\Publicprofile\Controllers\PublicProfile\Frontend\PublicProfileController@posts' )->name('frontend_profile_get_posts');
Route::post( 'profile/auth/guest', 'So2platform\Publicprofile\Controllers\PublicProfile\Frontend\PublicProfileController@authGuest' )->name('frontend_profile_auth_guest');
Route::post( 'profile/get/feedbacks', 'So2platform\Publicprofile\Controllers\PublicProfile\Frontend\PublicProfileController@getFeedback' )->name('frontend_profile_get_feedbacks');
Route::post( 'profile/new/feedback', 'So2platform\Publicprofile\Controllers\PublicProfile\Frontend\PublicProfileController@newFeedback' )->name('frontend_profile_new_feedbacks');

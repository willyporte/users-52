<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::group(['middleware' => ['web']], function () {

    Route::get('/', [
        'uses' => 'HomeController@index',
        'as' => 'home'
    ]);
    // Authentication routes...
    Route::get('login', [
        'uses' => 'Auth\AuthController@getLogin',
        'as' => 'login'
    ]);
    Route::post('login', 'Auth\AuthController@postLogin');
    Route::get('logout', [
        'uses' => 'Auth\AuthController@getLogout',
        'as' => 'logout'
    ]);
    // Registration routes...
    Route::get('register', [
        'uses' => 'Auth\AuthController@getRegister',
        'as' => 'register'
    ]);
    Route::post('register', 'Auth\AuthController@postRegister');
    Route::get('confirmation/{token}', [
        'uses' => 'Auth\AuthController@getConfirmation',
        'as' => 'confirmation'
    ]);
    // Password reset link request routes...
    Route::get('password/email', 'Auth\PasswordController@getEmail');
    Route::post('password/email', 'Auth\PasswordController@postEmail');
    // Password reset routes...
    Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
    Route::post('password/reset', 'Auth\PasswordController@postReset');
    // only authenticated users
    Route::group(['middleware' => 'auth'], function () {

        // only authenticated and verified users
        Route::group(['middleware' => 'verified'], function () {
            Route::get('publish', function () {
                return view('users.publish');
            });
            Route::post('publish', function () {
                return Request::all();
            });
        });
        Route::get('account', function () {
            return view('users.account');
        });
        // rinvio email
        Route::get('new-mail', [
            'uses' => 'Auth\AuthController@newEmail',
            'as' => 'new-email'
        ]);

    });
    // los no conectados pueden ir a la ruta (404 desde el middleware)
    Route::group(['middleware' => 'role:admin'], function () {
        Route::get('admin/settings', function () {
            return view('admin.settings');
        });
    });
    // los no conectados no puede ir a la ruta (aparece login)
    Route::group(['middleware' => ['auth', 'role:editor']], function () {
        Route::get('editor/posts', function () {
            return view('editor.posts');
        });
    });

});

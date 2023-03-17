<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//common routes start
Route::post('/login', '\App\Http\Controllers\AuthController@login');
Route::post('/forgetPassword', '\App\Http\Controllers\AuthController@forgetpassword');
Route::post('/checktoken', '\App\Http\Controllers\AuthController@token_check');
Route::post('/resetPassword', '\App\Http\Controllers\AuthController@reset_password');

 Route::post('/admin/register', 'App\Http\Controllers\Admin\AuthController@register');
// common routes ends

Route::group(['middleware' => ['auth:api']], function(){


   
    Route::get('/profile/view/{id}', 'App\Http\Controllers\AuthController@profile_view');
    Route::post('/profile/update', 'App\Http\Controllers\AuthController@profile_update');
    Route::post('/changePassword', 'App\Http\Controllers\AuthController@passwordChange');
    Route::get('/logout', 'App\Http\Controllers\AuthController@logout');
    Route::get('/profile/check', 'App\Http\Controllers\AuthController@usercheck');

/////////////////////////////////// Admin Routes \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

                                /// Category \\\

    Route::group(['prefix' => '/admin/category/'], function() {
        Route::controller(App\Http\Controllers\Admin\CategoryController::class)->group(function () {
            Route::get('show','index');
            Route::post('create','create');
            Route::get('edit/{id}','edit');
            Route::post('update','update');
            Route::get('delete/{id}','delete');
        });
    });

                                /// Question \\\

    Route::group(['prefix' => '/admin/question/'], function() {
        Route::controller(App\Http\Controllers\Admin\QuestionController::class)->group(function () {
            Route::get('show','index');
            Route::post('create','create');
            Route::get('edit/{id}','edit');
            Route::post('update','update');
            Route::get('delete/{id}','delete');
        });
    });

                                /// Option \\\

    Route::group(['prefix' => '/admin/option/'], function() {
        Route::controller(App\Http\Controllers\Admin\OptionController::class)->group(function () {
            Route::get('show','index');
            Route::post('create','create');
            Route::get('edit/{id}','edit');
            Route::post('update','update');
            Route::get('delete/{id}','delete');
        });
    });

                                /// Audio \\\

    Route::group(['prefix' => '/admin/audio/'], function() {
        Route::controller(App\Http\Controllers\Admin\AudioController::class)->group(function () {
            Route::get('show','index');
            Route::post('create','create');
            Route::get('edit/{id}','edit');
            Route::post('update','update');
            Route::get('delete/{id}','delete');
        });
    });
    
                                /// Video \\\

    Route::group(['prefix' => '/admin/video/'], function() {
        Route::controller(App\Http\Controllers\Admin\VideoController::class)->group(function () {
            Route::get('show','index');
            Route::post('create','create');
            Route::get('edit/{id}','edit');
            Route::post('update','update');
            Route::get('delete/{id}','delete');
        });
    });     

                                /// Podcast \\\

    Route::group(['prefix' => '/admin/podcast/'], function() {
        Route::controller(App\Http\Controllers\Admin\PodcastController::class)->group(function () {
            Route::get('show','index');
            Route::post('create','create');
            Route::get('edit/{id}','edit');
            Route::post('update','update');
            Route::get('delete/{id}','delete');
        });
    });    

                                /// Blog \\\

    Route::group(['prefix' => '/admin/blog/'], function() {
        Route::controller(App\Http\Controllers\Admin\BlogController::class)->group(function () {
            Route::get('show','index');
            Route::post('create','create');
            Route::get('edit/{id}','edit');
            Route::post('update','update');
            Route::get('delete/{id}','delete');
        });
    });     




    /////////////////////////////////// User Routes \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

                                /// Question \\\




    Route::group(['prefix' => 'survey/'], function() {
        Route::controller(App\Http\Controllers\User\SurveyController::class)->group(function () {
            Route::get('show','index');
            Route::post('create','create');
        //  Route::get('edit/{id}','edit');
        //  Route::post('update','update');
        //  Route::get('delete/{id}','delete');
            });
    });


                                        /// Question \\\


    

    
}); 


Route::group(['prefix' => 'myresult/'], function() {
    Route::controller(App\Http\Controllers\User\MyResultController::class)->group(function () {
        Route::get('show','index');
        Route::post('create','create');
    //  Route::get('edit/{id}','edit');
    //  Route::post('update','update');
    //  Route::get('delete/{id}','delete');
        });
});


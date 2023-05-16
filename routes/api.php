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

Route::get('/profile/view/{id}', 'App\Http\Controllers\AuthController@profile_view');
Route::post('/profile/update', 'App\Http\Controllers\AuthController@profile_update');

// common routes ends

/// admin Register
Route::post('/admin/register', 'App\Http\Controllers\Admin\AuthController@register');

Route::group(['middleware' => ['auth:api']], function(){


   /////////////////////////////////// Admin Routes \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


    Route::get('/admin/profile/view/{id}', 'App\Http\Controllers\Admin\AuthController@profile_view');
    Route::post('/admin/profile', 'App\Http\Controllers\Admin\AuthController@profile_update');
    Route::get('/logout', 'App\Http\Controllers\AuthController@logout');
    Route::get('/admin/profile/check', 'App\Http\Controllers\Admin\AuthController@usercheck');

    Route::get('/admin/dashboard','App\Http\Controllers\Admin\DashboardController@index');



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


                                    /// SubCategory \\\

    Route::group(['prefix' => '/admin/subcategory/'], function() {
        Route::controller(App\Http\Controllers\Admin\SubCategoryController::class)->group(function () {
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
            Route::get('show/{id}','index');
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

                                /// Banner \\\

    Route::group(['prefix' => '/admin/banner/'], function() {
        Route::controller(App\Http\Controllers\Admin\BannerController::class)->group(function () {
            Route::get('show/{id}','index');
            Route::post('create','create');
            Route::get('edit/{id}','edit');
            Route::post('update','update');
            Route::get('delete/{id}','delete');
        });
    });    

                                /// Audio \\\

    Route::group(['prefix' => '/admin/audio/'], function() {
        Route::controller(App\Http\Controllers\Admin\AudioController::class)->group(function () {
            Route::get('show/{id}','index');
            Route::post('create','create');
            Route::get('edit/{id}','edit');
            Route::post('update','update');
            Route::get('delete/{id}','delete');
            Route::get('status/{id}','changeStatus');

        });
    });
    
                                /// Video \\\

    Route::group(['prefix' => '/admin/video/'], function() {
        Route::controller(App\Http\Controllers\Admin\VideoController::class)->group(function () {
            Route::get('show/{id}','index');
            Route::post('create','create');
            Route::get('edit/{id}','edit');
            Route::post('update','update');
            Route::get('delete/{id}','delete');
            Route::get('status/{id}','changeStatus');
        });
    });     

                                /// Podcast \\\

    Route::group(['prefix' => '/admin/podcast/'], function() {
        Route::controller(App\Http\Controllers\Admin\PodcastController::class)->group(function () {
            Route::get('show/{id}','index');
            Route::post('create','create');
            Route::get('edit/{id}','edit');
            Route::post('update','update');
            Route::get('delete/{id}','delete');
            Route::get('status/{id}','changeStatus');
        });
    });    

                                /// Blog \\\

    Route::group(['prefix' => '/admin/blog/'], function() {
        Route::controller(App\Http\Controllers\Admin\BlogController::class)->group(function () {
            Route::get('show/{id}','index');
            Route::post('create','create');
            Route::get('edit/{id}','edit');
            Route::post('update','update');
            Route::get('delete/{id}','delete');
            Route::get('status/{id}','changeStatus');
        });
    }); 
    
                                /// Subscription Plan \\\

    Route::group(['prefix' => '/admin/subscription/'], function() {
        Route::controller(App\Http\Controllers\Admin\SubscriptionPlanController::class)->group(function () {
            Route::get('show','index');
            Route::post('create','create');
            Route::get('edit/{id}','edit');
            Route::post('update','update');
            Route::get('delete/{id}','delete');
            Route::get('status/{id}','changeStatus');
        });
    });     


                                    /// Users Managment \\\

    Route::group(['prefix' => '/admin/allusers/'], function() {
        Route::controller(App\Http\Controllers\Admin\UserManagmentController::class)->group(function () {
            Route::get('show','all_users');
            Route::get('delete/{id}','delete');
            Route::get('status/{id}','changeStatus');
        });
    }); 




    /////////////////////////////////// User Routes \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

                        /// user Register
            Route::post('/register','App\Http\Controllers\User\AuthController@register');
            Route::get('/phone/verify/{id}','App\Http\Controllers\User\AuthController@is_phone');
            Route::get('/profile/view/{id}', 'App\Http\Controllers\User\AuthController@profile_view');
            Route::post('/profile', 'App\Http\Controllers\User\AuthController@profile_update');
            Route::get('/profile/check', 'App\Http\Controllers\User\AuthController@usercheck');
            Route::get('/home/{id}','App\Http\Controllers\User\HomeController@index');

                                


                            /// Survey \\\

    Route::group(['prefix' => 'survey/'], function() {
        Route::controller(App\Http\Controllers\User\SurveyController::class)->group(function () {
            Route::get('show/{id}','index');
            Route::post('create','create');
            Route::get('reset/{id}','reset_survey');
        //  Route::post('update','update');
        //  Route::get('delete/{id}','delete');
            });
    });


                        /// Result \\\

        Route::group(['prefix' => 'myresult/'], function() {
        Route::controller(App\Http\Controllers\User\MyResultController::class)->group(function () {
            Route::get('show/{id}','index');
            Route::post('create','create');
        //  Route::get('edit/{id}','edit');
        //  Route::post('update','update');
        //  Route::get('delete/{id}','delete');
            });
    });


            /////////////////////////////////// User Routes \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

                                    /// Adviser Register

    Route::post('advisor/register','App\Http\Controllers\Advisor\AuthController@register');
    Route::get('advisor/phone/verify/{id}','App\Http\Controllers\Advisor\AuthController@is_phone');
    Route::get('advisor/profile/view/{id}', 'App\Http\Controllers\Advisor\AuthController@profile_view');
    Route::post('advisor/profile', 'App\Http\Controllers\Advisor\AuthController@profile_update');
    Route::get('advisor/profile/check', 'App\Http\Controllers\Advisor\AuthController@usercheck');

    
}); 






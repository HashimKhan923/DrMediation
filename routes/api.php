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
Route::get('/logout/{id}', 'App\Http\Controllers\AuthController@logout');

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
            Route::post('soft_delete','soft_delete');
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
            Route::post('soft_delete','soft_delete');
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
            Route::post('soft_delete','soft_delete');
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
            Route::post('soft_delete','soft_delete');
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


                                 /// Advisor Managment \\\

    Route::group(['prefix' => '/admin/advisor/'], function() {
        Route::controller(App\Http\Controllers\Admin\AdvisorManagmentController::class)->group(function () {
            Route::get('show','all_advisors');
            Route::get('delete/{id}','delete');
            Route::get('status/{id}','changeStatus');
            Route::get('verify/{id}','changeVerificationStatus');
        });
    }); 



                                    /// VCV \\\

        Route::group(['prefix' => '/admin/vcv/'], function() {
            Route::controller(App\Http\Controllers\Admin\VCVController::class)->group(function () {
                Route::get('show','index');
                Route::post('createOrupdate','createOrupdate');
            });
        });     



                /// TermCondition \\\

                Route::group(['prefix' => '/admin/term_condition/'], function() {
                    Route::controller(App\Http\Controllers\Admin\TermConditionController::class)->group(function () {
                        Route::get('show','index');
                        Route::post('createOrUpdate','createOrUpdate');
                    });
                });  
        
        
                                                            /// PrivacyPolicy \\\
        
                Route::group(['prefix' => '/admin/privacy_policy/'], function() {
                    Route::controller(App\Http\Controllers\Admin\PrivacyPolicyController::class)->group(function () {
                        Route::get('show','index');
                        Route::post('createOrUpdate','createOrUpdate');
                    });
                }); 
                
                                                                    /// Disclaimer \\\
        
                Route::group(['prefix' => '/admin/disclaimer/'], function() {
                    Route::controller(App\Http\Controllers\Admin\DisclaimerController::class)->group(function () {
                        Route::get('show','index');
                        Route::post('createOrUpdate','createOrUpdate');
                    });
                });  


    /////////////////////////////////// User Routes \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


            Route::post('/profile', 'App\Http\Controllers\User\AuthController@profile_update');
            Route::get('/profile/check', 'App\Http\Controllers\User\AuthController@usercheck');
            Route::get('/home/{id}','App\Http\Controllers\User\HomeController@index');

                                


                            /// Survey \\\

    Route::group(['prefix' => 'survey/'], function() {
        Route::controller(App\Http\Controllers\User\SurveyController::class)->group(function () {
            Route::get('show/{id}','index');
            Route::post('create','create');
            Route::post('app/create','app_create');
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


                            /// Service \\\

        Route::group(['prefix' => 'service/'], function() {
            Route::controller(App\Http\Controllers\User\ServiceController::class)->group(function () {
                Route::get('show/{id}','index');
            });
        });
        
        
                            /// Booking \\\

        Route::group(['prefix' => 'booking/'], function() {
            Route::controller(App\Http\Controllers\User\BookingController::class)->group(function () {
                Route::post('create','book');
            });
        });  



                            /// Subscription \\\

        Route::group(['prefix' => 'subscription/'], function() {
            Route::controller(App\Http\Controllers\User\SubscriptionPlanController::class)->group(function () {
                Route::get('show','index');
                Route::post('subscribe','subscribe');
                Route::get('mySubscription/{id}','mySubscription');
                });
        });


                            /// Payment \\\

        Route::group(['prefix' => 'payment/'], function() {
            Route::controller(App\Http\Controllers\User\PaymentController::class)->group(function () {
                Route::post('stripe','payment');     
            });
        });


                                    /// Advisors \\\

        Route::group(['prefix' => 'advisors/'], function() {
            Route::controller(App\Http\Controllers\User\AdvisorController::class)->group(function () {
                Route::get('show','index');
            });
        });  


                                            /// TermCondition \\\

        Route::group(['prefix' => 'term_condition/'], function() {
            Route::controller(App\Http\Controllers\User\TermConditionController::class)->group(function () {
                Route::get('web/show','web_index');
                Route::get('app/show','app_index');
            });
        });  


                                                    /// PrivacyPolicy \\\

        Route::group(['prefix' => 'privacy_policy/'], function() {
            Route::controller(App\Http\Controllers\User\PrivacyPolicyController::class)->group(function () {
                Route::get('web/show','web_index');
                Route::get('app/show','app_index');
            });
        }); 
        
                                                            /// Disclaimer \\\

        Route::group(['prefix' => 'disclaimer/'], function() {
            Route::controller(App\Http\Controllers\User\DisclaimerController::class)->group(function () {
                Route::get('web/show','web_index');
                Route::get('app/show','app_index');
            });
        });  

            /////////////////////////////////// Advisor Routes \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\



                                    // Slot

    Route::get('advisor/slots/{id}','App\Http\Controllers\Advisor\SlotController@index');
    Route::post('advisor/slot/create','App\Http\Controllers\Advisor\SlotController@create');
    Route::get('advisor/slot/delete/{id}','App\Http\Controllers\Advisor\SlotController@delete');
    Route::get('advisor/slot/status/{id}','App\Http\Controllers\Advisor\SlotController@changeStatus');


                                    /// Service \\\

            Route::group(['prefix' => '/advisor/service/'], function() {
                Route::controller(App\Http\Controllers\Advisor\ServiceController::class)->group(function () {
                    Route::get('show/{id}','index');
                    Route::post('create','createOrupdate');
                    // Route::get('edit/{id}','edit');
                    // Route::post('update','update');
                    // Route::get('delete/{id}','delete');
                    Route::get('status/{id}','changeStatus');
                });
            });   


                                                /// Booking \\\

            Route::group(['prefix' => '/advisor/booking/'], function() {
                Route::controller(App\Http\Controllers\Advisor\BookingController::class)->group(function () {
                    Route::get('show/{id}','index');
                    // Route::post('create','createOrupdate');
                    // Route::get('edit/{id}','edit');
                    // Route::post('update','update');
                    // Route::get('delete/{id}','delete');
                    Route::get('status/{id}','changeStatus');
                });
            }); 

    
}); 


                        /// user Register
            Route::post('/register','App\Http\Controllers\User\AuthController@register');
            Route::get('/phone/verify/{id}','App\Http\Controllers\User\AuthController@is_phone');
            Route::get('/profile/view/{id}', 'App\Http\Controllers\User\AuthController@profile_view');


                                    //advisor Register

    Route::post('advisor/register','App\Http\Controllers\Advisor\AuthController@register');
    Route::get('advisor/phone/verify/{id}','App\Http\Controllers\Advisor\AuthController@is_phone');
    Route::get('advisor/profile/view/{id}', 'App\Http\Controllers\Advisor\AuthController@profile_view');
    Route::post('advisor/profile', 'App\Http\Controllers\Advisor\AuthController@profile_update');
    Route::get('advisor/profile/check', 'App\Http\Controllers\Advisor\AuthController@usercheck');
    Route::get('advisor/status/{id}', 'App\Http\Controllers\Advisor\AuthController@is_active');


    Route::get('/home/{id}','App\Http\Controllers\User\HomeController@index');








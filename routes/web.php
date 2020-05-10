<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route to handle page reload in Vue except for api routes
Route::get('/admin/{any?}', function () {
    return view('welcome');
})->where('any', '^(?!api\/)[\/\w\.-]*');
Route::group([
    'middleware' => ['web']
], function () {
    Route::get('/redirect-twitter', 'SocialAuthFacebookController@redirectTwitter')->name('redirectTwitter');
    Route::get('/callback-twitter', 'SocialAuthFacebookController@callbackTwitter')->name('callbackTwitter');
    Route::post('rating', 'HomeController@rating');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::post('password/reset', 'AuthController@reset')->name('password.update');
    Route::get('/redirect-google', 'SocialAuthFacebookController@redirectGoogle')->name('redirectGoogle');
    Route::get('/callback-google', 'SocialAuthFacebookController@callbackGoogle')->name('callbackGoogle');
    Route::get('/redirect', 'SocialAuthFacebookController@redirect')->name('redirect');
    Route::get('/callback', 'SocialAuthFacebookController@callback')->name('callback');
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/search', 'HomeController@search')->name('search');
    Route::post('/login', 'HomeController@login')->name('login');
    Route::post('/register', 'HomeController@register')->name('register');
    Route::get('/logout', 'HomeController@logout')->name('logout');
    Route::get('/{movie}', 'HomeController@detail')->name('detail');
    Route::get('cast/{member}', 'HomeController@cast')->name('cast');
    Route::get('{movie}/{id}', 'HomeController@watch')->name('watch');
});
Route::group(['middleware' => ['checkTokenResetPassword']], function() {
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
});
// Route to handle page reload in Vue except for api routes

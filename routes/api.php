<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// User

Route::get('/', 'HomeController@index');
Route::get('/slides', 'HomeController@slides');
Route::get('/ranking', 'HomeController@ranking');
Route::get('/header', 'HomeController@header');
Route::get('/{movie}', 'HomeController@detail');
Route::get('watch/{id}', 'HomeController@watch');
Route::post('comment', 'CommentController@comment');
Route::get('listcomment/{id}/{record}', 'CommentController@listComment');
Route::get('listchildcomment/{comment_id}/{record}', 'CommentController@listChildComment');
Route::get('view/{episode}', 'EpisodeController@view');
Route::get('view-trailer/{trailer}', 'TrailerController@view');


// Admin
Route::post('image', 'HelperController@store');
Route::post('uploads', 'HelperController@uploadVideo');
Route::post('uploads/destroy/{upload}', 'HelperController@destroy');
Route::get('image/{url}', 'HelperController@checkImages');
Route::post('uploads/destroys', 'HelperController@destroys');
Route::prefix('auth')->group(function () {
    Route::post('register', ['as' => 'admin.register', 'uses' => 'AuthController@register']);
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
//        Route::get('users', 'UserController@index')->middleware('isAdmin');
//        Route::get('users/{id}', 'UserController@show')->middleware('isAdminOrSelf');
        Route::get('country', 'CountryController@getAll');
        Route::prefix('member')->group(function () {
            Route::get('/', 'MemberController@index');
            Route::get('/data', 'MemberController@data');
            Route::get('/{member}', 'MemberController@show');
            Route::get('detail/{member}', 'MemberController@detail');
            Route::post('edit/{member}', 'MemberController@update');
            Route::post('create', 'MemberController@addNew');
            Route::post('destroy/{member}', 'MemberController@destroy');
            Route::post('destroymultiple', 'MemberController@destroyMultiple');
        });
        Route::prefix('users')->group(function () {
            Route::get('/', 'UserController@index');
            Route::get('/data', 'UserController@data');
            Route::get('/{user}', 'UserController@show');
            Route::post('create', ['as' => 'admin.users.create', 'uses' => 'UserController@store']);
            Route::post('edit/{user}', ['as' => 'admin.users.edit', 'uses' => 'UserController@edit']);
            Route::post('destroy/{user}', 'UserController@destroy');
            Route::post('destroymultiple', 'UserController@destroyMultiple');
        });
        Route::prefix('tag')->group(function () {
            Route::get('/', 'TagController@index');
            Route::get('/data', 'TagController@data');
            Route::get('/{tag}', 'TagController@show');
            Route::post('create', ['as' => 'admin.tag.create', 'uses' => 'TagController@store']);
            Route::post('edit/{tag}', ['as' => 'admin.tag.edit', 'uses' => 'TagController@update']);
            Route::post('destroy/{tag}', 'TagController@destroy');
            Route::post('destroymultiple', 'TagController@destroyMultiple');
        });
        Route::prefix('category')->group(function () {
            Route::get('/', 'CategoryController@index');
            Route::get('/data', 'CategoryController@data');
            Route::get('/{category}', 'CategoryController@show');
            Route::post('edit/{category}', ['as' => 'admin.category.edit', 'uses' => 'CategoryController@update']);
            Route::post('create', ['as' => 'admin.category.create', 'uses' => 'CategoryController@store']);
            Route::post('destroy/{category}', 'CategoryController@destroy');
            Route::post('destroymultiple', 'CategoryController@destroyMultiple');
        });
        Route::prefix('movie')->group(function () {
            Route::get('/', 'MovieController@index');
            Route::get('/data', 'MovieController@data');
            Route::get('/list', 'MovieController@getMovies');
            Route::get('/{movie}', 'MovieController@show');
            Route::post('edit/{movie}', ['as' => 'admin.movie.edit', 'uses' => 'MovieController@update']);
            Route::post('create', ['as' => 'admin.movie.create', 'uses' => 'MovieController@store']);
            Route::post('destroy/{movie}', 'MovieController@destroy');
            Route::post('destroymultiple', 'MovieController@destroyMultiple');
        });
        Route::prefix('episode')->group(function () {
            Route::get('/{episode}', 'EpisodeController@show');
            Route::post('edit/{episode}', ['as' => 'admin.episode.edit', 'uses' => 'EpisodeController@update']);
            Route::post('destroy/{episode}', 'EpisodeController@destroy');
        });
        Route::prefix('trailer')->group(function () {
            Route::post('edit/{trailer}', ['as' => 'admin.trailer.edit', 'uses' => 'TrailerController@update']);
            Route::post('destroy/{trailer}', 'TrailerController@destroy');
        });
    });
});

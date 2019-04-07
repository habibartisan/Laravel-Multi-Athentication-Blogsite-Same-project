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

Auth::routes();
Route::get('/','HomeController@index')->name('home');
//All post show
Route::get('posts','PostController@index')->name('post.index');
//single page show
Route::get('post/{slug}','PostController@details')->name('post.details');
//Author post show
Route::get('profile/{username}','AuthorController@profile')->name('author.profile');


//
Route::get('/category/{slug}','PostController@postByCategory')->name('category.posts');
Route::get('/tag/{slug}','PostController@postByTag')->name('tag.posts');
//

Route::post('subscriber','SubscriberController@store')->name('subscriber.store');

//search option

Route::get('/search','SearchController@search')->name('search');


//Favorite+Comment-sectiom
Route::group(['middleware'=>['auth']], function (){
    Route::post('favorite/{post}/add','FavoriteController@add')->name('post.favorite');
    Route::post('comment/{post}','CommentController@store')->name('comment.store');
});

//admin
Route::group(['as'=>'admin.','prefix'=>'admin','namespace'=>'admin','middleware'=>['auth','admin']], function (){
    Route::get('dashboard','DashboardController@index')->name('dashboard');

    Route::get('settings','SettingsController@index')->name('settings');
    Route::put('profile-update','SettingsController@updateProfile')->name('profile.update');
    Route::put('password-update','SettingsController@updatePassword')->name('password.update');

    Route::resource('tag','TagController');
    Route::resource('category','CategoryController');
    Route::resource('post','PostController');

    Route::get('/pending/post','PostController@pending')->name('post.pending');
    Route::put('/post/{id}/approve','PostController@approval')->name('post.approve');
//Favorite
    Route::get('/favorite','FavoriteController@index')->name('favorite.index');

    Route::get('/subscriber','SubscriberController@index')->name('subscriber.index');
    Route::delete('/subscriber/{subscriber}','SubscriberController@destroy')->name('subscriber.destroy');

 //Author find

    Route::get('authors','AuthorController@index')->name('author.index');
    Route::delete('authors/{id}','AuthorController@destroy')->name('author.destroy');

});

//Auther
Route::group(['as'=>'author.','prefix'=>'author','namespace'=>'Author','middleware'=>['auth','author']], function (){
    Route::get('dashboard','DashboardController@index')->name('dashboard');

    Route::get('settings','SettingsController@index')->name('settings');
    Route::put('profile-update','SettingsController@updateProfile')->name('profile.update');
    Route::put('password-update','SettingsController@updatePassword')->name('password.update');

    Route::resource('post','PostController');

    //Favorite
    Route::get('/favorite','FavoriteController@index')->name('favorite.index');

});

View::composer('layouts.frontend.partial.footer',function ($view) {
    $categories = App\Category::all();
    $view->with('categories',$categories);
});
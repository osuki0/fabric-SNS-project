<?php

Auth::routes();
Route::get('/', function () {
    return view('auth.login');
});

Route::get('posts/{post}/edit_image', 'PostController@editImage')->name('posts.edit_image');
Route::patch('posts/{post}/edit_image', 'PostController@saveImage')->name('posts.save_image');
Route::delete('posts/{post}/edit_image', 'PostController@destroyImage')->name('posts.destroy_image');
Route::resource('posts', 'PostController')->only([
    'create', 'store', 'show', 'edit', 'update', 'destroy'
]);
 
Route::get('users/{user}/edit_image', 'UserController@editImage')->name('users.edit_image');
Route::patch('users/{user}/edit_image', 'UserController@updateImage')->name('users.update_image');
Route::resource('users', 'UserController')->only([
    'index', 'show', 'edit', 'update', 'destroy'
]);

Route::resource('follows', 'FollowController')->only([
    'show', 'store', 'destroy'
]);

Route::resource('comments', 'CommentController')->only([
  'store', 'destroy'
]);

Route::get('orders/{order}/confirm', 'OrderController@confirm')->name('orders.confirm');
Route::post('orders/{order}/confirm', 'OrderController@store')->name('orders.order_store');
Route::get('orders/{order}/finish', 'OrderController@finish')->name('orders.finish');
Route::resource('orders', 'OrderController')->only([
    'store', 'show'
]);

Route::get('/getJson','UserController@getJson')->name('getJson');

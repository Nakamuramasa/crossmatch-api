<?php
Route::group(['middleware' => ['auth:api']], function(){
    Route::get('me', 'User\MeController@getMe');
    Route::post('logout', 'Auth\LoginController@logout');
    Route::post('settings/profile', 'User\SettingsController@updateProfile');
    Route::put('settings/password', 'User\SettingsController@updatePassword');

    Route::get('users', 'User\UserController@index');
    Route::get('user/{id}', 'User\UserController@findUser');
    Route::get('user/{username}', 'User\UserController@findByUsername');

    Route::get('matching', 'Match\MatchingController@findMatchUser');

    // Route::get('like', 'Reaction\ReactionController@index');
    Route::post('like', 'Reaction\ReactionController@store');
    Route::put('like/{id}', 'Reaction\ReactionController@update');
    Route::delete('like/{id}', 'Reaction\ReactionController@destroy');
    Route::get('like/{id}', 'Reaction\ReactionController@findById');

    Route::post('chats', 'Chats\ChatController@sendMessage');
    Route::post('chats/show', 'Chats\ChatController@showChatRoom');
    Route::get('chats', 'Chats\ChatController@getUserChats');
    Route::put('chats/{id}/markAsRead', 'Chats\ChatController@markAsRead');
    Route::delete('messages/{id}', 'Chats\ChatController@destroyMessage');

    // Route::post('invitations/{chatId}', 'Chats\InvitationsController@invite');
    // Route::post('invitations/{id}/resend', 'Chats\InvitationsController@resend');
    // Route::post('invitations/{id}/respond', 'Chats\InvitationsController@respond');
    // Route::delete('invitations/{id}', 'Chats\InvitationsController@destroy');
});

Route::group(['middleware' => ['guest:api']], function(){
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('verification/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('verification/resend', 'Auth\VerificationController@resend');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
});

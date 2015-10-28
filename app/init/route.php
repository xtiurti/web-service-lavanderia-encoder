<?php

# Auth Basic Routes
Route::add('/', 'offline\Users login');
Route::add('/offline', 'offline\Users login');
Route::add('/sign_up', 'offline\Users sign_up');
Route::add('/logout', 'admin\Users logout');

# Auth Email Routes
Route::add('/password_forgot_email', 'offline\Users password_forgot_email');
Route::add('/confirm_account_email', 'offline\Users confirm_account_email');
Route::add('/password_expired_email', 'offline\Users password_expired_email');
Route::add('/unlock_account_email', 'offline\Users unlock_account_email');

# Auth Hash Routes
Route::add('/confirm_account', 'offline\Users confirm_account');
Route::add('/password_forgot', 'offline\Users password_forgot');
Route::add('/unlock_account', 'offline\Users unlock_account');
Route::add('/password_expired', 'offline\Users password_expired');

# admin
Route::add('/admin', 'admin\Users index');
Route::add('/paginate', 'admin\Users paginate');
<?php
use Illuminate\Support\Facades\Route;
Route::group(['middleware' => ['web']], function () {
    Route::get('role-permission', function () {
        return view('lrp::role-permission');
    });
});

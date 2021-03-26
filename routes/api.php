<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/emails', 'MailController@index');
Route::post('/emails/store', 'MailController@store');
Route::get('/emails/{id?}', 'MailController@show');
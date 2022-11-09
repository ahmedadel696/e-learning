<?php
use \Illuminate\Support\Facades\Route;


Route::post('/contacts/login',[\App\Http\Controllers\AccountController::class,'login']);
Route::get('/contacts/profile/{user_id}',[\App\Http\Controllers\AccountController::class,'profile']);
Route::post('/contacts/account/update',[\App\Http\Controllers\AccountController::class,'updateProfile']);
Route::get('/contacts/getContacts',[\App\Http\Controllers\ContactsController::class,'getContacts']);
Route::post('/contacts/updateContact',[\App\Http\Controllers\ContactsController::class,'updateContact']);
Route::post('/contacts/addContact',[\App\Http\Controllers\ContactsController::class,'addContact']);
Route::post('/contacts/deleteContact',[\App\Http\Controllers\ContactsController::class,'deleteContact']);


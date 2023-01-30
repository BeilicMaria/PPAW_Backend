<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;

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

//..............................THIS ROUTES ARE FOR PASSPORT............................
Route::post('login', [LoginController::class, 'login']);

//..............................THIS ROUTES ARE FOR  AUTHENTICATED USERS............................
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', [LogoutController::class, 'logout']);
    //..............................USER............................
    Route::get('users/{page?}/{per_page?}/{startDate?}/{endDate?}/{order?}/{status?}/{filter?}', [UserController::class, 'index']);
    Route::get('user/{id}', [UserController::class, 'get']);
    Route::post('user', [UserController::class, 'post']);
    Route::delete('user/{id}', [UserController::class, 'delete']);
    Route::post('user/{id}', [UserController::class, 'put']);
    //..............................ROLE............................
    Route::get('roles', [RoleController::class, 'index']);
    Route::get('role/{id}', [RoleController::class, 'get']);
    //..............................SUBJECT............................
    Route::get('subjects/{page?}/{per_page?}/{filter?}', [SubjectController::class, 'index']);
    Route::post('subject', [SubjectController::class, 'post']);
    Route::get('subject/{id}', [SubjectController::class, 'get']);
    Route::delete('subject/{id}', [SubjectController::class, 'delete']);
    Route::post('subject/{id}', [SubjectController::class, 'put']);
    //..............................CLASS............................
    Route::get('classes/{page?}/{per_page?}/{filter?}', [ClassController::class, 'index']);
    Route::post('class', [ClassController::class, 'post']);
    Route::get('class/{id}', [ClassController::class, 'get']);
    Route::delete('class/{id}', [ClassController::class, 'delete']);
    Route::post('class/{id}', [ClassController::class, 'put']);
      //..............................GRADE............................

});
Route::delete('grade/{id}', [GradeController::class, 'delete']);

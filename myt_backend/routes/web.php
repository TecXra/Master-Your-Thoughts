<?php

use Illuminate\Support\Facades\Route;
$baseControllerNameSpace = '\App\Http\Controllers\\';

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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/user/certificate/{id}', '\HealthCareProvider\HealthCareProviderController@printCertificate');
Route::get('/user/certificate/{id}' , $baseControllerNameSpace.'User\FaithFuelController@printCertificate');

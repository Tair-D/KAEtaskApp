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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('token','Auth\AccessTokenController@issueToken');
Route::post('register','Auth\RegisterController@create');

Route::group(['middleware' => 'auth:api'], function () {
   Route::group(['prefix'=>'/task'],function (){

       Route::get('/all','TaskController@getAll');
       Route::get('/all/{taskId}','TaskController@getAllTaskForOneEmployee');
//       Route::group(['prefix'=>'/all'],function(){
//           Route::get('/{id}','TaskController@getAllTaskForOneEmployee');
//           Route::get('/all/{taskId}','TaskController@getDescription');
//           Route::get('/all/{statusId}','TaskController@sortedTaskByStatus');
//           Route::get('/all/{date}','TaskController@getTaskByDate');
//           Route::get('/all/{taskId}','TaskController@getDescription');
//       });
       Route::post('/insert','TaskController@insert');

       Route::post('/update/{task_id}','TaskController@updateTask');
       Route::post('/delete/{id}','TaskController@deleteTask');



    });
});
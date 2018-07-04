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
Route::post('logout','Auth\LoginController@logout');

Route::get('/versionsTask/{version_id?}','TaskController@getTaskByVersion');//task
Route::get('/projectsTask/{project_id}','TaskController@getTaskByProject');//task

Route::group(['prefix'=>'/project'],function(){//список всех проектов
    Route::get('/all/{project_id?}','ProjectController@getAllProjects');
});
Route::group(['prefix'=>'/version'],function(){//список версии по проект
    Route::get('/all/{project_id}','VersionController@getAllVersions');
    Route::get('/get/{version_id}','VersionController@getTask');
});

Route::group(['prefix'=>'/message'],function(){
    Route::post('/to/{$user_id_receiver}','ChatController@sendMessageToNew');
});


Route::group(['middleware' => 'auth:api'], function () {
   Route::group(['prefix'=>'/task'],function (){

       Route::get('/all','TaskController@getAll');
       Route::get('/allMyTask','TaskController@getAllMyTask');//
       Route::get('/all/{task_id}','TaskController@getAllTaskForOneEmployee');

       Route::post('/insert','TaskController@insert');

       Route::get('/edit/{task_id}','TaskController@getAllTaskForOneEmployee');//edit
       Route::post('/update/{task_id}','TaskController@updateTask');
       Route::post('/delete/{id}','TaskController@deleteTask');

       Route::post('/do/{id}','TaskController@doTask');

       Route::get('/all/{date}','TaskController@getTaskByDate');

       Route::post('upload/{task_id}/{variant_id}','FileController@upload');
       Route::get('download/{id}/{variant_id}','FileController@download');


    });

   Route::group(['prefix'=>'/user'],function(){
      Route::get('/all','UserController@getAllUsers');
   });

});
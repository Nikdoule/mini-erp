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

Route::prefix('1.0')->group(function () {

    Route::get('/ping', [
        'uses' => '\App\Http\Controllers\Api\v1a\PingController@ping',
        'as' => 'test.ping'
    ]);
    Route::post('/projects/{id}/archive', [
        'uses' => '\App\Http\Controllers\Api\v1a\ProjectController@setArchived',
        'as' => 'projects.archive'
    ]);
    // Route::post('/projects/{id}/addtask', [
    //     'uses' => '\App\Http\Controllers\Api\v1a\ProjectController@addTask',
    //     'as' => 'projects.addtask'
    // ]);
    Route::delete('/projects/{projectId}/tasks', [
        'uses' => '\App\Http\Controllers\Api\v1a\TaskController@destroyByProject',
        'as' => 'projects.tasks.destroy_by_project'
    ]);

    Route::apiResource('projects', 'Api\v1a\ProjectController');
    Route::apiResource('projects/{id}/tasks', 'Api\v1a\TaskController');
});
Route::fallback(function () {
    return response()->json([
        'message' => 'No entry API for this url'
    ], 404);
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeightLogController;

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

Route::get('register/step2', [WeightLogController::class, 'getStep2']);

Route::post('register/step2', [WeightLogController::class, 'postStep2']);

Route::middleware('auth')->group(function () {
    Route::get('/weight_logs', [WeightLogController::class, 'admin']);
    Route::get('/weight_logs/goal_setting', [WeightLogController::class, 'getGoal']);
    Route::post('/weight_logs/goal_setting', [WeightLogController::class, 'postGoal']);
    Route::post('/weight_logs/create', [WeightLogController::class, 'store']);
    Route::post('/weight_logs/search', [WeightLogController::class, 'postSearch']);
    Route::get('/weight_logs/{weight_log_id}', [WeightLogController::class, 'getDetail']);
    Route::post('/weight_logs/{weight_log_id}/update', [WeightLogController::class, 'postUpdate']);
    Route::get('/weight_logs/{weight_log_id}/delete', [WeightLogController::class, 'postDelete']);
});

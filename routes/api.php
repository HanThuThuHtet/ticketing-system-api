<?php

// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Headers: Authorization');

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\CustomerApiController;
use App\Http\Controllers\QueueApiController;
use App\Http\Controllers\StatusApiController;
use App\Http\Controllers\TicketApiController;
use App\Http\Controllers\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loadted by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/register',[ApiAuthController::class,'register'])->name('api.register');
Route::post('/login',[ApiAuthController::class,'login'])->name('api.login');


Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout',[ApiAuthController::class,'logout'])->name('api.logout');
    
    Route::apiResource('tickets',TicketApiController::class);
    Route::get('all-tickets',[TicketApiController::class,'all']);
    Route::get('ticket-search',[TicketApiController::class,'search']);


    Route::apiResource('statuses',StatusApiController::class);
    Route::apiResource('customers',CustomerApiController::class);
    Route::apiResource('queues',QueueApiController::class);

    Route::get('/user/tickets',[UserApiController::class,'viewUserTickets']);
    Route::get('/user',[UserApiController::class,'user']);
    
    
});

    




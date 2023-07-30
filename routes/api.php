<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    TransactionController,
    ClientController,
    CompteController,
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/depot', [TransactionController::class,'depot']);
Route::post('/retrait', [TransactionController::class,'retrait']);
Route::post('/transfert', [TransactionController::class,'transfert']);
Route::post('/transfert-par-code', [TransactionController::class,'transfertParCode']);


Route::get('clients/{id}/transactions', [ClientController::class, 'getTransactions']);
Route::apiResource('clients', ClientController::class)->only(['index', 'store']);
Route::apiResource('comptes', CompteController::class)->only(['index', 'store']);

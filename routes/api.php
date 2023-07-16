<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ApiIp4yController;

Route::post('/customers/new', [ClienteController::class, 'store']);
Route::get('/customers', [ClienteController::class, 'index']);
Route::post('/customers/find', [ClienteController::class, 'show']);
Route::post('/customers/update', [ClienteController::class, 'edit']);
Route::delete('/customers/delete', [ClienteController::class, 'destroy']);
Route::get('/send', [ApiIp4yController::class, 'sendAll']);

?>
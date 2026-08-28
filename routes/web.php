<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;




Route::get('/', [FrontendController::class, 'index']);
Route::post('/members/store', [FrontendController::class, 'store'])->name('members.store');

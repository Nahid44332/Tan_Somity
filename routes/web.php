<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\LotteryController;
use Illuminate\Support\Facades\Route;




Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::post('/members/store', [FrontendController::class, 'store'])->name('members.store');
Route::post('/collections/store', [CollectionController::class, 'storeOrUpdate'])->name('collections.store');
Route::post('/lotteries', [LotteryController::class, 'store'])->name('lotteries.store');
Route::post('/lotteries/auto-draw', [LotteryController::class, 'autoDraw'])->name('lotteries.auto-draw');
Route::post('/lotteries/confirm', [LotteryController::class, 'confirmWinner'])->name('lotteries.confirm');

<?php

use App\Http\Controllers\PDF\RetrievalController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::controller(RetrievalController::class)->group(function () {
        Route::get('/pdf/retrieval/{id}', 'generate')->name('pdf.retrieval');
    });
});

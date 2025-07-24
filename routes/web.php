<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebFormController;

Route::get('/', [WebFormController::class, 'showForm'])->name('form');
Route::post('/', [WebFormController::class, 'submitForm'])->name('form.submit');
Route::get('/Success', function () {
    return view('Success');
})->name('form.Success');

<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');

Route::middleware('admin')->group(function () {
    Route::get('/admin/progetti/nuovo', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/admin/store-progetti', [ProjectController::class, 'store'])
        ->name('projects.store');
    Route::get('/admin/progetti/{project}/modifica', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/admin/progetti/{project}', [ProjectController::class, 'update'])->name('projects.update');
});

Route::get('/admin/progetti', [ProjectController::class, 'index'])->name('projects.index');

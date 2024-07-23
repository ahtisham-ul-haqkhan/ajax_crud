<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('index');
});


Route::get('show', [EmployeeController::class, 'show'])->name('show_emp');
Route::post('store', [EmployeeController::class, 'store'])->name('post_emp');
Route::get('destroy', [EmployeeController::class, 'destroy'])->name('del_emp');
Route::get('edit/{employee}', [EmployeeController::class, 'edit'])->name('edit_emp');
Route::put('update/{employee}', [EmployeeController::class, 'update'])->name('update_emp');

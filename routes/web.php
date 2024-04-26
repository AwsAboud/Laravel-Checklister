<?php

use App\Http\Controllers\Admin\ChecklistController;
use App\Http\Controllers\Admin\ChecklistGroupController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

   Route::group(['middleware' => 'is_admin', 'prefix' => 'admin', 'as' => 'admin.'],function () {
        Route::resource('pages', PageController::class)->only(['edit', 'update']);
        Route::resource('checklist-groups', ChecklistGroupController::class)->except(['index', 'show']);
        Route::resource('checklist-groups.checklists', ChecklistController::class)->except(['index', 'show']);
        Route::resource('checklists.tasks', TaskController::class)->except(['index', 'show', 'create']);

   });
});

require __DIR__.'/auth.php';

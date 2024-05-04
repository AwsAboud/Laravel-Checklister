<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ChecklistController;
use App\Http\Controllers\Admin\ChecklistGroupController;
use App\Http\Controllers\Admin\ImageController;

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

Route::redirect('/', 'welcome');

Route::get('/dashboard', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'save_last_action_timestamp'])->group(function () {
    Route::get('welcome', [App\Http\Controllers\PageController::class, 'welcome'])->name('welcome');
    Route::get('consultation', [App\Http\Controllers\PageController::class, 'consultation'])->name('consultation');
    Route::get('users/{checklist}', [App\Http\Controllers\User\ChecklistController::class, 'show'])->name('user.checklists.show');

    Route::group(['middleware' => 'is_admin', 'prefix' => 'admin', 'as' => 'admin.'],function () {
        Route::resource('pages', PageController::class)->only(['edit', 'update']);
        Route::resource('checklist-groups', ChecklistGroupController::class)->except(['index', 'show']);
        Route::resource('checklist-groups.checklists', ChecklistController::class)->except(['index', 'show']);
        Route::resource('checklists.tasks', TaskController::class)->except(['index', 'show', 'create']);
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::post('image-upload', [ImageController::class, 'store'])->name('image.store');
   });
});

require __DIR__.'/auth.php';

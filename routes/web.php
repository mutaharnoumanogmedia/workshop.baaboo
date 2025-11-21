<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\WorkshopController;
use App\Http\Livewire\Admin\Dashboard;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
    if(Auth::check()){
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->middleware(['auth', 'verified']);


Route::post('/magic-link', [\App\Http\Controllers\Auth\MagicLinkController::class, 'send'])
    ->name('magic-link.send')->middleware("throttle:20,60");

Route::get('/magic-link/verify/{token}', [\App\Http\Controllers\Auth\MagicLinkController::class, 'verify'])
    ->name('magic-link.verify');

Route::get('/dashboard', function () {
    try {
        $roles = \Auth::user()->getRoleNames();
        if ($roles->isEmpty()) {
            return abort(403, "Unauthorized action. You have no role assigned.");
        }
        if ($roles->contains('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($roles->contains('editor')) {
            return view('editor.dashboard');
        } elseif ($roles->contains('moderator')) {
            return view('moderator.dashboard');
        } elseif ($roles->contains('user')) {
            return redirect()->route('user.dashboard');
        } else {
            return abort(403, "Unauthorized action. Your role {" . $roles->join(', ') . "} does not have access.");
        }
    } catch (\Exception $e) {
        return abort(403, "Unauthorized action. Your role  " . \Auth::user()->getRoleNames() . "  is not recognized." . $e->getMessage());
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



//admin routes

Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('admin.dashboard');
});

Route::prefix("user")->middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

    Route::get('/my-workshops', [WorkshopController::class, 'index'])->name('user.workshops');
    Route::get('/workshop/{id}/{chapter_id?}/{video_id?}', [WorkshopController::class, 'show'])->name('user.workshop.show');
    Route::get('/workshop/{id}/module/{moduleId}', [WorkshopController::class, 'module'])->name('user.workshop.module');
    Route::get('/favorites', [App\Http\Controllers\User\FavoriteController::class, 'index'])->name('user.favorites');
    Route::get('/certificates', [App\Http\Controllers\User\CertificateController::class, 'index'])->name('user.certificates');
    Route::get('/schedule', [App\Http\Controllers\User\ScheduleController::class, 'index'])->name('user.schedule');
    Route::get('/downloads', [App\Http\Controllers\User\DownloadController::class, 'index'])->name('user.downloads');
    Route::get('/settings', [App\Http\Controllers\User\SettingsController::class, 'index'])->name('user.settings');
});


require __DIR__ . '/auth.php';

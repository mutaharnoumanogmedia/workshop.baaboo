<?php

use App\Http\Controllers\ProfileController;
use App\Http\Livewire\Admin\Dashboard;
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
})->middleware(['auth', 'verified']);

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
        } else {
            return abort(403, "Unauthorized action. Your role {" . $roles->join(', ') . "} does not have access.");
        }
    } catch (\Exception $e) {
        return abort(403, "Unauthorized action. Your role {" . \Auth::user()->getRoleNames() . "} is not recognized.");
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


require __DIR__ . '/auth.php';

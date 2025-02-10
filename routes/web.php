<?php

use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\WorkspaceInvitationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/fr_locale', function() {
        return dd(Session::get('fr_locale'));
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('/professors')->group(function () {
        Route::post('/complete-registration', [ProfessorController::class, 'store'])->name('professors.create');
        Route::get('/my-profile', [ProfessorController::class, 'showOverview'])->name('professors.my-profile.overview');
        Route::get('/my-profile/educations', [ProfessorController::class, 'showEducations'])->name('professors.my-profile.educations');
        Route::get('/my-profile/languages', [ProfessorController::class, 'showLanguages'])->name('professors.my-profile.languages');
        Route::get('/my-profile/teaching-interests', [ProfessorController::class, 'showTeachingInterests'])->name('professors.my-profile.teaching-interests');
    });

});

Route::middleware(['auth', 'verified', 'isAdmin'])->prefix('/admin')->group(function () {
    Route::get('/', [DashboardController::class, 'adminIndex'])->name('admin.dashboard');

    Route::name('workspace-management.')->group(function () {
        Route::resource('/workspace-management/invitations', WorkspaceInvitationController::class);
    });

    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserManagementController::class);
        Route::resource('/user-management/roles', RoleManagementController::class);
        Route::resource('/user-management/permissions', PermissionManagementController::class);
    });
});

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);


Route::get('/locale/{locale}', function (Request $request) {
    Session::put('locale', $request->locale);
    return redirect()->back();
})->name('locale');

require __DIR__ . '/auth.php';

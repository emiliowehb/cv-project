<?php

use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\ReportsGeneratorController;
use App\Http\Controllers\ReviewableController;
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
        Route::get('/directory', [ProfessorController::class, 'showDirectory'])->name('professors.directory');
        Route::post('/directory', [ProfessorController::class, 'searchDirectory'])->name('professors.directory.search');
        Route::get('/directory/{professor}', [ProfessorController::class, 'showDirectoryProfile'])->name('professors.directory.profile');
        Route::get('/publications-directory', [ProfessorController::class, 'getPublications'])->name('professors.directory.publications');
        Route::post('/complete-registration', [ProfessorController::class, 'store'])->name('professors.create');
        Route::get('/my-profile', [ProfessorController::class, 'showOverview'])->name('professors.my-profile.overview');
        Route::get('/my-profile/educations', [ProfessorController::class, 'showEducations'])->name('professors.my-profile.educations');
        Route::get('/my-profile/languages', [ProfessorController::class, 'showLanguages'])->name('professors.my-profile.languages');
        Route::get('/my-profile/teaching-interests', [ProfessorController::class, 'showTeachingInterests'])->name('professors.my-profile.teaching-interests');
        Route::get('/my-profile/employment-history', [ProfessorController::class, 'showEmploymentHistory'])->name('professors.my-profile.employment-history');
        Route::get('/my-profile/grants', [ProfessorController::class, 'showGrants'])->name('professors.my-profile.grants');
        Route::get('/my-profile/other-articles', [ProfessorController::class, 'showOtherArticles'])->name('professors.my-profile.other-articles');
        Route::get('/my-profile/journal-articles', [ProfessorController::class, 'showJournalArticles'])->name('professors.my-profile.journal-articles');
        Route::get('/my-profile/books', [ProfessorController::class, 'showBooks'])->name('professors.my-profile.books');
        Route::get('/my-profile/book-chapters', [ProfessorController::class, 'showBookChapters'])->name('professors.my-profile.book-chapters');
        Route::get('/my-profile/research-interests', [ProfessorController::class, 'showRInterests'])->name('professors.my-profile.research-interests');
        Route::get('/my-profile/magazine-articles', [ProfessorController::class, 'showMagazineArticles'])->name('professors.my-profile.magazine-articles');
        Route::get('/my-profile/cases', [ProfessorController::class, 'showCaseArticles'])->name('professors.my-profile.cases');
        Route::get('/my-profile/newspaper-articles', [ProfessorController::class, 'showNewspaperArticles'])->name('professors.my-profile.newspaper-articles');
        Route::get('/my-profile/newsletter-articles', [ProfessorController::class, 'showNewsletters'])->name('professors.my-profile.newsletter-articles');
        Route::get('/my-profile/graduate-supervisions', [ProfessorController::class, 'showSupervisions'])->name('professors.my-profile.supervisions');
        Route::get('/my-profile/electronic-media', [ProfessorController::class, 'showElectronicMedia'])->name('professors.my-profile.electronic-media');
        Route::get('/my-profile/interviews', [ProfessorController::class, 'showInterviews'])->name('professors.my-profile.interviews');
        Route::get('/my-profile/activities', [ProfessorController::class, 'showActivities'])->name('professors.my-profile.activities');
        Route::get('/my-profile/book-reviews', [ProfessorController::class, 'showBookReviews'])->name('professors.my-profile.book-reviews');
        Route::get('/my-profile/working-papers', [ProfessorController::class, 'showWorkingPapers'])->name('professors.my-profile.working-papers');
        Route::get('/my-profile/letters-to-editors', [ProfessorController::class, 'showLTEArticles'])->name('professors.my-profile.lte-articles');
        Route::get('/my-profile/courses', [ProfessorController::class, 'showCourses'])->name('professors.my-profile.courses');
        Route::get('/my-profile/presentations', [ProfessorController::class, 'showPresentations'])->name('professors.my-profile.presentations');
        Route::get('/my-profile/honors-and-awards', [ProfessorController::class, 'showHonors'])->name('professors.my-profile.honors');
        Route::get('/my-profile/technical-reports', [ProfessorController::class, 'showTechnicalReports'])->name('professors.my-profile.technical-reports');
        Route::get('/my-profile/expertise-areas', [ProfessorController::class, 'showExpertiseAreas'])->name('professors.my-profile.expertise-areas');
        Route::get('/my-profile/outside-courses', [ProfessorController::class, 'showOutsideCourses'])->name('professors.my-profile.outside-courses');
        Route::get('/cv-builder', [ProfessorController::class, 'showCVBuilder'])->name('professors.cv-builder');
        Route::post('/cv-builder', [ProfessorController::class, 'submitBuild'])->name('professors.cv-builder.submit');
    });

    // Authors resource routes
    Route::resource('/authors', AuthorController::class);

});

Route::middleware(['auth', 'verified', 'isAdmin'])->prefix('/admin')->group(function () {
    Route::get('/', [DashboardController::class, 'adminIndex'])->name('admin.dashboard');

    Route::name('workspace-management.')->group(function () {
        Route::resource('/workspace-management/invitations', WorkspaceInvitationController::class);
    });

    Route::name('reports-generator.')->prefix('/reports-generator')->group(function () {
        Route::get('/', [ReportsGeneratorController::class, 'show'])->name('index');
        Route::post('/generate', [ReportsGeneratorController::class, 'generateReport'])->name('submit');
    });
    
    Route::name('admin.professor-submissions.')->prefix('/professor-submissions')->group(function () {
        Route::get('/books', [ReviewableController::class, 'showBookSubmissions'])->name('book-submissions');
        Route::get('/book-chapters', [ReviewableController::class, 'showBookChaptersSubmissions'])->name('book-chapter-submissions');
        Route::get('/journal-articles', [ReviewableController::class, 'showJournalArticlesSubmissions'])->name('journal-articles-submissions');
        Route::get('/magazine-articles', [ReviewableController::class, 'showMagazineArticlesSubmissions'])->name('magazine-articles-submissions');
        Route::get('/case-articles', [ReviewableController::class, 'showCaseArticlesSubmissions'])->name('case-articles-submissions');
        Route::get('/newsletter-articles', [ReviewableController::class, 'showNewsletterArticlesSubmissions'])->name('newsletter-articles-submissions');
        Route::get('/newspaper-articles', [ReviewableController::class, 'showNewspaperArticlesSubmissions'])->name('newspaper-articles-submissions');
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

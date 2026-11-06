<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InsightController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/services/{id}', [ServiceController::class, 'show'])->name('services.show');
Route::post('/services/{id}/contact', [ServiceController::class, 'contact'])->name('services.contact');
Route::get('/sub-services/{id}', [\App\Http\Controllers\SubServiceController::class, 'show'])->name('sub-services.show');
Route::get('/team', [TeamController::class, 'index'])->name('team');
Route::get('/careers', [CareerController::class, 'index'])->name('careers');
Route::post('/careers/{id}/apply', [CareerController::class, 'apply'])->name('careers.apply');
Route::post('/careers/application/submit', [CareerController::class, 'submitApplication'])->name('careers.application.submit');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/contact/form/submit', [ContactController::class, 'submitForm'])->name('contact.form.submit');
Route::get('/api/services/{id}/sub-services', [\App\Http\Controllers\ServiceController::class, 'getSubServices'])->name('api.services.sub-services');
Route::post('/api/chatbot/answer', [ChatbotController::class, 'answer'])->name('api.chatbot.answer');
Route::get('/contact-details', [\App\Http\Controllers\ContactDetailController::class, 'show'])->name('contact-details.show');
Route::get('/insights', [InsightController::class, 'index'])->name('insights');
Route::get('/insights/{id}', [InsightController::class, 'show'])->name('insights.show');
Route::get('/privacy-policy', function() {
    $page = \App\Models\Page::getBySlug('privacy-policy');
    if (!$page) abort(404);
    return view('page', compact('page'));
})->name('privacy-policy');
Route::get('/terms-of-service', function() {
    $page = \App\Models\Page::getBySlug('terms-of-service');
    if (!$page) abort(404);
    return view('page', compact('page'));
})->name('terms-of-service');

// Block old /admin path - return 404 to hide admin existence
Route::any('/admin/{any?}', function () {
    abort(404);
})->where('any', '.*');

// Secret Admin Routes - Access via: yoursite.com/{ADMIN_SECRET_PATH}
// Default: yoursite.com/secure-admin-9a2024 (change ADMIN_SECRET_PATH in .env)
$adminPath = config('app.admin_secret_path', 'secure-admin-9a2024');

Route::prefix($adminPath)->name('admin.')->group(function () {
    // Authentication Routes
    Route::get('/', [\App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/', [\App\Http\Controllers\Admin\AuthController::class, 'login']);
    Route::post('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');
    
    // Protected Admin Routes
    Route::middleware(['auth', 'admin.session'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // IT Services hub (manages IT Service, IT Manager, Portfolio, Leadership, IT Team)
        Route::get('/it-services', [\App\Http\Controllers\Admin\ItServicesController::class, 'index'])->name('it-services.index');

        Route::get('/it-services/team', [\App\Http\Controllers\Admin\ItServicesTeamController::class, 'index'])->name('it-services.team.index');
        Route::get('/it-services/team/create', [\App\Http\Controllers\Admin\ItServicesTeamController::class, 'create'])->name('it-services.team.create');
        Route::post('/it-services/team', [\App\Http\Controllers\Admin\ItServicesTeamController::class, 'store'])->name('it-services.team.store');
        Route::get('/it-services/team/{leader}/edit', [\App\Http\Controllers\Admin\ItServicesTeamController::class, 'edit'])->name('it-services.team.edit');
        Route::put('/it-services/team/{leader}', [\App\Http\Controllers\Admin\ItServicesTeamController::class, 'update'])->name('it-services.team.update');
        Route::delete('/it-services/team/{leader}', [\App\Http\Controllers\Admin\ItServicesTeamController::class, 'destroy'])->name('it-services.team.destroy');
        Route::patch('/it-services/team/{leader}/toggle', [\App\Http\Controllers\Admin\ItServicesTeamController::class, 'toggle'])->name('it-services.team.toggle');
        
        // Insights Management
        Route::resource('insights', \App\Http\Controllers\Admin\InsightController::class);
        
        // Categories Management
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        
        // Jobs Management
        Route::resource('jobs', \App\Http\Controllers\Admin\JobController::class);
        
        // Leaders Management
        Route::resource('leaders', \App\Http\Controllers\Admin\LeaderController::class);
        Route::patch('/leaders/{leader}/toggle', [\App\Http\Controllers\Admin\LeaderController::class, 'toggle'])->name('leaders.toggle');
        
        // Services Management
        Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);
        Route::patch('/services/{service}/toggle', [\App\Http\Controllers\Admin\ServiceController::class, 'toggle'])->name('services.toggle');
        
        // Sub-Services Management
        Route::get('/services/{service}/sub-services', [\App\Http\Controllers\Admin\SubServiceController::class, 'index'])->name('sub-services.index');
        Route::get('/services/{service}/sub-services/create', [\App\Http\Controllers\Admin\SubServiceController::class, 'create'])->name('sub-services.create');
        Route::post('/services/{service}/sub-services', [\App\Http\Controllers\Admin\SubServiceController::class, 'store'])->name('sub-services.store');
        Route::get('/sub-services/{subService}/edit', [\App\Http\Controllers\Admin\SubServiceController::class, 'edit'])->name('sub-services.edit');
        Route::put('/sub-services/{subService}', [\App\Http\Controllers\Admin\SubServiceController::class, 'update'])->name('sub-services.update');
        Route::delete('/sub-services/{subService}', [\App\Http\Controllers\Admin\SubServiceController::class, 'destroy'])->name('sub-services.destroy');
        Route::patch('/sub-services/{subService}/toggle', [\App\Http\Controllers\Admin\SubServiceController::class, 'toggle'])->name('sub-services.toggle');
        
        // IT Manager Profile (single record)
        Route::get('/it-manager', [\App\Http\Controllers\Admin\ItManagerProfileController::class, 'edit'])->name('it-manager.edit');
        Route::put('/it-manager', [\App\Http\Controllers\Admin\ItManagerProfileController::class, 'update'])->name('it-manager.update');

        // Portfolio Items (IT Services)
        Route::resource('portfolio-items', \App\Http\Controllers\Admin\PortfolioItemController::class)->parameters(['portfolio-items' => 'portfolioItem']);

        // Milestones Management
        Route::resource('milestones', \App\Http\Controllers\Admin\MilestoneController::class);

        // Settings Management
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
        Route::get('/settings/database/export', [\App\Http\Controllers\Admin\SettingsController::class, 'exportDatabase'])->name('settings.database.export');

        // Pages Management (Privacy Policy, Terms of Service)
        Route::get('/pages', [\App\Http\Controllers\Admin\PageController::class, 'index'])->name('pages.index');
        Route::get('/pages/{page}/edit', [\App\Http\Controllers\Admin\PageController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{page}', [\App\Http\Controllers\Admin\PageController::class, 'update'])->name('pages.update');

        // Contact Details Management
        Route::get('/contact-details', [\App\Http\Controllers\Admin\ContactDetailController::class, 'edit'])->name('contact-details.edit');
        Route::put('/contact-details', [\App\Http\Controllers\Admin\ContactDetailController::class, 'update'])->name('contact-details.update');
    });
});

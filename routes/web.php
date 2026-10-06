<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\CollectionItemController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\ContactSubmissionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SiteAssetController;
use App\Http\Controllers\Admin\VisualEditorController;
use App\Http\Controllers\ContactSubmissionController as PublicContactSubmissionController;
use App\Http\Controllers\PublicCollectionController;
use App\Http\Controllers\SiteContentController;
use App\Http\Middleware\EnsureAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/services', function () {
    return view('pages.services');
})->name('services');

Route::get('/products', function () {
    return view('pages.products');
})->name('products');

Route::get('/case-studies', function () {
    return view('pages.case-studies');
})->name('case-studies');

Route::get('/blog', function () {
    return view('pages.blog');
})->name('blog');

Route::get('/blog-detail', function () {
    return view('pages.blog-detail');
})->name('blog-detail');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');
Route::post('/contact', [PublicContactSubmissionController::class, 'store'])->middleware('throttle:5,1')->name('contact.submit');

Route::get('/faqs', function () {
    return view('pages.faqs');
})->name('faqs');

Route::get('/privacy-policy', function () {
    return view('pages.privacy-policy');
})->name('privacy-policy');

Route::get('/error-404', function () {
    return view('pages.error-404');
})->name('error-404');

Route::get('/api/site-content', [SiteContentController::class, 'index'])->name('site-content.index');
Route::get('/api/collections/{collection}', PublicCollectionController::class)->name('collections.public');
Route::post('/api/site-content/save', [SiteContentController::class, 'store'])->middleware(EnsureAdmin::class)->name('site-content.save');
Route::get('/api/{collection}', PublicCollectionController::class)->name('collections.api.index');
Route::get('/api/{collection}/{item}', [PublicCollectionController::class, 'show'])->name('collections.api.show');
Route::middleware(EnsureAdmin::class)->group(function (): void {
    Route::post('/api/{collection}', [CollectionItemController::class, 'store'])->name('collections.api.store');
    Route::put('/api/{collection}/{item}', [CollectionItemController::class, 'update'])->name('collections.api.update');
    Route::delete('/api/{collection}/{item}', [CollectionItemController::class, 'destroy'])->name('collections.api.destroy');
});

Route::get('/admin/login', [AdminAuthController::class, 'create'])->name('login');
Route::post('/admin/login', [AdminAuthController::class, 'store'])->middleware('throttle:5,1')->name('admin.login.store');

Route::middleware(EnsureAdmin::class)->prefix('admin')->name('admin.')->group(function (): void {
    Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('/editor', VisualEditorController::class)->name('editor');
    Route::get('/site-assets', [SiteAssetController::class, 'index'])->name('site-assets.index');
    Route::get('/brochure', [SiteAssetController::class, 'brochure'])->name('brochure');
    Route::put('/site-assets/{asset}', [SiteAssetController::class, 'update'])->name('site-assets.update');
    Route::resource('companies', CompanyController::class)->except('show');
    Route::resource('certificates', CertificateController::class)->except('show');
    Route::get('/collections/{collection}', [CollectionItemController::class, 'index'])->name('collections.index');
    Route::get('/collections/{collection}/create', [CollectionItemController::class, 'create'])->name('collections.create');
    Route::post('/collections/{collection}', [CollectionItemController::class, 'store'])->name('collections.store');
    Route::get('/collections/{collection}/{item}/edit', [CollectionItemController::class, 'edit'])->name('collections.edit');
    Route::put('/collections/{collection}/{item}', [CollectionItemController::class, 'update'])->name('collections.update');
    Route::delete('/collections/{collection}/{item}', [CollectionItemController::class, 'destroy'])->name('collections.destroy');
    Route::get('/contact-submissions', [ContactSubmissionController::class, 'index'])->name('contact-submissions.index');
    Route::get('/contact-submissions/export', [ContactSubmissionController::class, 'export'])->name('contact-submissions.export');
});

Route::fallback(function () {
    return response()->view('pages.error-404', ['cmsPage' => 'error-404'], 404);
});

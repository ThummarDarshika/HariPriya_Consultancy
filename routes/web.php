<?php

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

Route::get('/faqs', function () {
    return view('pages.faqs');
})->name('faqs');

Route::get('/privacy-policy', function () {
    return view('pages.privacy-policy');
})->name('privacy-policy');

Route::get('/error-404', function () {
    return view('pages.error-404');
})->name('error-404');

Route::fallback(function () {
    return response()->view('pages.error-404', [], 404);
});

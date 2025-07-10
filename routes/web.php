<?php

// =========================
// Web Routes File
// This file defines all web routes for the Laravel application, including authentication, dashboard, and resource routes for various modules.
// Comments are provided throughout to explain the structure and logic for future developers.
// =========================

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\PopupController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCatalogController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\RecipeCategoryController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeDetailController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\WhyPazarController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\WorkAtPazarController;
use App\Http\Controllers\CareerInfoController;

// -------------------------
// Public Routes (Login)
// -------------------------
// Redirect root to login page
Route::get('/', function () {
    return redirect()->route('login');
});
// Show login form
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Handle login POST
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// -------------------------
// Group for all authenticated routes
// -------------------------
Route::middleware([\App\Http\Middleware\ApiAuthentication::class])->group(function () {

    // Logout, Profile, and Dashboard routes
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ---------------------------------------------------
    // GROUP 1: For Superadmin, Marketing, and Sales
    // ---------------------------------------------------
    Route::middleware('access:Marketing,Sales')->group(function () {
        // Resource routes for marketing/social modules
        Route::resource('headers', HeaderController::class);
        Route::resource('footers', FooterController::class);
        Route::resource('popups', PopupController::class);
        Route::resource('productcategories', ProductCategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('productcatalogs', ProductCatalogController::class);
        // Product Details routes
        Route::get('/products/{productId}/details/create', [ProductDetailController::class, 'create'])->name('productdetails.create');
        Route::post('/products/{productId}/details', [ProductDetailController::class, 'store'])->name('productdetails.store');
        Route::get('/products/{productId}/details/edit', [ProductDetailController::class, 'edit'])->name('productdetails.edit');
        Route::put('/products/{productDetailId}', [ProductDetailController::class, 'update'])->name('productdetails.update');
        Route::resource('certifications', CertificationController::class);
        Route::resource('recipecategories', RecipeCategoryController::class);
        Route::resource('recipes', RecipeController::class);
        // Recipe Category and Details routes
        Route::get('/recipes/category/{categoryId}', [RecipeController::class, 'getByCategory'])->name('recipes.by-category');
        Route::get('/recipes/{recipeId}/details/create', [RecipeDetailController::class, 'create'])->name('recipedetails.create');
        Route::post('/recipes/{recipeId}/details', [RecipeDetailController::class, 'store'])->name('recipedetails.store');
        Route::get('/recipes/{recipeDetailId}/edit', [RecipeDetailController::class, 'edit'])->name('recipedetails.edit');
        Route::put('/recipedetails/{id}', [RecipeDetailController::class, 'update'])->name('recipedetails.update');
        Route::delete('/recipes/{recipeId}/details/{id}', [RecipeDetailController::class, 'destroy'])->name('recipedetails.destroy');
        Route::resource('histories', HistoryController::class);
        Route::resource('companyprofiles', CompanyProfileController::class);
        // Company Profile by type
        Route::get('/companyprofiles/type/{type}', [CompanyProfileController::class, 'showByType'])->name('companyprofiles.by-type');
        Route::resource('whypazars', WhyPazarController::class);
        Route::resource('testimonials', TestimonialController::class);
        // Testimonial by type
        Route::get('/testimonials/type/{type}', [TestimonialController::class, 'showByType'])->name('testimonials.by-type');
    });

    // ---------------------------------------------
    // GROUP 2: For Superadmin and Human Resources
    // ---------------------------------------------
    Route::middleware('access:Human Resources')->group(function () {
        // Resource routes for HR modules
        Route::resource('departments', DepartmentController::class);
        Route::resource('experiences', ExperienceController::class);
        Route::resource('vacancies', VacancyController::class);
        Route::resource('workatpazars', WorkAtPazarController::class);
        // Work At Pazar by type
        Route::get('/workatpazar/type/{type}', [WorkAtPazarController::class, 'showByType'])->name('workatpazars.by-type');
        Route::resource('careerinfos', CareerInfoController::class);
    });
});
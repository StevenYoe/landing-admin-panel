<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmploymentController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\PopupController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCatalogController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeCategoryController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeDetailController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\WhyPazarController;
use App\Http\Controllers\CareerInfoController;
use App\Http\Controllers\WorkAtPazarController;

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

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::middleware([\App\Http\Middleware\ApiAuthentication::class])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    
    // Pazar Website Management Routes
    // Headers
    Route::resource('headers', HeaderController::class);
    
    // Footers
    Route::resource('footers', FooterController::class);
    
    // Popups
    Route::resource('popups', PopupController::class);
    
    // Product Categories
    Route::resource('productcategories', ProductCategoryController::class);
    
    // Products
    Route::resource('products', ProductController::class);

    // Product Catalogs
    Route::resource('productcatalogs', ProductCatalogController::class);
    
    // Product Details - Custom routes for product details
    Route::get('/products/{productId}/details/create', [ProductDetailController::class, 'create'])->name('productdetails.create');
    Route::post('/products/{productId}/details', [ProductDetailController::class, 'store'])->name('productdetails.store');
    Route::get('/products/{productId}/details/edit', [ProductDetailController::class, 'edit'])->name('productdetails.edit');
    Route::put('/products/{productId}/details', [ProductDetailController::class, 'update'])->name('productdetails.update');
    
    // Certifications
    Route::resource('certifications', CertificationController::class);

    // Recipe Categories
    Route::resource('recipecategories', RecipeCategoryController::class);
    
    // Recipes
    Route::resource('recipes', RecipeController::class);
    Route::get('/recipes/category/{categoryId}', [RecipeController::class, 'getByCategory'])->name('recipes.by-category');
    
    // Recipe Details - Custom routes for recipe details
    Route::get('/recipes/{recipeId}/details/create', [RecipeDetailController::class, 'create'])->name('recipedetails.create');
    Route::post('/recipes/{recipeId}/details', [RecipeDetailController::class, 'store'])->name('recipedetails.store');
    Route::get('/recipes/{recipeId}/details/edit', [RecipeDetailController::class, 'edit'])->name('recipedetails.edit');
    Route::put('/recipes/{recipeId}/details', [RecipeDetailController::class, 'update'])->name('recipedetails.update');
    Route::delete('/recipes/{recipeId}/details/{id}', [RecipeDetailController::class, 'destroy'])->name('recipedetails.destroy');
    
    // History
    Route::resource('histories', HistoryController::class);
    
    // Company Profile
    Route::resource('companyprofiles', CompanyProfileController::class);
    Route::get('/companyprofiles/type/{type}', [CompanyProfileController::class, 'showByType'])->name('companyprofiles.by-type');
    
    // Why Pazar
    Route::resource('whypazars', WhyPazarController::class);
    
    // Testimonials
    Route::resource('testimonials', TestimonialController::class);
    Route::get('/testimonials/type/{type}', [TestimonialController::class, 'showByType'])->name('testimonials.by-type');
    
    // HR Management Routes
    // Departments
    Route::resource('departments', DepartmentController::class);
    
    // Employment Types
    Route::resource('employments', EmploymentController::class);
    
    // Experience Levels
    Route::resource('experiences', ExperienceController::class);
    
    // Vacancies
    Route::resource('vacancies', VacancyController::class);
    
    // Work At Pazars
    Route::resource('workatpazars', WorkAtPazarController::class);
    Route::get('/workatpazar/type/{type}', [WorkAtPazarController::class, 'showByType'])->name('workatpazars.by-type');
    
    // Career Infos
    Route::resource('careerinfos', CareerInfoController::class);
});
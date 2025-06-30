@extends('layouts.app')
@section('title', 'Dashboard - Pazar Website Admin')
@section('page-title', 'Dashboard')

@section('content')
    @php
        // Get user roles from the session and convert to lowercase.
        $userRoles = array_map('strtolower', (array)Session::get('roles', []));

        // Define flags for easier checking.
        $isSuperAdmin = in_array('superadmin', $userRoles);
        $isMarketing = in_array('marketing', $userRoles) || in_array('social media', $userRoles);
        $isHR = in_array('human resources', $userRoles);
    @endphp

    @if($isSuperAdmin || $isMarketing)
        <!-- First Cards Row -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
            <!-- Card 1: Total Certifications -->
            <x-card class="border-l-4 border-emerald-400">
                <div class="flex items-center">
                    <div class="p-3 mr-4 rounded-full bg-emerald-400 bg-opacity-10">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Certifications</p>
                        <p class="text-lg font-semibold">{{ $certificationCount ?? 0 }}</p>
                    </div>
                </div>
            </x-card>

            <!-- Card 2: Total Histories -->
            <x-card class="border-l-4 border-sky-400">
                <div class="flex items-center">
                    <div class="p-3 mr-4 rounded-full bg-sky-400 bg-opacity-10">
                        <svg class="w-6 h-6 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Histories</p>
                        <p class="text-lg font-semibold">{{ $historyCount ?? 0 }}</p>
                    </div>
                </div>
            </x-card>

            <!-- Card 3: Total Why Pazars -->
            <x-card class="border-l-4 border-amber-400">
                <div class="flex items-center">
                    <div class="p-3 mr-4 rounded-full bg-amber-400 bg-opacity-10">
                        <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Why Pazars</p>
                        <p class="text-lg font-semibold">{{ $whyPazarCount ?? 0 }}</p>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Product Cards Row (Show only for non-HR divisions) -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4 mt-6">
            <!-- Card 1: Total Products -->
            <x-card class="border-l-4 border-purple-400">
                <div class="flex items-center">
                    <div class="p-3 mr-4 rounded-full bg-purple-400 bg-opacity-10">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Products</p>
                        <p class="text-lg font-semibold">{{ $productCount ?? 0 }}</p>
                    </div>
                </div>
            </x-card>

            <!-- Card 2: Active Products -->
            <x-card class="border-l-4 border-blue-400">
                <div class="flex items-center">
                    <div class="p-3 mr-4 rounded-full bg-blue-400 bg-opacity-10">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Products</p>
                        <p class="text-lg font-semibold">{{ $activeProductCount ?? 0 }}</p>
                    </div>
                </div>
            </x-card>

            <!-- Card 3: Product Categories -->
            <x-card class="border-l-4 border-teal-400">
                <div class="flex items-center">
                    <div class="p-3 mr-4 rounded-full bg-teal-400 bg-opacity-10">
                        <svg class="w-6 h-6 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Product Categories</p>
                        <p class="text-lg font-semibold">{{ $categoryCount ?? 0 }}</p>
                    </div>
                </div>
            </x-card>

            <!-- Card 4: New Products This Month -->
            <x-card class="border-l-4 border-rose-400">
                <div class="flex items-center">
                    <div class="p-3 mr-4 rounded-full bg-rose-400 bg-opacity-10">
                        <svg class="w-6 h-6 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">New Products This Month</p>
                        <p class="text-lg font-semibold">{{ $newProductsThisMonth ?? 0 }}</p>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Recipe Cards Row (Show only for non-HR divisions) -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4 mt-6">
            <!-- Card 1: Total Recipes -->
            <x-card class="border-l-4 border-yellow-400">
                <div class="flex items-center">
                    <div class="p-3 mr-4 rounded-full bg-yellow-400 bg-opacity-10">
                        <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Recipes</p>
                        <p class="text-lg font-semibold">{{ $recipeCount ?? 0 }}</p>
                    </div>
                </div>
            </x-card>

            <!-- Card 2: Active Recipes -->
            <x-card class="border-l-4 border-cyan-400">
                <div class="flex items-center">
                    <div class="p-3 mr-4 rounded-full bg-cyan-400 bg-opacity-10">
                        <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Recipes</p>
                        <p class="text-lg font-semibold">{{ $activeRecipeCount ?? 0 }}</p>
                    </div>
                </div>
            </x-card>

            <!-- Card 3: Recipe Categories -->
            <x-card class="border-l-4 border-lime-400">
                <div class="flex items-center">
                    <div class="p-3 mr-4 rounded-full bg-lime-400 bg-opacity-10">
                        <svg class="w-6 h-6 text-lime-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Recipe Categories</p>
                        <p class="text-lg font-semibold">{{ $recipeCategoryCount ?? 0 }}</p>
                    </div>
                </div>
            </x-card>

            <!-- Card 4: New Recipes This Month -->
            <x-card class="border-l-4 border-fuchsia-400">
                <div class="flex items-center">
                    <div class="p-3 mr-4 rounded-full bg-fuchsia-400 bg-opacity-10">
                        <svg class="w-6 h-6 text-fuchsia-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">New Recipes This Month</p>
                        <p class="text-lg font-semibold">{{ $newRecipesThisMonth ?? 0 }}</p>
                    </div>
                </div>
            </x-card>
        </div>
    @endif

    {{-- Divider for Superadmin View --}}
    @if($isSuperAdmin)
        <hr class="my-8 border-gray-300">
    @endif

    @if($isSuperAdmin || $isHR)
        <!-- Vacancy Cards Row -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4 mt-6">
            <!-- Card 1: Total Vacancies -->
            <x-card class="border-l-4 border-indigo-400">
                <div class="flex items-center">
                    <div class="p-3 mr-4 rounded-full bg-indigo-400 bg-opacity-10">
                        <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Vacancies</p>
                        <p class="text-lg font-semibold">{{ $totalVacancies ?? 0 }}</p>
                    </div>
                </div>
            </x-card>

            <!-- Card 2: Active Vacancies -->
            <x-card class="border-l-4 border-green-400">
                <div class="flex items-center">
                    <div class="p-3 mr-4 rounded-full bg-green-400 bg-opacity-10">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Vacancies</p>
                        <p class="text-lg font-semibold">{{ $activeVacancies ?? 0 }}</p>
                    </div>
                </div>
            </x-card>

            <!-- Card 3: Urgent Vacancies -->
            <x-card class="border-l-4 border-red-400">
                <div class="flex items-center">
                    <div class="p-3 mr-4 rounded-full bg-red-400 bg-opacity-10">
                        <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Urgent Vacancies</p>
                        <p class="text-lg font-semibold">{{ $urgentVacancies ?? 0 }}</p>
                    </div>
                </div>
            </x-card>
            
            <!-- Card 4: New Vacancies This Month -->
            <x-card class="border-l-4 border-violet-400">
                <div class="flex items-center">
                    <div class="p-3 mr-4 rounded-full bg-violet-400 bg-opacity-10">
                        <svg class="w-6 h-6 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">New Vacancies This Month</p>
                        <p class="text-lg font-semibold">{{ $newVacanciesThisMonth ?? 0 }}</p>
                    </div>
                </div>
            </x-card>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3 mt-6">
            <!-- Card 5: Total Departments -->
            <x-card class="border-l-4 border-orange-400">
                <div class="flex items-center">
                    <div class="p-3 mr-4 rounded-full bg-orange-400 bg-opacity-10">
                        <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Departments</p>
                        <p class="text-lg font-semibold">{{ $totalDepartments ?? 0 }}</p>
                    </div>
                </div>
            </x-card>

            <!-- Card 6: Total Employments -->
            <x-card class="border-l-4 border-pink-400">
                <div class="flex items-center">
                    <div class="p-3 mr-4 rounded-full bg-pink-400 bg-opacity-10">
                        <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Employments</p>
                        <p class="text-lg font-semibold">{{ $totalEmployments ?? 0 }}</p>
                    </div>
                </div>
            </x-card>

            <!-- Card 7: Total Experiences -->
            <x-card class="border-l-4 border-slate-400">
                <div class="flex items-center">
                    <div class="p-3 mr-4 rounded-full bg-slate-400 bg-opacity-10">
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Experiences</p>
                        <p class="text-lg font-semibold">{{ $totalExperiences ?? 0 }}</p>
                    </div>
                </div>
            </x-card>
        </div>
    @endif

    @if($isSuperAdmin || $isMarketing)
        <!-- Table Section -->
        <div class="grid grid-cols-1 gap-6 mt-6 lg:grid-cols-2">
            <!-- Table 1: Latest Products -->
            <x-card>
                <h2 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-300">Latest Products</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">Product Name</th>
                                <th scope="col" class="px-6 py-3 text-center">Category</th>
                                <th scope="col" class="px-6 py-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestProducts ?? [] as $product)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-5 py-4 text-center">{{ $product['p_title_en'] ?? $product['p_title_id'] ?? 'N/A' }}</td>
                                <td class="px-5 py-4 text-center">{{ $product['category_name'] ?? 'N/A' }}</td>
                                <td class="px-5 py-4 text-center">
                                    @if(isset($product['p_is_active']) && $product['p_is_active'])
                                        <span class="px-2 py-1 text-xs font-semibold text-green-300 bg-green-900 rounded-full">Active</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold text-red-300 bg-red-900 rounded-full">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="3" class="px-5 py-4 text-center">No products available</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
            
            <!-- Table 2: Products by Category -->
            <x-card>
                <h2 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-300">Total Products Per Category</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">Category</th>
                                <th scope="col" class="px-6 py-3 text-center">Total Product</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productsByCategory ?? [] as $category)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-5 py-4 text-center">{{ $category['pc_title_id'] ?? 'N/A' }}</td>
                                <td class="px-5 py-4 text-center">{{ $category['product_count'] ?? 0 }}</td>
                            </tr>
                            @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="2" class="px-5 py-4 text-center">No data available</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>

            <!-- Table 3: Latest Recipes -->
            <x-card>
                <h2 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-300">Latest Recipes</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">Recipe Name</th>
                                <th scope="col" class="px-6 py-3 text-center">Category</th>
                                <th scope="col" class="px-6 py-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestRecipes ?? [] as $recipe)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-5 py-4 text-center">{{ $recipe['r_title_en'] ?? $recipe['r_title_id'] ?? 'N/A' }}</td>
                                <td class="px-5 py-4 text-center">
                                    @if(isset($recipe['category_names']) && count($recipe['category_names']) > 0)
                                        @foreach($recipe['category_names'] as $index => $category)
                                            {{ $category }}@if($index < count($recipe['category_names']) - 1), @endif
                                        @endforeach
                                    @else
                                        {{ $recipe['category_name'] ?? 'N/A' }}
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-center">
                                    @if(isset($recipe['r_is_active']) && $recipe['r_is_active'])
                                        <span class="px-2 py-1 text-xs font-semibold text-green-300 bg-green-900 rounded-full">Active</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold text-red-300 bg-red-900 rounded-full">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="3" class="px-5 py-4 text-center">No recipes available</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
            
            <!-- Table 4: Recipes by Category -->
            <x-card>
                <h2 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-300">Total Recipes Per Category</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">Category</th>
                                <th scope="col" class="px-6 py-3 text-center">Total Recipes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recipesByCategory ?? [] as $category)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-5 py-4 text-center">{{ $category['rc_title_id'] ?? 'N/A' }}</td>
                                <td class="px-5 py-4 text-center">{{ $category['recipe_count'] ?? 0 }}</td>
                            </tr>
                            @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="2" class="px-5 py-4 text-center">No data available</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
        @endif

        {{-- Divider for Superadmin View --}}
        @if($isSuperAdmin)
            <hr class="my-8 border-gray-300">
        @endif

        @if($isSuperAdmin || $isHR)
        <div class="grid grid-cols-1 gap-6 mt-6 lg:grid-cols-2">
            <!-- Latest Vacancies Table -->
            <x-card>
                <h2 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-300">Latest Vacancies</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">Vacancy Name</th>
                                <th scope="col" class="px-6 py-3 text-center">Department</th>
                                <th scope="col" class="px-6 py-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestVacancies ?? [] as $vacancy)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-5 py-4 text-center">{{ $vacancy['v_title_en'] ?? 'N/A' }}</td>
                                <td class="px-5 py-4 text-center">{{ $vacancy['department_name'] ?? 'N/A' }}</td>
                                <td class="px-5 py-4 text-center">
                                    @if($vacancy['v_is_active'] ?? false)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            Inactive
                                        </span>
                                    @endif
                                    @if($vacancy['v_urgent'] ?? false)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 ml-1">
                                            Urgent
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="3" class="px-5 py-4 text-center">No data available</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>

            <!-- Vacancies Per Department Table -->
            <x-card>
                <h2 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-300">Vacancies Per Department</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">Department</th>
                                <th scope="col" class="px-6 py-3 text-center">Total Vacancies</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vacanciesByDepartment ?? [] as $dept)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-5 py-4 text-center">{{ $dept['da_title_en'] ?? 'N/A' }}</td>
                                <td class="px-5 py-4 text-center">{{ $dept['vacancy_count'] ?? 0 }}</td>
                            </tr>
                            @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="2" class="px-5 py-4 text-center">No data available</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    @endif
@endsection
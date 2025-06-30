<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    public function index()
    {
        // Use CRUD API to get dashboard statistics
        $response = $this->crudApiGet('/dashboard/statistics');
        
        // Check if response was successful
        if (!isset($response['success']) || !$response['success']) {
            return view('dashboard')->with('error', $response['message'] ?? 'Failed to load dashboard data');
        }
        
        // Extract base data from response
        $data = [
            'productCount' => $response['data']['total_products'] ?? 0,
            'categoryCount' => $response['data']['total_categories'] ?? 0,
            'certificationCount' => $response['data']['total_certifications'] ?? 0,
            'historyCount' => $response['data']['total_histories'] ?? 0,
            'whyPazarCount' => $response['data']['total_whyPazars'] ?? 0,
            'activeProductCount' => $response['data']['active_products'] ?? 0,
            'newProductsThisMonth' => $response['data']['new_products_this_month'] ?? 0,
            'latestProducts' => $response['data']['recent_products'] ?? [],
            'productsByCategory' => $response['data']['products_by_category'] ?? [],
            
            // Recipe statistics
            'recipeCount' => $response['data']['total_recipes'] ?? 0,
            'recipeCategoryCount' => $response['data']['total_recipe_categories'] ?? 0,
            'activeRecipeCount' => $response['data']['active_recipes'] ?? 0,
            'newRecipesThisMonth' => $response['data']['new_recipes_this_month'] ?? 0,
            'latestRecipes' => $response['data']['latest_recipes'] ?? [],
            'recipesByCategory' => $response['data']['recipes_by_category'] ?? []
        ];

        // Get vacancy statistics
        $vacancyResponse = $this->crudApiGet('/vacancies/statistics');
        
        if (isset($vacancyResponse['success']) && $vacancyResponse['success']) {
            $data['totalVacancies'] = $vacancyResponse['data']['total_vacancies'] ?? 0;
            $data['activeVacancies'] = $vacancyResponse['data']['active_vacancies'] ?? 0;
            $data['urgentVacancies'] = $vacancyResponse['data']['urgent_vacancies'] ?? 0;
            $data['totalDepartments'] = $vacancyResponse['data']['total_departments'] ?? 0;
            $data['totalEmployments'] = $vacancyResponse['data']['total_employments'] ?? 0;
            $data['totalExperiences'] = $vacancyResponse['data']['total_experiences'] ?? 0;
            $data['latestVacancies'] = $vacancyResponse['data']['latest_vacancies'] ?? [];
            $data['vacanciesByDepartment'] = $vacancyResponse['data']['vacancies_by_department'] ?? [];
        }

        $data['isSuperAdmin'] = $this->isSuperAdmin();
        
        return view('dashboard', $data);
    }
}
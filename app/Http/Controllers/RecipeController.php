<?php
// RecipeController manages CRUD operations for recipes.
// It handles listing, creating, updating, showing, and deleting recipe records via the CRUD API.
// Also manages file uploads for recipe images, category filtering, and transforms image paths to full URLs for display.
// Includes logic for fetching recipes by category and handling related recipe details.

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipeController extends BaseController
{
    /**
     * Display a listing of the recipes.
     * Handles sorting, pagination, category filtering, and image path transformation.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $params = [
            'sort_by' => $request->input('sort_by', 'r_id'),
            'sort_order' => $request->input('sort_order', 'asc'),
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page', 1),
            'category_id' => $request->input('category_id')
        ];

        // Get categories for filter dropdown
        $categoriesResponse = $this->crudApiGet('/recipecategories/all');
        $categories = [];

        if (isset($categoriesResponse['success']) && $categoriesResponse['success'] && isset($categoriesResponse['data'])) {
            $categories = $categoriesResponse['data'];
        }

        // Use CRUD API to get recipes data
        $response = $this->crudApiGet('/recipes', $params);
    
        if (!isset($response['success']) || !$response['success']) {
            return view('recipes.index', compact('categories'))
                ->with('error', $response['message'] ?? 'Failed to fetch recipes');
        }
        
        $recipes = $response['data']['data'] ?? [];
        
        // Transform image paths
        foreach ($recipes as &$recipe) {
            if (!empty($recipe['r_image'])) {
                $recipe['r_image'] = config('app.crud_storage_url') . '/' . $recipe['r_image'];
            }
        }
        
        // Create a proper paginator instance
        $paginator = null;
        if (isset($response['data'])) {
            $paginationData = $response['data'];
            if (isset($paginationData['current_page']) && isset($paginationData['per_page']) && isset($paginationData['total'])) {
                $paginator = new LengthAwarePaginator(
                    $recipes,
                    $paginationData['total'],
                    $paginationData['per_page'],
                    $paginationData['current_page'],
                    [
                        'path' => request()->url(),
                        'query' => $request->query()
                    ]
                );
            }
        }

        $sortBy = $params['sort_by'];
        $sortOrder = $params['sort_order'];
        $categoryId = $params['category_id'];
        
        return view('recipes.index', compact('recipes', 'categories', 'paginator', 'sortBy', 'sortOrder', 'categoryId'));
    }

    /**
     * Show the form for creating a new recipe.
     * Fetches categories for the dropdown.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Get categories for dropdown
        $categoriesResponse = $this->crudApiGet('/recipecategories/all');
        $categories = [];
        
        if (isset($categoriesResponse['success']) && $categoriesResponse['success'] && isset($categoriesResponse['data'])) {
            $categories = $categoriesResponse['data'];
        }
        
        return view('recipes.create', compact('categories'));
    }

    /**
     * Store a newly created recipe in storage.
     * Validates input, handles file upload, and sends data to the CRUD API.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'r_title_id' => 'required|string|max:255',
            'r_title_en' => 'required|string|max:255',
            'r_is_active' => 'nullable|boolean',
            'r_image' => 'nullable|image|max:5120',
            'category_ids' => 'required|array',
            'category_ids.*' => 'required|integer',
        ]);
        
        $data = $request->all();
        
        // Handle file upload
        if ($request->hasFile('r_image')) {
            $data['r_image'] = $request->file('r_image');
        }
        
        // Use CRUD API to store recipe data
        $response = $this->crudApiPost('/recipes', $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to create recipe');
        }
        
        return redirect()->route('recipes.index')
            ->with('success', $response['message'] ?? 'Recipe created successfully');
    }

    /**
     * Display the specified recipe.
     * Fetches a single recipe record, transforms its image path, and fetches recipe details.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $response = $this->crudApiGet("/recipes/{$id}");
    
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('recipes.index')
                ->with('error', $response['message'] ?? 'Recipe not found');
        }
        
        $recipe = $response['data'];
        
        // Transform image path
        if (!empty($recipe['r_image'])) {
            $recipe['r_image'] = config('app.crud_storage_url') . '/' . $recipe['r_image'];
        }
        
        // Get recipe detail information
        $detailResponse = $this->crudApiGet("/recipedetails/by-recipe/{$id}");
        $recipeDetail = null;
        
        if (isset($detailResponse['success']) && $detailResponse['success'] && isset($detailResponse['data'])) {
            $recipeDetail = $detailResponse['data'];
        }
        
        return view('recipes.show', compact('recipe', 'recipeDetail'));
    }

    /**
     * Show the form for editing the specified recipe.
     * Fetches the record and categories for editing, transforms image path, and extracts selected categories.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Get categories for dropdown
        $categoriesResponse = $this->crudApiGet('/recipecategories/all');
        $categories = [];
        if (isset($categoriesResponse['success']) && $categoriesResponse['success']) {
            $categories = $categoriesResponse['data'];
        }
        
        $response = $this->crudApiGet("/recipes/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('recipes.index')
                ->with('error', $response['message'] ?? 'Recipe not found');
        }
        
        $recipe = $response['data'];
    
        // Transform image path to full URL if it exists
        if (!empty($recipe['r_image'])) {
            $recipe['r_image'] = config('app.crud_storage_url') . '/' . $recipe['r_image'];
        }
        
        // Extract category IDs for the form
        $selectedCategories = [];
        if (isset($recipe['categories']) && is_array($recipe['categories'])) {
            foreach ($recipe['categories'] as $category) {
                $selectedCategories[] = $category['rc_id'];
            }
        }
        
        return view('recipes.edit', compact('recipe', 'categories', 'selectedCategories'));
    }

    /**
     * Update the specified recipe in storage.
     * Validates input, handles file upload, and updates the record via the CRUD API.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'r_title_id' => 'required|string|max:255',
            'r_title_en' => 'required|string|max:255',
            'r_is_active' => 'nullable|boolean',
            'r_image' => 'nullable|image|max:5120',
            'category_ids' => 'required|array',
            'category_ids.*' => 'required|integer',
        ]);
        
        $data = $request->all();
        
        // Handle file upload if needed
        if ($request->hasFile('r_image')) {
            $data['r_image'] = $request->file('r_image');
        }
        
        // Use CRUD API to update recipe data
        $response = $this->crudApiPut("/recipes/{$id}", $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to update recipe');
        }
        
        return redirect()->route('recipes.index')
            ->with('success', $response['message'] ?? 'Recipe updated successfully');
    }

    /**
     * Remove the specified recipe from storage.
     * Deletes the record via the CRUD API and handles the response.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $response = $this->crudApiDelete("/recipes/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('recipes.index')
                ->with('error', $response['message'] ?? 'Failed to delete recipe');
        }
        
        return redirect()->route('recipes.index')
            ->with('success', $response['message'] ?? 'Recipe deleted successfully');
    }
    
    /**
     * Get recipes by category.
     * Fetches recipes for a specific category and transforms image paths.
     *
     * @param  int  $categoryId
     * @return \Illuminate\View\View
     */
    public function getByCategory($categoryId)
    {
        // Get category information
        $categoryResponse = $this->crudApiGet("/recipecategories/{$categoryId}");
        
        if (!isset($categoryResponse['success']) || !$categoryResponse['success']) {
            return redirect()->route('recipes.index')
                ->with('error', $categoryResponse['message'] ?? 'Recipe category not found');
        }
        
        $category = $categoryResponse['data'];
        
        // Get recipes for this category
        $response = $this->crudApiGet("/recipes/by-category/{$categoryId}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('recipes.index')
                ->with('error', $response['message'] ?? 'Failed to fetch recipes');
        }
        
        $recipes = $response['data'];
        
        // Transform image paths
        foreach ($recipes as &$recipe) {
            if (!empty($recipe['r_image'])) {
                $recipe['r_image'] = config('app.crud_storage_url') . '/' . $recipe['r_image'];
            }
        }
        
        return view('recipes.by-category', compact('recipes', 'category'));
    }
}
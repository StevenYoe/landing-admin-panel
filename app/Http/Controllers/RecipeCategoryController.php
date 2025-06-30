<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipeCategoryController extends BaseController
{
    /**
     * Display a listing of the recipe categories.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $params = [
            'sort_by' => $request->input('sort_by', 'rc_id'),
            'sort_order' => $request->input('sort_order', 'asc'),
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page', 1)
        ];

        // Use CRUD API to get recipe categories data with error logging
        try {
            $response = $this->crudApiGet('/recipecategories', $params);
            
            if (!isset($response['success']) || !$response['success']) {
                return view('recipecategories.index')
                    ->with('error', $response['message'] ?? 'Failed to fetch recipe categories');
            }
            
            $categories = $response['data']['data'] ?? [];
            
            // Create a proper paginator instance
            $paginator = null;
            if (isset($response['data'])) {
                $paginationData = $response['data'];
                if (isset($paginationData['current_page']) && isset($paginationData['per_page']) && isset($paginationData['total'])) {
                    $paginator = new LengthAwarePaginator(
                        $categories,
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
            
            return view('recipecategories.index', compact('categories', 'paginator', 'sortBy', 'sortOrder'));
        } catch (\Exception $e) {
            return view('recipecategories.index')
                ->with('error', 'An error occurred while fetching recipe categories');
        }
    }

    /**
     * Show the form for creating a new recipe category.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('recipecategories.create');
    }

    /**
     * Store a newly created recipe category in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rc_title_id' => 'required|string|max:255',
            'rc_title_en' => 'required|string|max:255',
        ]);
        
        $data = $request->all();
        
        // Use CRUD API to store recipe category data
        $response = $this->crudApiPost('/recipecategories', $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to create recipe category');
        }
        
        return redirect()->route('recipecategories.index')
            ->with('success', $response['message'] ?? 'Recipe category created successfully');
    }

    /**
     * Display the specified recipe category.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $response = $this->crudApiGet("/recipecategories/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('recipecategories.index')
                ->with('error', $response['message'] ?? 'Recipe category not found');
        }
        
        $category = $response['data'];
        
        // Get recipes related to this category
        $recipesResponse = $this->crudApiGet("/recipes/by-category/{$id}");
        $recipes = [];
        
        if (isset($recipesResponse['success']) && $recipesResponse['success'] && isset($recipesResponse['data'])) {
            $recipes = $recipesResponse['data'];
            
            // Transform image paths
            foreach ($recipes as &$recipe) {
                if (!empty($recipe['r_image'])) {
                    $recipe['r_image'] = config('app.crud_storage_url') . '/' . $recipe['r_image'];
                }
            }
        }
        
        return view('recipecategories.show', compact('category', 'recipes'));
    }

    /**
     * Show the form for editing the specified recipe category.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $response = $this->crudApiGet("/recipecategories/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('recipecategories.index')
                ->with('error', $response['message'] ?? 'Recipe category not found');
        }
        
        $category = $response['data'];
        
        return view('recipecategories.edit', compact('category'));
    }

    /**
     * Update the specified recipe category in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'rc_title_id' => 'required|string|max:255',
            'rc_title_en' => 'required|string|max:255',
        ]);
        
        $data = $request->all();
        
        // Use CRUD API to update recipe category data
        $response = $this->crudApiPut("/recipecategories/{$id}", $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to update recipe category');
        }
        
        return redirect()->route('recipecategories.index')
            ->with('success', $response['message'] ?? 'Recipe category updated successfully');
    }

    /**
     * Remove the specified recipe category from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $response = $this->crudApiDelete("/recipecategories/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('recipecategories.index')
                ->with('error', $response['message'] ?? 'Failed to delete recipe category');
        }
        
        return redirect()->route('recipecategories.index')
            ->with('success', $response['message'] ?? 'Recipe category deleted successfully');
    }
}
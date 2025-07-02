<?php
// RecipeDetailController manages CRUD operations for recipe details.
// It handles creating, updating, editing, and deleting recipe detail records via the CRUD API.
// Also fetches recipe information for context and manages validation and error handling.

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RecipeDetailController extends BaseController
{
    /**
     * Show the form for creating a new recipe detail.
     * Fetches recipe information for context.
     *
     * @param  int  $recipeId
     * @return \Illuminate\View\View
     */
    public function create($recipeId)
    {
        // Get recipe information
        $recipeResponse = $this->crudApiGet("/recipes/{$recipeId}");
        
        if (!isset($recipeResponse['success']) || !$recipeResponse['success']) {
            return redirect()->route('recipes.index')
                ->with('error', $recipeResponse['message'] ?? 'Recipe not found');
        }
        
        $recipe = $recipeResponse['data'];
        
        return view('recipedetails.create', compact('recipe'));
    }

    /**
     * Store a newly created recipe detail in storage.
     * Validates input, adds recipe ID, and sends data to the CRUD API.
     *
     * @param  Request  $request
     * @param  int  $recipeId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $recipeId)
    {
        $validated = $request->validate([
            'rd_desc_id' => 'nullable|string',
            'rd_desc_en' => 'nullable|string',
            'rd_ingredients_id' => 'nullable|string',
            'rd_ingredients_en' => 'nullable|string',
            'rd_cook_id' => 'nullable|string',
            'rd_cook_en' => 'nullable|string',
            'rd_link_youtube' => 'nullable|string|max:255',
        ]);
        
        // Add recipe ID to data
        $data = $request->all();
        $data['rd_id_recipe'] = $recipeId;
        
        // Use CRUD API to store recipe detail data
        $response = $this->crudApiPost('/recipedetails', $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to create recipe detail');
        }
        
        return redirect()->route('recipes.show', $recipeId)
            ->with('success', $response['message'] ?? 'Recipe detail created successfully');
    }

    /**
     * Show the form for editing the specified recipe detail.
     * Fetches recipe and recipe detail information for editing.
     *
     * @param  int  $recipeId
     * @return \Illuminate\View\View
     */
    public function edit($recipeId)
    {
        // Get recipe information
        $recipeResponse = $this->crudApiGet("/recipes/{$recipeId}");
        
        if (!isset($recipeResponse['success']) || !$recipeResponse['success']) {
            return redirect()->route('recipes.index')
                ->with('error', $recipeResponse['message'] ?? 'Recipe not found');
        }
        
        $recipe = $recipeResponse['data'];
        
        // Get recipe detail information
        $detailResponse = $this->crudApiGet("/recipedetails/by-recipe/{$recipeId}");
        
        if (!isset($detailResponse['success']) || !$detailResponse['success']) {
            return redirect()->route('recipes.show', $recipeId)
                ->with('error', $detailResponse['message'] ?? 'Recipe detail not found');
        }
        
        $recipeDetail = $detailResponse['data'];
        
        return view('recipedetails.edit', compact('recipe', 'recipeDetail'));
    }

    /**
     * Update the specified recipe detail in storage.
     * Validates input and updates the record via the CRUD API.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'rd_desc_id' => 'nullable|string',
            'rd_desc_en' => 'nullable|string',
            'rd_ingredients_id' => 'nullable|string',
            'rd_ingredients_en' => 'nullable|string',
            'rd_cook_id' => 'nullable|string',
            'rd_cook_en' => 'nullable|string',
            'rd_link_youtube' => 'nullable|string|max:255',
        ]);
        
        $data = $request->all();
        
        // Use CRUD API to update recipe detail data
        $response = $this->crudApiPut("/recipedetails/{$id}", $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to update recipe detail');
        }
        
        // Get recipe ID from response data to redirect properly
        $recipeId = $response['data']['rd_id_recipe'] ?? $request->input('rd_id_recipe');
        
        return redirect()->route('recipes.show', $recipeId)
            ->with('success', $response['message'] ?? 'Recipe detail updated successfully');
    }

    /**
     * Remove the specified recipe detail from storage.
     * Deletes the record via the CRUD API and handles the response.
     *
     * @param  int  $id
     * @param  int  $recipeId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, $recipeId)
    {
        $response = $this->crudApiDelete("/recipedetails/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('recipes.show', $recipeId)
                ->with('error', $response['message'] ?? 'Failed to delete recipe detail');
        }
        
        return redirect()->route('recipes.show', $recipeId)
            ->with('success', $response['message'] ?? 'Recipe detail deleted successfully');
    }
}
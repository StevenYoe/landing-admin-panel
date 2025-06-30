<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;

class WorkAtPazarController extends BaseController
{
    /**
     * Display a listing of the work at pazar items.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $params = [
            'sort_by' => $request->input('sort_by', 'wap_id'),
            'sort_order' => $request->input('sort_order', 'asc'),
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page', 1)
        ];

        // Use CRUD API to get work at pazar data
        $response = $this->crudApiGet('/workatpazars', $params);
        
        if (!isset($response['success']) || !$response['success']) {
            return view('workatpazars.index')->with('error', $response['message'] ?? 'Failed to fetch work at pazar items');
        }
        
        $workAtPazars = $response['data']['data'] ?? [];
        
        // Create a proper paginator instance
        $paginator = null;
        if (isset($response['data'])) {
            $paginationData = $response['data'];
            if (isset($paginationData['current_page']) && isset($paginationData['per_page']) && isset($paginationData['total'])) {
                $paginator = new LengthAwarePaginator(
                    $workAtPazars,
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
        
        return view('workatpazars.index', compact('workAtPazars', 'paginator', 'sortBy', 'sortOrder'));
    }

    /**
     * Show the form for creating a new work at pazar item.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('workatpazars.create');
    }

    /**
     * Store a newly created work at pazar item in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'wap_title_id' => 'required|string|max:255',
            'wap_title_en' => 'required|string|max:255',
            'wap_description_id' => 'nullable|string',
            'wap_description_en' => 'nullable|string',
            'wap_type' => 'required|string',
        ]);
        
        $data = $request->except(['_token', '_method']);
        
        // Use CRUD API to store work at pazar data
        $response = $this->crudApiPost('/workatpazars', $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to create work at pazar item');
        }
        
        return redirect()->route('workatpazars.index')
            ->with('success', $response['message'] ?? 'Work at pazar item created successfully');
    }

    /**
     * Display the specified work at pazar item.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $response = $this->crudApiGet("/workatpazars/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('workatpazars.index')
                ->with('error', $response['message'] ?? 'Work at pazar item not found');
        }
        
        $workAtPazar = $response['data'];
        
        return view('workatpazars.show', compact('workAtPazar'));
    }

    /**
     * Show the form for editing the specified work at pazar item.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $response = $this->crudApiGet("/workatpazars/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('workatpazars.index')
                ->with('error', $response['message'] ?? 'Work at pazar item not found');
        }
        
        $workAtPazar = $response['data'];
        
        return view('workatpazars.edit', compact('workAtPazar'));
    }

    /**
     * Update the specified work at pazar item in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'wap_title_id' => 'required|string|max:255',
            'wap_title_en' => 'required|string|max:255',
            'wap_description_id' => 'nullable|string',
            'wap_description_en' => 'nullable|string',
            'wap_type' => 'required|string',
        ]);
        
        $data = $request->except(['_token', '_method']);
        
        // Use CRUD API to update work at pazar data
        $response = $this->crudApiPut("/workatpazars/{$id}", $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to update work at pazar item');
        }
        
        return redirect()->route('workatpazars.index')
            ->with('success', $response['message'] ?? 'Work at pazar item updated successfully');
    }

    /**
     * Remove the specified work at pazar item from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $response = $this->crudApiDelete("/workatpazars/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('workatpazars.index')
                ->with('error', $response['message'] ?? 'Failed to delete work at pazar item');
        }
        
        return redirect()->route('workatpazars.index')
            ->with('success', $response['message'] ?? 'Work at pazar item deleted successfully');
    }
    
    /**
     * Show work at pazar items based on type.
     *
     * @param string $type
     * @return \Illuminate\View\View
     */
    public function showByType($type)
    {
        $response = $this->crudApiGet("/workatpazars/type/{$type}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('workatpazars.index')
                ->with('error', $response['message'] ?? 'Work at pazar items not found');
        }
        
        $workAtPazars = $response['data'];
        
        return view('workatpazars.show-by-type', compact('workAtPazars', 'type'));
    }
}
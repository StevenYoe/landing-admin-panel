<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;

class CareerInfoController extends BaseController
{
    /**
     * Display a listing of the career info items.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $params = [
            'sort_by' => $request->input('sort_by', 'ci_id'),
            'sort_order' => $request->input('sort_order', 'asc'),
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page', 1)
        ];

        // Use CRUD API to get career info data
        $response = $this->crudApiGet('/careerinfos', $params);
        
        if (!isset($response['success']) || !$response['success']) {
            return view('careerinfos.index')->with('error', $response['message'] ?? 'Failed to fetch career info items');
        }
        
        $careerInfos = $response['data']['data'] ?? [];
        
        // Transform image paths
        foreach ($careerInfos as &$careerInfo) {
            if (!empty($careerInfo['ci_image'])) {
                $careerInfo['ci_image'] = config('app.crud_storage_url') . '/' . $careerInfo['ci_image'];
            }
        }
        
        // Create a proper paginator instance
        $paginator = null;
        if (isset($response['data'])) {
            $paginationData = $response['data'];
            if (isset($paginationData['current_page']) && isset($paginationData['per_page']) && isset($paginationData['total'])) {
                $paginator = new LengthAwarePaginator(
                    $careerInfos,
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
        
        return view('careerinfos.index', compact('careerInfos', 'paginator', 'sortBy', 'sortOrder'));
    }

    /**
     * Show the form for creating a new career info item.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('careerinfos.create');
    }

    /**
     * Store a newly created career info item in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ci_title_id' => 'required|string|max:255',
            'ci_title_en' => 'required|string|max:255',
            'ci_description_id' => 'required|string',
            'ci_description_en' => 'required|string',
            'ci_image' => 'nullable|image|max:5120',
        ]);
        
        $data = $request->all();
        
        // Handle file upload if needed
        if ($request->hasFile('ci_image')) {
            $data['ci_image'] = $request->file('ci_image');
        }
        
        // Use CRUD API to store career info data
        $response = $this->crudApiPost('/careerinfos', $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to create career info item');
        }
        
        return redirect()->route('careerinfos.index')
            ->with('success', $response['message'] ?? 'Career info item created successfully');
    }

    /**
     * Display the specified career info item.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $response = $this->crudApiGet("/careerinfos/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('careerinfos.index')
                ->with('error', $response['message'] ?? 'Career info item not found');
        }
        
        $careerInfo = $response['data'];
        
        // Transform image path
        if (!empty($careerInfo['ci_image'])) {
            $careerInfo['ci_image'] = config('app.crud_storage_url') . '/' . $careerInfo['ci_image'];
        }
        
        return view('careerinfos.show', compact('careerInfo'));
    }

    /**
     * Show the form for editing the specified career info item.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $response = $this->crudApiGet("/careerinfos/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('careerinfos.index')
                ->with('error', $response['message'] ?? 'Career info item not found');
        }
        
        $careerInfo = $response['data'];
        
        // Transform image path to full URL if it exists
        if (!empty($careerInfo['ci_image'])) {
            $careerInfo['ci_image'] = config('app.crud_storage_url') . '/' . $careerInfo['ci_image'];
        }
        
        return view('careerinfos.edit', compact('careerInfo'));
    }

    /**
     * Update the specified career info item in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'ci_title_id' => 'required|string|max:255',
            'ci_title_en' => 'required|string|max:255',
            'ci_description_id' => 'required|string',
            'ci_description_en' => 'required|string',
            'ci_image' => 'nullable|image|max:5120',
        ]);
        
        $data = $request->all();
        
        // Handle file upload if needed
        if ($request->hasFile('ci_image')) {
            $data['ci_image'] = $request->file('ci_image');
        }
        
        // Use CRUD API to update career info data
        $response = $this->crudApiPut("/careerinfos/{$id}", $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to update career info item');
        }
        
        return redirect()->route('careerinfos.index')
            ->with('success', $response['message'] ?? 'Career info item updated successfully');
    }

    /**
     * Remove the specified career info item from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $response = $this->crudApiDelete("/careerinfos/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('careerinfos.index')
                ->with('error', $response['message'] ?? 'Failed to delete career info item');
        }
        
        return redirect()->route('careerinfos.index')
            ->with('success', $response['message'] ?? 'Career info item deleted successfully');
    }
}
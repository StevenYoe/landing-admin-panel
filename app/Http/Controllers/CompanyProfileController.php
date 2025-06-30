<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyProfileController extends BaseController
{
    /**
     * Display a listing of the company profiles.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $params = [
            'sort_by' => $request->input('sort_by', 'cp_id'),
            'sort_order' => $request->input('sort_order', 'asc'),
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page', 1)
        ];

        // Use CRUD API to get company profiles data
        $response = $this->crudApiGet('/companyprofiles', $params);
        
        if (!isset($response['success']) || !$response['success']) {
            return view('companyprofiles.index')->with('error', $response['message'] ?? 'Failed to fetch company profiles');
        }
        
        $companyProfiles = $response['data']['data'] ?? [];
        
        // Create a proper paginator instance
        $paginator = null;
        if (isset($response['data'])) {
            $paginationData = $response['data'];
            if (isset($paginationData['current_page']) && isset($paginationData['per_page']) && isset($paginationData['total'])) {
                $paginator = new LengthAwarePaginator(
                    $companyProfiles,
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
        
        return view('companyprofiles.index', compact('companyProfiles', 'paginator', 'sortBy', 'sortOrder'));
    }

    /**
     * Show the form for creating a new company profile.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('companyprofiles.create');
    }

    /**
     * Store a newly created company profile in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cp_description_id' => 'required|string',
            'cp_description_en' => 'required|string',
            'cp_type' => 'required|string|max:50',
        ]);
        
        $data = $request->except(['_token', '_method']);
        
        // Use CRUD API to store company profile data
        $response = $this->crudApiPost('/companyprofiles', $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to create company profile');
        }
        
        return redirect()->route('companyprofiles.index')
            ->with('success', $response['message'] ?? 'Company profile created successfully');
    }

    /**
     * Display the specified company profile.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $response = $this->crudApiGet("/companyprofiles/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('companyprofiles.index')
                ->with('error', $response['message'] ?? 'Company profile not found');
        }
        
        $companyProfile = $response['data'];
        
        return view('companyprofiles.show', compact('companyProfile'));
    }

    /**
     * Show the form for editing the specified company profile.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $response = $this->crudApiGet("/companyprofiles/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('companyprofiles.index')
                ->with('error', $response['message'] ?? 'Company profile not found');
        }
        
        $companyProfile = $response['data'];
        
        return view('companyprofiles.edit', compact('companyProfile'));
    }

    /**
     * Update the specified company profile in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'cp_description_id' => 'required|string',
            'cp_description_en' => 'required|string',
            'cp_type' => 'required|string|max:50',
        ]);
        
        $data = $request->except(['_token', '_method']);
        
        // Use CRUD API to update company profile data
        $response = $this->crudApiPut("/companyprofiles/{$id}", $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to update company profile');
        }
        
        return redirect()->route('companyprofiles.index')
            ->with('success', $response['message'] ?? 'Company profile updated successfully');
    }

    /**
     * Remove the specified company profile from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $response = $this->crudApiDelete("/companyprofiles/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('companyprofiles.index')
                ->with('error', $response['message'] ?? 'Failed to delete company profile');
        }
        
        return redirect()->route('companyprofiles.index')
            ->with('success', $response['message'] ?? 'Company profile deleted successfully');
    }
    
    /**
     * Show company profile based on type.
     *
     * @param string $type
     * @return \Illuminate\View\View
     */
    public function showByType($type)
    {
        $response = $this->crudApiGet("/companyprofiles/type/{$type}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('companyprofiles.index')
                ->with('error', $response['message'] ?? 'Company profile not found');
        }
        
        $companyProfile = $response['data'];
        
        return view('companyprofiles.show-by-type', compact('companyProfile', 'type'));
    }
}
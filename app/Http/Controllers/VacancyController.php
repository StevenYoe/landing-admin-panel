<?php
// VacancyController manages CRUD operations for vacancies.
// It handles listing, creating, updating, showing, and deleting vacancy records via the CRUD API.
// Also manages filter options for departments, and experiences, and processes related data for display.

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class VacancyController extends BaseController
{
    /**
     * Display a listing of the vacancies.
     * Handles sorting, pagination, filtering, and processes related data for display.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $params = [
            'sort_by' => $request->input('sort_by', 'v_id'),
            'sort_order' => $request->input('sort_order', 'asc'),
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page', 1),
            'department_id' => $request->input('department_id'),
            'experience_id' => $request->input('experience_id'),
            'is_active' => $request->input('is_active', ''),
            'is_urgent' => $request->input('is_urgent', '')
        ];
        
        // Get filter options
        $departmentsResponse = $this->crudApiGet('/departments/all');
        $departments = $departmentsResponse['success'] ? $departmentsResponse['data'] : [];
        
        $experiencesResponse = $this->crudApiGet('/experiences/all');
        $experiences = $experiencesResponse['success'] ? $experiencesResponse['data'] : [];
        
        // Use CRUD API to get vacancies data
        $response = $this->crudApiGet('/vacancies', $params);
        
        if (!isset($response['success']) || !$response['success']) {
            return view('vacancies.index', compact('departments', 'experiences'))
                ->with('error', $response['message'] ?? 'Failed to fetch vacancies');
        }
        
        $vacancies = $response['data']['data'] ?? [];
        
        // Process vacancy data to ensure category_name is accessible
        foreach ($vacancies as &$vacancy) {
            // Check if category data exists in the response and set category_name
            if (isset($vacancy['department']) && is_array($vacancy['department'])) {
                $vacancy['department_name'] = $vacancy['department']['da_title_en'] ?? '-';
            } else {
                $vacancy['department_name'] = '-';
            }
        }
        
        // Process vacancy data to ensure category_name is accessible
        foreach ($vacancies as &$vacancy) {
            // Check if category data exists in the response and set category_name
            if (isset($vacancy['experience']) && is_array($vacancy['experience'])) {
                $vacancy['experience_name'] = $vacancy['experience']['ex_title_en'] ?? '-';
            } else {
                $vacancy['experience_name'] = '-';
            }
        }
        
        // Create a proper paginator instance
        $paginator = null;
        if (isset($response['data'])) {
            $paginationData = $response['data'];
            if (isset($paginationData['current_page']) && isset($paginationData['per_page']) && isset($paginationData['total'])) {
                $paginator = new LengthAwarePaginator(
                    $vacancies,
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
        $departmentId = $params['department_id'];
        $experienceId = $params['experience_id'];
        $isActive = $params['is_active'];
        $isUrgent = $params['is_urgent'];
        
        return view('vacancies.index', compact(
            'vacancies', 
            'paginator', 
            'sortBy', 
            'sortOrder',
            'departments',
            'experiences',
            'departmentId',
            'experienceId',
            'isActive',
            'isUrgent'
        ));
    }
    
    /**
     * Show the form for creating a new vacancy.
     * Fetches dropdown options for departments, and experiences.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Get dropdown options
        $departmentsResponse = $this->crudApiGet('/departments/all');
        $departments = $departmentsResponse['success'] ? $departmentsResponse['data'] : [];
        
        $experiencesResponse = $this->crudApiGet('/experiences/all');
        $experiences = $experiencesResponse['success'] ? $experiencesResponse['data'] : [];
        
        return view('vacancies.create', compact('departments', 'experiences'));
    }
    
    /**
     * Store a newly created vacancy in storage.
     * Validates input, handles checkbox values, and sends data to the CRUD API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'v_title_id' => 'required|string|max:255',
            'v_title_en' => 'required|string|max:255',
            'v_department_id' => 'required|integer',
            'v_experience_id' => 'required|integer',
            'v_type' => 'nullable|string|in:Onsite,Hybrid,Remote',
            'v_description_id' => 'nullable|string',
            'v_description_en' => 'nullable|string',
            'v_requirement_id' => 'nullable|string',
            'v_requirement_en' => 'nullable|string',
            'v_responsibilities_id' => 'nullable|string',
            'v_responsibilities_en' => 'nullable|string',
            'v_posted_date' => 'required|date',
            'v_closed_date' => 'required|date|after_or_equal:v_posted_date',
            'v_urgent' => 'nullable',
            'v_is_active' => 'nullable',
        ]);
        
        // Prepare data for API
        $data = $validated;
        
        // Handle checkbox values - convert to boolean
        $data['v_urgent'] = $request->has('v_urgent') ? true : false;
        $data['v_is_active'] = $request->has('v_is_active') ? true : false;
        
        // Add user information
        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }
        
        // Use CRUD API to store vacancy data
        $response = $this->crudApiPost('/vacancies', $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to create vacancy');
        }
        
        return redirect()->route('vacancies.index')
            ->with('success', $response['message'] ?? 'Vacancy created successfully');
    }
    
    /**
     * Display the specified vacancy.
     * Fetches a single vacancy record and processes related data for display.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $response = $this->crudApiGet("/vacancies/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('vacancies.index')
                ->with('error', $response['message'] ?? 'Vacancy not found');
        }
        
        $vacancy = $response['data'];
        
        // Check if category data exists in the response and set category_name
        if (isset($vacancy['department']) && is_array($vacancy['department'])) {
            $vacancy['department_name'] = $vacancy['department']['da_title_en'] ?? '-';
        } else {
            $vacancy['department_name'] = '-';
        }
        
        // Check if category data exists in the response and set category_name
        if (isset($vacancy['experience']) && is_array($vacancy['experience'])) {
            $vacancy['experience_name'] = $vacancy['experience']['ex_title_en'] ?? '-';
        } else {
            $vacancy['experience_name'] = '-';
        }
        
        return view('vacancies.show', compact('vacancy'));
    }
    
    /**
     * Show the form for editing the specified vacancy.
     * Fetches the record and dropdown options for editing.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $response = $this->crudApiGet("/vacancies/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('vacancies.index')
                ->with('error', $response['message'] ?? 'Vacancy not found');
        }
        
        $vacancy = $response['data'];
        
        // Get dropdown options
        $departmentsResponse = $this->crudApiGet('/departments/all');
        $departments = $departmentsResponse['success'] ? $departmentsResponse['data'] : [];
        
        $experiencesResponse = $this->crudApiGet('/experiences/all');
        $experiences = $experiencesResponse['success'] ? $experiencesResponse['data'] : [];
        
        return view('vacancies.edit', compact('vacancy', 'departments', 'experiences'));
    }
    
    /**
     * Update the specified vacancy in storage.
     * Validates input, handles checkbox values, and updates the record via the CRUD API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // First, get the existing vacancy data to preserve the posted date
        $existingResponse = $this->crudApiGet("/vacancies/{$id}");
        
        if (!isset($existingResponse['success']) || !$existingResponse['success']) {
            return back()
                ->withInput()
                ->with('error', $existingResponse['message'] ?? 'Vacancy not found');
        }
        
        $existingVacancy = $existingResponse['data'];
        
        // Validate the request
        $validated = $request->validate([
            'v_title_id' => 'required|string|max:255',
            'v_title_en' => 'required|string|max:255',
            'v_department_id' => 'required|integer',
            'v_experience_id' => 'required|integer',
            'v_type' => 'nullable|string|in:Onsite,Hybrid,Remote',
            'v_description_id' => 'nullable|string',
            'v_description_en' => 'nullable|string',
            'v_requirement_id' => 'nullable|string',
            'v_requirement_en' => 'nullable|string',
            'v_responsibilities_id' => 'nullable|string',
            'v_responsibilities_en' => 'nullable|string',
            'v_posted_date' => 'nullable|date',
            'v_closed_date' => 'required|date|after_or_equal:v_posted_date',
            'v_urgent' => 'nullable',
            'v_is_active' => 'nullable',
        ]);
        
        // Prepare data for API
        $data = $validated;
        
        // Handle checkbox values - convert to boolean
        $data['v_urgent'] = $request->has('v_urgent') ? true : false;
        $data['v_is_active'] = $request->has('v_is_active') ? true : false;
        
        // Update the posted_date handling
        if ($request->has('v_posted_date') && !empty($request->v_posted_date)) {
            $data['v_posted_date'] = $request->v_posted_date;
        } else {
            $data['v_posted_date'] = $existingVacancy['v_posted_date'] ?? now()->format('Y-m-d');
        }
        
        // Add user information
        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }
        
        // Use CRUD API to update vacancy data
        $response = $this->crudApiPut("/vacancies/{$id}", $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to update vacancy');
        }
        
        return redirect()->route('vacancies.index')
            ->with('success', $response['message'] ?? 'Vacancy updated successfully');
    }
    
    /**
     * Remove the specified vacancy from storage.
     * Deletes the record via the CRUD API and handles the response.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $response = $this->crudApiDelete("/vacancies/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('vacancies.index')
                ->with('error', $response['message'] ?? 'Failed to delete vacancy');
        }
        
        return redirect()->route('vacancies.index')
            ->with('success', $response['message'] ?? 'Vacancy deleted successfully');
    }
}
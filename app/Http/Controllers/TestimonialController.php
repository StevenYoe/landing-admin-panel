<?php
// TestimonialController manages CRUD operations for testimonials.
// It handles listing, creating, updating, showing, and deleting testimonial records via the CRUD API.
// Also manages file uploads for testimonial images, image path transformation, and supports filtering by type.

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;

class TestimonialController extends BaseController
{
    /**
     * Display a listing of the testimonials.
     * Handles sorting, pagination, and image path transformation.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $params = [
            'sort_by' => $request->input('sort_by', 't_id'),
            'sort_order' => $request->input('sort_order', 'asc'),
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page', 1)
        ];

        // Use CRUD API to get testimonials data
        $response = $this->crudApiGet('/testimonials', $params);
        
        if (!isset($response['success']) || !$response['success']) {
            return view('testimonials.index')->with('error', $response['message'] ?? 'Failed to fetch testimonials');
        }
        
        $testimonials = $response['data']['data'] ?? [];
        
        // Transform image paths
        foreach ($testimonials as &$testimonial) {
            if (!empty($testimonial['t_image'])) {
                $testimonial['t_image'] = config('app.crud_storage_url') . '/' . $testimonial['t_image'];
            }
        }
        
        // Create a proper paginator instance
        $paginator = null;
        if (isset($response['data'])) {
            $paginationData = $response['data'];
            if (isset($paginationData['current_page']) && isset($paginationData['per_page']) && isset($paginationData['total'])) {
                $paginator = new LengthAwarePaginator(
                    $testimonials,
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
        
        return view('testimonials.index', compact('testimonials', 'paginator', 'sortBy', 'sortOrder'));
    }

    /**
     * Show the form for creating a new testimonial.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('testimonials.create');
    }

    /**
     * Store a newly created testimonial in storage.
     * Validates input, handles file upload, and sends data to the CRUD API.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            't_name' => 'required|string|max:255',
            't_description_id' => 'required|string',
            't_description_en' => 'required|string',
            't_type' => 'required|string|max:50',
            't_gender' => 'required|in:Male,Female',
            't_image' => 'nullable|image|max:5120',
        ]);
        
        $data = $request->except(['_token', '_method']);
        
        // Handle file uploads if needed
        if ($request->hasFile('t_image') && $request->file('t_image')->isValid()) {
            $data['t_image'] = $request->file('t_image');
        }
        
        // Use CRUD API to store testimonial data
        $response = $this->crudApiPost('/testimonials', $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to create testimonial');
        }
        
        return redirect()->route('testimonials.index')
            ->with('success', $response['message'] ?? 'Testimonial created successfully');
    }

    /**
     * Display the specified testimonial.
     * Fetches a single testimonial record and transforms its image path.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $response = $this->crudApiGet("/testimonials/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('testimonials.index')
                ->with('error', $response['message'] ?? 'Testimonial not found');
        }
        
        $testimonial = $response['data'];
        
        // Transform image paths
        if (!empty($testimonial['t_image'])) {
            $testimonial['t_image'] = config('app.crud_storage_url') . '/' . $testimonial['t_image'];
        }
        
        return view('testimonials.show', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified testimonial.
     * Fetches the record and transforms its image path for editing.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $response = $this->crudApiGet("/testimonials/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('testimonials.index')
                ->with('error', $response['message'] ?? 'Testimonial not found');
        }
        
        $testimonial = $response['data'];
    
        // Transform image paths to full URLs if they exist
        if (!empty($testimonial['t_image'])) {
            $testimonial['t_image'] = config('app.crud_storage_url') . '/' . $testimonial['t_image'];
        }
        
        return view('testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified testimonial in storage.
     * Validates input, handles file upload, and updates the record via the CRUD API.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            't_name' => 'required|string|max:255',
            't_description_id' => 'required|string',
            't_description_en' => 'required|string',
            't_type' => 'required|string|max:50',
            't_gender' => 'required|in:Male,Female',
            't_image' => 'nullable|image|max:5120',
        ]);
        
        $data = $request->except(['_token', '_method']);
        
        // Get current testimonial to check if we need to retain the images
        $currentTestimonial = $this->crudApiGet("/testimonials/{$id}");
        
        // Handle file uploads if needed
        if ($request->hasFile('t_image') && $request->file('t_image')->isValid()) {
            $data['t_image'] = $request->file('t_image');
        } else if (isset($currentTestimonial['data']['t_image']) && !empty($currentTestimonial['data']['t_image'])) {
            // If no new image is uploaded and there is an existing image, 
            // we need to explicitly indicate to keep the current image
            $data['keep_current_image'] = true;
        }
        
        // Use CRUD API to update testimonial data
        $response = $this->crudApiPut("/testimonials/{$id}", $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return back()
                ->withInput()
                ->withErrors($response['errors'] ?? [])
                ->with('error', $response['message'] ?? 'Failed to update testimonial');
        }
        
        return redirect()->route('testimonials.index')
            ->with('success', $response['message'] ?? 'Testimonial updated successfully');
    }

    /**
     * Remove the specified testimonial from storage.
     * Deletes the record via the CRUD API and handles the response.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $response = $this->crudApiDelete("/testimonials/{$id}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('testimonials.index')
                ->with('error', $response['message'] ?? 'Failed to delete testimonial');
        }
        
        return redirect()->route('testimonials.index')
            ->with('success', $response['message'] ?? 'Testimonial deleted successfully');
    }
    
    /**
     * Show testimonials based on type.
     * Fetches testimonials by type and transforms image paths.
     *
     * @param string $type
     * @return \Illuminate\View\View
     */
    public function showByType($type)
    {
        $response = $this->crudApiGet("/testimonials/type/{$type}");
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('testimonials.index')
                ->with('error', $response['message'] ?? 'Testimonials not found');
        }
        
        $testimonials = $response['data'];
        
        // Transform image paths
        foreach ($testimonials as &$testimonial) {
            if (!empty($testimonial['t_image'])) {
                $testimonial['t_image'] = config('app.crud_storage_url') . '/' . $testimonial['t_image'];
            }
        }
        
        return view('testimonials.show-by-type', compact('testimonials', 'type'));
    }
}
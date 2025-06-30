@extends('layouts.app')

@section('title', 'Edit Vacancy - Pazar Website Admin')

@section('page-title', 'Edit Vacancy')

@section('content')
    <div class="mb-6">
        <x-button href="{{ route('vacancies.index') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    
    <x-card>
        <form action="{{ route('vacancies.update', $vacancy['v_id']) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <x-form.input 
                        name="v_title_id" 
                        label="Title (Indonesian)" 
                        placeholder="Enter title in Indonesian" 
                        :value="old('v_title_id', $vacancy['v_title_id'])"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
                
                <div>
                    <x-form.input 
                        name="v_title_en" 
                        label="Title (English)" 
                        placeholder="Enter title in English" 
                        :value="old('v_title_en', $vacancy['v_title_en'])"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
                
                <div>
                    <x-form.select 
                        name="v_department_id" 
                        label="Department" 
                        :options="collect($departments)->pluck('da_title_en', 'da_id')->prepend('Select Department', '')" 
                        :selected="old('v_department_id', $vacancy['v_department_id'])"
                        required
                    />
                </div>
                
                <div>
                    <x-form.select 
                        name="v_employment_id" 
                        label="Employment Type" 
                        :options="collect($employments)->pluck('e_title_en', 'e_id')->prepend('Select Employment Type', '')" 
                        :selected="old('v_employment_id', $vacancy['v_employment_id'])"
                        required
                    />
                </div>
                
                <div>
                    <x-form.select 
                        name="v_experience_id" 
                        label="Experience Level" 
                        :options="collect($experiences)->pluck('ex_title_en', 'ex_id')->prepend('Select Experience Level', '')" 
                        :selected="old('v_experience_id', $vacancy['v_experience_id'])"
                        required
                    />
                </div>
                
                <div>
                    <x-form.input 
                        name="v_type" 
                        label="Type (Optional)" 
                        placeholder="E.g., Remote, Onsite, Hybrid" 
                        :value="old('v_type', $vacancy['v_type'])"
                        helper="Maximum 50 characters"
                    />
                </div>
                
                <div>
                    <x-form.input
                        type="date"
                        name="v_posted_date"
                        label="Posted Date (Optional)"
                        :value="old('v_posted_date', !empty($vacancy['v_posted_date']) ? date('Y-m-d', strtotime($vacancy['v_posted_date'])) : '')"
                        helper="Leave empty to keep existing date"
                    />
                </div>
                <div>
                    <x-form.input
                        type="date"
                        name="v_closed_date"
                        label="Closing Date"
                        :value="old('v_closed_date', !empty($vacancy['v_closed_date']) ? date('Y-m-d', strtotime($vacancy['v_closed_date'])) : '')"
                        required
                        helper="Application deadline (required)"
                    />
                </div>
                
                <div class="col-span-1 md:col-span-2">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <x-form.checkbox 
                                name="v_urgent" 
                                label="Mark as Urgent" 
                                :checked="old('v_urgent', $vacancy['v_urgent'] ?? false)"
                                value="1"
                            />
                        </div>
                        
                        <div>
                            <x-form.checkbox 
                                name="v_is_active" 
                                label="Active Status" 
                                :checked="old('v_is_active', $vacancy['v_is_active'] ?? true)"
                                value="1"
                            />
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 grid grid-cols-1 gap-6">
                <div>
                    <x-form.textarea 
                        name="v_description_id" 
                        label="Description (Indonesian)" 
                        placeholder="Enter job description in Indonesian" 
                        :value="old('v_description_id', $vacancy['v_description_id'])"
                        rows="5"
                        required
                    />
                </div>
                
                <div>
                    <x-form.textarea 
                        name="v_description_en" 
                        label="Description (English)" 
                        placeholder="Enter job description in English" 
                        :value="old('v_description_en', $vacancy['v_description_en'])"
                        rows="5"
                        required
                    />
                </div>
                
                <div>
                    <x-form.textarea 
                        name="v_requirement_id" 
                        label="Requirement (Indonesian)" 
                        placeholder="Enter job requirement in Indonesian" 
                        :value="old('v_requirement_id', $vacancy['v_requirement_id'])"
                        rows="5"
                        required
                    />
                </div>
                
                <div>
                    <x-form.textarea 
                        name="v_requirement_en" 
                        label="Requirement (English)" 
                        placeholder="Enter job requirement in English" 
                        :value="old('v_requirement_en', $vacancy['v_requirement_en'])"
                        rows="5"
                        required
                    />
                </div>
                
                <div>
                    <x-form.textarea 
                        name="v_responsibilities_id" 
                        label="Responsibilities (Indonesian)" 
                        placeholder="Enter job responsibilities in Indonesian" 
                        :value="old('v_responsibilities_id', $vacancy['v_responsibilities_id'])"
                        rows="5"
                        required
                    />
                </div>
                
                <div>
                    <x-form.textarea 
                        name="v_responsibilities_en" 
                        label="Responsibilities (English)" 
                        placeholder="Enter job responsibilities in English" 
                        :value="old('v_responsibilities_en', $vacancy['v_responsibilities_en'])"
                        rows="5"
                        required
                    />
                </div>
            </div>
            
            <div class="flex justify-end mt-6 space-x-3">
                <x-button type="button" href="{{ route('vacancies.index') }}" variant="outline">
                    Cancel
                </x-button>
                <x-button type="submit" variant="primary">
                    Update
                </x-button>
            </div>
        </form>
    </x-card>
@endsection
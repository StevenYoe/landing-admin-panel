<!--
    Add Vacancy Page
    This Blade view provides a form for creating a new job vacancy, including title, department, experience, dates, status, and detailed descriptions.
    Each section, form, field, and button is commented to clarify its purpose for future developers.
-->
@extends('layouts.app')

@section('title', 'Add Vacancy - Pazar Website Admin')

@section('page-title', 'Add Vacancy')

@section('content')
    <!-- Top bar with Back to List button -->
    <div class="mb-6">
        <x-button href="{{ route('vacancies.index') }}" variant="outline">
            <!-- Back icon -->
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </x-button>
    </div>
    
    <!-- Card container for the create form -->
    <x-card>
        <!-- Form to add a new vacancy -->
        <form action="{{ route('vacancies.store') }}" method="POST">
            @csrf
            
            <!-- Input fields for vacancy details -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <!-- Title in Indonesian -->
                    <x-form.input 
                        name="v_title_id" 
                        label="Title (Indonesian)" 
                        placeholder="Enter title in Indonesian" 
                        :value="old('v_title_id')"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
                
                <div>
                    <!-- Title in English -->
                    <x-form.input 
                        name="v_title_en" 
                        label="Title (English)" 
                        placeholder="Enter title in English" 
                        :value="old('v_title_en')"
                        required
                        helper="Maximum 255 characters"
                    />
                </div>
                
                <div>
                    <!-- Department selection -->
                    <x-form.select 
                        name="v_department_id" 
                        label="Department" 
                        :options="collect($departments)->pluck('da_title_en', 'da_id')->prepend('Select Department', '')" 
                        :selected="old('v_department_id')"
                        required
                    />
                </div>
                
                <div>
                    <!-- Experience level selection -->
                    <x-form.select 
                        name="v_experience_id" 
                        label="Experience Level" 
                        :options="collect($experiences)->pluck('ex_title_en', 'ex_id')->prepend('Select Experience Level', '')" 
                        :selected="old('v_experience_id')"
                        required
                    />
                </div>
                
                <div>
                    <!-- Type selection dropdown -->
                    <x-form.select 
                        name="v_type" 
                        label="Type (Optional)" 
                        :options="[
                            '' => 'Select Type',
                            'Onsite' => 'Onsite',
                            'Hybrid' => 'Hybrid',
                            'Remote' => 'Remote'
                        ]"
                        :selected="old('v_type')"
                        helper="Select work arrangement type"
                    />
                </div>
                
                <div>
                    <!-- Posted date -->
                    <x-form.input
                        type="date"
                        name="v_posted_date"
                        label="Posted Date"
                        :value="old('v_posted_date', date('Y-m-d'))"
                        required
                        helper="Date when the vacancy is posted"
                    />
                </div>
                <div>
                    <!-- Closing date -->
                    <x-form.input
                        type="date"
                        name="v_closed_date"
                        label="Closing Date"
                        :value="old('v_closed_date')"
                        :min="date('Y-m-d')"
                        required
                        helper="Application deadline (required)"
                    />
                </div>
                
                <div class="col-span-1 md:col-span-2">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <!-- Urgent checkbox -->
                            <x-form.checkbox 
                                name="v_urgent" 
                                label="Mark as Urgent" 
                                :checked="old('v_urgent', false)"
                                value="1"
                            />
                        </div>
                        
                        <div>
                            <!-- Active status checkbox -->
                            <x-form.checkbox 
                                name="v_is_active" 
                                label="Active Status" 
                                :checked="old('v_is_active', true)"
                                value="1"
                            />
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Textarea fields for descriptions, requirements, and responsibilities in both languages -->
            <div class="mt-6 grid grid-cols-1 gap-6">
                <div>
                    <!-- Description in Indonesian -->
                    <x-form.textarea 
                        name="v_description_id" 
                        label="Description (Indonesian)" 
                        placeholder="Enter job description in Indonesian" 
                        :value="old('v_description_id')"
                        rows="5"
                        helper="Optional field"
                    />
                </div>
                
                <div>
                    <!-- Description in English -->
                    <x-form.textarea 
                        name="v_description_en" 
                        label="Description (English)" 
                        placeholder="Enter job description in English" 
                        :value="old('v_description_en')"
                        rows="5"
                        helper="Optional field"
                    />
                </div>
                
                <div>
                    <!-- Requirement in Indonesian -->
                    <x-form.textarea 
                        name="v_requirement_id" 
                        label="Requirement (Indonesian)" 
                        placeholder="Enter job requirement in Indonesian" 
                        :value="old('v_requirement_id')"
                        rows="5"
                        helper="Optional field"
                    />
                </div>
                
                <div>
                    <!-- Requirement in English -->
                    <x-form.textarea 
                        name="v_requirement_en" 
                        label="Requirement (English)" 
                        placeholder="Enter job requirement in English" 
                        :value="old('v_requirement_en')"
                        rows="5"
                        helper="Optional field"
                    />
                </div>
                
                <div>
                    <!-- Responsibilities in Indonesian -->
                    <x-form.textarea 
                        name="v_responsibilities_id" 
                        label="Responsibilities (Indonesian)" 
                        placeholder="Enter job responsibilities in Indonesian" 
                        :value="old('v_responsibilities_id')"
                        rows="5"
                        helper="Optional field"
                    />
                </div>
                
                <div>
                    <!-- Responsibilities in English -->
                    <x-form.textarea 
                        name="v_responsibilities_en" 
                        label="Responsibilities (English)" 
                        placeholder="Enter job responsibilities in English" 
                        :value="old('v_responsibilities_en')"
                        rows="5"
                        helper="Optional field"
                    />
                </div>
            </div>
            
            <!-- Action buttons: Cancel and Save -->
            <div class="flex justify-end mt-6 space-x-3">
                <!-- Cancel button: returns to the list -->
                <x-button type="button" href="{{ route('vacancies.index') }}" variant="outline">
                    Cancel
                </x-button>
                <!-- Save button: submits the form -->
                <x-button type="submit" variant="primary">
                    Save
                </x-button>
            </div>
        </form>
    </x-card>
@endsection
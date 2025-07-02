<!--
    User Profile Page
    This Blade view displays the authenticated user's profile details, including personal info, division, position, join date, and roles.
    Each section, field, and action button is commented to clarify its purpose for future developers.
-->
@extends('layouts.app')

@section('title', 'My Profile - Pazar Website Admin')

@section('page-title', 'My Profile')

@section('content')
    <!-- Card container for profile details -->
    <x-card>
        <div class="mb-4">
            <!-- Section title -->
            <h2 class="text-xl font-semibold">Profile Details</h2>
        </div>
        
        @if($user)
            <!-- Profile details grid: left and right columns -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                <!-- Profile image section -->
                <div class="mb-4">
                    <div class="w-20 h-20 rounded-full bg-gray-700 flex items-center justify-center overflow-hidden">
                        @if($user && $user['u_profile_image'])
                        <!-- User profile image -->
                        <img src="{{ config('app.user_storage_url') . '/' . $user['u_profile_image'] }}" 
                            alt="Profile" 
                            class="w-full h-full object-cover">
                        @else
                            <!-- Placeholder icon if no profile image -->
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        @endif
                    </div>
                </div>
                
                    <!-- Employee ID field -->
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Employee ID</p>
                        <p class="text-lg font-semibold">{{ $user['u_employee_id'] ?? 'N/A' }}</p>
                    </div>
                    
                    <!-- Name field -->
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</p>
                        <p class="text-lg font-semibold">{{ $user['u_name'] ?? 'N/A' }}</p>
                    </div>
                    
                    <!-- Email field -->
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</p>
                        <p class="text-lg font-semibold">{{ $user['u_email'] ?? 'N/A' }}</p>
                    </div>
                </div>
                
                <div>
                    <!-- Division field -->
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Division</p>
                        <p class="text-lg font-semibold">{{ $user['division']['div_name'] ?? 'N/A' }}</p>
                    </div>
                    
                    <!-- Position field -->
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Position</p>
                        <p class="text-lg font-semibold">{{ $user['position']['pos_name'] ?? 'N/A' }}</p>
                    </div>
                    
                    <!-- Join date field -->
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Join Date</p>
                        <p class="text-lg font-semibold">{{ $user['u_join_date'] ? date('d F Y', strtotime($user['u_join_date'])) : 'N/A' }}</p>
                    </div>
                    
                    <!-- Roles field: displays all user roles as badges -->
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Role</p>
                        <div class="flex flex-wrap gap-1 mt-1">
                            @if(isset($user['roles']) && count($user['roles']) > 0)
                                @foreach($user['roles'] as $role)
                                    <!-- Role badge -->
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-700 text-white">
                                        {{ $role['role_name'] }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Logout button section -->
            <div class="mt-6 border-t border-gray-700 pt-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        <div class="flex items-center">
                            <!-- Logout icon -->
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </div>
                    </button>
                </form>
            </div>
        @else
            <!-- If user data is not available -->
            <div class="py-8 text-center">
                <p class="text-gray-400">Data profil tidak tersedia</p>
            </div>
        @endif
    </x-card>
@endsection
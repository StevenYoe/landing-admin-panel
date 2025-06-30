<aside 
    :class="sidebarOpen ? 'translate-x-0 w-64' : 'w-0 -translate-x-full'"
    class="fixed z-20 inset-y-0 left-0 mt-16 transition-all duration-300 transform h-full bg-bg-dark border-r border-gray-700 overflow-hidden">
    
    @php
        $userRoles = array_map('strtolower', (array)Session::get('roles', []));
        // Use trim() here as well for robustness
        $userDivision = strtolower(trim(Session::get('division', '')));
        
        $isSuperAdmin = in_array('superadmin', $userRoles);
        $isMarketingOrSocial = in_array($userDivision, ['marketing', 'social media']);
        $isHumanResources = ($userDivision === 'human resources');
    @endphp
    
    <div class="sidebar-content">
        <nav class="p-4 space-y-2 overflow-y-auto h-full">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-700 
                    {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Dashboard</span>
            </a>
            
            {{-- Menus for Superadmin, Marketing, and Social Media --}}
            @if($isSuperAdmin || $isMarketingOrSocial)
                <!-- Layout Menu with Submenu -->
                <div x-data="{ open: false }" class="space-y-1">
                    <button @click="open = !open" class="flex items-center justify-between w-full p-2 rounded-lg hover:bg-gray-700 
                            {{ request()->routeIs('headers.*') || request()->routeIs('footers.*') ? 'bg-gray-700' : '' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm0 8a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1v-2zm0 8a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1v-2z"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Layout</span>
                        </div>
                        <svg :class="open ? 'transform rotate-180' : ''" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" class="pl-6 space-y-1">
                        <!-- Headers -->
                        <a href="{{ route('headers.index') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('headers.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Headers</span>
                        </a>

                        <!-- Footers -->
                        <a href="{{ route('footers.index') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('footers.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Footers</span>
                        </a>
                    </div>
                </div>

                <!-- Index Menu with Submenu -->
                <div x-data="{ open: false }" class="space-y-1">
                    <button @click="open = !open" class="flex items-center justify-between w-full p-2 rounded-lg hover:bg-gray-700 
                            {{ request()->routeIs('popups.*') ? 'bg-gray-700' : '' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Index</span>
                        </div>
                        <svg :class="open ? 'transform rotate-180' : ''" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" class="pl-6 space-y-1">
                        <!-- Popups -->
                        <a href="{{ route('popups.index') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('popups.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Popups</span>
                        </a>
                    </div>
                </div>
                
                <!-- Our Company Menu with Submenu -->
                <div x-data="{ open: false }" class="space-y-1">
                    <button @click="open = !open" class="flex items-center justify-between w-full p-2 rounded-lg hover:bg-gray-700 
                            {{ request()->routeIs('histories.*') || request()->routeIs('companyprofiles.*') ? 'bg-gray-700' : '' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Our Company</span>
                        </div>
                        <svg :class="open ? 'transform rotate-180' : ''" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" class="pl-6 space-y-1">
                        <!-- Histories -->
                        <a href="{{ route('histories.index') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('histories.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Histories</span>
                        </a>

                        <!-- Company Profiles -->
                        <a href="{{ route('companyprofiles.index') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('company_profiles.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Company Profiles</span>
                        </a>
                    </div>
                </div>

                <!-- Our Brand Menu with Submenu (previously Why Choose Us) -->
                <div x-data="{ open: false }" class="space-y-1">
                    <button @click="open = !open" class="flex items-center justify-between w-full p-2 rounded-lg hover:bg-gray-700 
                            {{ request()->routeIs('whypazars.*') || request()->routeIs('certifications.*') || request()->routeIs('testimonials.*') ? 'bg-gray-700' : '' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Our Brand</span>
                        </div>
                        <svg :class="open ? 'transform rotate-180' : ''" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" class="pl-6 space-y-1">
                        <!-- Why Pazars -->
                        <a href="{{ route('whypazars.index') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('why_pazars.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Why Pazars</span>
                        </a>

                        <!-- Certifications -->
                        <a href="{{ route('certifications.index') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('certifications.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Certifications</span>
                        </a>
                        
                        <!-- Testimonials -->
                        <a href="{{ route('testimonials.index') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('testimonials.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Testimonials</span>
                        </a>
                    </div>
                </div>

                <!-- Product Menu with Submenu -->
                <div x-data="{ open: false }" class="space-y-1">
                    <button @click="open = !open" class="flex items-center justify-between w-full p-2 rounded-lg hover:bg-gray-700 
                            {{ request()->routeIs('productcategories.*') || request()->routeIs('products.*') || request()->routeIs('productcatalogs.*') ? 'bg-gray-700' : '' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Product</span>
                        </div>
                        <svg :class="open ? 'transform rotate-180' : ''" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" class="pl-6 space-y-1">
                        <!-- Product Categories -->
                        <a href="{{ route('productcategories.index') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('productcategories.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Product Categories</span>
                        </a>

                        <!-- Products -->
                        <a href="{{ route('products.index') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('products.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Products</span>
                        </a>

                        <!-- Product Catalogs -->
                        <a href="{{ route('productcatalogs.index') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('productcatalogs.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Product Catalogs</span>
                        </a>
                    </div>
                </div>

                <!-- Recipe Menu with Submenu -->
                <div x-data="{ open: false }" class="space-y-1">
                    <button @click="open = !open" class="flex items-center justify-between w-full p-2 rounded-lg hover:bg-gray-700 
                            {{ request()->routeIs('recipecategories.*') || request()->routeIs('recipes.*') ? 'bg-gray-700' : '' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Recipe</span>
                        </div>
                        <svg :class="open ? 'transform rotate-180' : ''" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" class="pl-6 space-y-1">
                        <!-- Recipe Categories -->
                        <a href="{{ route('recipecategories.index') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('recipecategories.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Recipe Categories</span>
                        </a>

                        <!-- Recipes -->
                        <a href="{{ route('recipes.index') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('recipes.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Recipes</span>
                        </a>
                    </div>
                </div>
            @endif

            @if($isSuperAdmin || $isHumanResources)
                <!-- Career Menu with Submenu -->
                <div x-data="{ open: false }" class="space-y-1">
                    <button @click="open = !open" class="flex items-center justify-between w-full p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('careerinfos.*') || request()->routeIs('workatpazars.*') ? 'bg-gray-700' : '' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Career</span>
                        </div>
                        <svg :class="open ? 'transform rotate-180' : ''" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" class="pl-6 space-y-1">
                        <!-- Career Info -->
                        <a href="{{ route('careerinfos.index') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('careerinfos.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Career Info</span>
                        </a>
                        <!-- Work At Pazar -->
                        <a href="{{ route('workatpazars.index') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('workatpazars.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Work At Pazar</span>
                        </a>
                    </div>
                </div>

                <!-- Vacancies Menu with Submenu -->
                <div x-data="{ open: false }" class="space-y-1">
                    <button @click="open = !open" class="flex items-center justify-between w-full p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('departments.*') || request()->routeIs('employments.*') || request()->routeIs('experiences.*') || request()->routeIs('vacancies.*') ? 'bg-gray-700' : '' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Vacancies</span>
                        </div>
                        <svg :class="open ? 'transform rotate-180' : ''" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" class="pl-6 space-y-1">
                        <!-- Departments -->
                        <a href="{{ route('departments.index') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('departments.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Departments</span>
                        </a>
                        <!-- Employments -->
                        <a href="{{ route('employments.index') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('employments.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Employments</span>
                        </a>
                        <!-- Experiences -->
                        <a href="{{ route('experiences.index') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('experiences.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Experiences</span>
                        </a>
                        <!-- Vacancies -->
                        <a href="{{ route('vacancies.index') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('vacancies.*') ? 'bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Vacancies</span>
                        </a>
                    </div>
                </div>
            @endif

            <!-- My Profile Link (previously Profile Saya) -->
            <a href="{{ route('profile') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-700 
                    {{ request()->routeIs('profile') ? 'bg-gray-700' : '' }}">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">My Profile</span>
            </a>
        </nav>
    </div>
</aside>
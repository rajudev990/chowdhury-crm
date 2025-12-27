<!-- Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 h-screen w-64 bg-white shadow-lg overflow-y-auto
  transform transition-transform duration-300 ease-in-out
  z-40 -translate-x-full">
    <!-- Logo Section -->
    <div class="px-4 py-2">
        <div class="flex items-center justify-center w-20 h-20 mx-auto">
            <img src="{{ asset('/') }}logo.webp" alt="Logo" class="w-full h-full object-cover rounded-full" />
        </div>
    </div>

    <!-- User Welcome Section -->
    <div class="px-4 py-2">
        <div class="flex items-start space-x-3">
            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-user text-gray-500"></i>
            </div>
            <div>
                @php
                $hour = date('H'); // 24-hour format
                if ($hour < 6) { $greeting='Good Morning' ; } elseif ($hour < 6) { $greeting='Good Afternoon' ; } else {
                    $greeting='Good Evening' ; } @endphp <p class="text-sm text-gray-600">{{ $greeting }}</p>
                    <p class="text-sm font-medium text-gray-800">
                        {{ Auth::user()->name ?? 'Guest' }}
                    </p>
            </div>
        </div>
    </div>

    <!-- Navigation Links -->
    <nav class="py-4">
        <!-- Dashboard - Active State -->
        <a href="/" class="flex items-center px-6 py-3 transition-colors {{ Route::is('dashboard') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50' }}">
            <i class="fas fa-th-large w-6"></i>
            <span class="ml-3 font-medium">Dashboard</span>
        </a>

        <!-- Leads -->
        @can('view leads')
        <a href="{{url('leads')}}" class="flex items-center px-6 py-3 transition-colors {{ Route::is('leads.*') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50' }}">
            <i class="fas fa-user-friends w-6"></i>
            <span class="ml-3">Leads</span>
        </a>
        @endcan

        <!-- Customers -->
        <a href="{{url('customers')}}"
            class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
            <i class="fas fa-users w-6"></i>
            <span class="ml-3">Customers</span>
        </a>

        <!-- Projects -->
        <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
            <i class="fas fa-chart-bar w-6"></i>
            <span class="ml-3">Projects</span>
        </a>




        <!-- Leave Request -->
        <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
            <i class="fas fa-person-walking w-6"></i>
            <span class="ml-3">Leave Request</span>
        </a>

        <!-- Payroll -->
        <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
            <i class="fas fa-file-lines w-6"></i>
            <span class="ml-3">Payroll</span>
        </a>

        <!-- Expenses -->
        <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
            <i class="fas fa-receipt w-6"></i>
            <span class="ml-3">Expenses</span>
        </a>


        <!-- Setup -->
        <!-- Parent Button Wrapper -->
        <div class="dropdown-container">

            <!-- Parent Button -->
            <button
                class="dropdown-btn w-full flex items-center justify-between px-6 py-3 text-gray-600 hover:bg-gray-50 transition">
                <div class="flex items-center">
                    <i class="fas fa-users w-6"></i>
                    <span class="ml-3">User Management</span>
                </div>
                <i class="dropdown-arrow fas fa-chevron-right text-xs transition-transform"></i>
            </button>

            <!-- Dropdown / Sub Menu -->
            <div class="dropdown-content max-h-0 overflow-hidden transition-all duration-300">
                @can('view role')
                <a href="{{ route('roles.index') }}" class="block px-14 py-2 text-sm text-gray-600 hover:bg-gray-50">
                    <i class="fas fa-user-shield mr-2"></i>Role
                </a>
                @endcan
                @can('view permission')
                <a href="{{ route('permissions.index') }}"
                    class="block px-14 py-2 text-sm text-gray-600 hover:bg-gray-50">
                    <i class="fas fa-key mr-2"></i>
                    Permission
                </a>
                @endcan
                @can('view user')
                <a href="{{ route('users.index') }}" class="block px-14 py-2 text-sm text-gray-600 hover:bg-gray-50">
                    <i class="fas fa-users mr-2"></i>
                    Staff
                </a>
                @endcan
            </div>
        </div>


        <div class="dropdown-container">

            <!-- Parent Button -->
            <button
                class="dropdown-btn w-full flex items-center justify-between px-6 py-3 text-gray-600 hover:bg-gray-50 transition">
                <div class="flex items-center">
                    <i class="fas fa-cog w-6"></i>
                    <span class="ml-3">Setup</span>
                </div>
                <i class="dropdown-arrow fas fa-chevron-right text-xs transition-transform"></i>
            </button>

            <!-- Dropdown / Sub Menu -->
            <div class="dropdown-content max-h-0 overflow-hidden transition-all duration-300">
                <a href="{{ route('countries.index') }}" class="block px-14 py-2 text-sm text-gray-600 hover:bg-gray-50">
                    <i class="fas fa-globe mr-2"></i>Country
                </a>

                <a href="{{ route('statuses.index') }}" class="block px-14 py-2 text-sm text-gray-600 hover:bg-gray-50">
                    <i class="fas fa-check-circle mr-2"></i>Status
                </a>

                <a href="{{ route('sources.index') }}" class="block px-14 py-2 text-sm text-gray-600 hover:bg-gray-50">
                    <i class="fas fa-link mr-2"></i>Source
                </a>

                <a href="{{ route('settings.index') }}" class="block px-14 py-2 text-sm text-gray-600 hover:bg-gray-50">
                    <i class="fas fa-sliders-h mr-2"></i>Settings
                </a>
            </div>
        </div>


    </nav>

</aside>


<!-- Overlay for mobile -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden transition-opacity duration-300"></div>
<div id="overlay" class="fixed inset-0 bg-black/40 z-30 hidden md:hidden">
</div>
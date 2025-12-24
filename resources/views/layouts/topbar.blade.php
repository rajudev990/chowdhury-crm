<!-- Header -->
<header id="header" class="fixed top-0 left-0 md:left-64 right-0 bg-white shadow-sm
  border-b border-gray-200 transition-all duration-300 z-20">
    <div class="flex items-center justify-between px-6 py-4">
        <!-- Left Side: Hamburger Menu & Dashboard Title -->
        <div class="flex items-center space-x-4">
            <button id="menuBtn" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>
            <h1 class="text-xl font-semibold text-gray-800 hidden md:block">Dashboard</h1>
        </div>

        <!-- Right Side: Icons, Date/Time & User Avatar -->
        <div class="flex items-center space-x-4 md:space-x-8">
            <!-- Shopping Cart Icon with Badge -->
            <button class="relative text-gray-500 hover:text-gray-700 focus:outline-none">
                <i class="fas fa-shopping-cart text-xl md:text-2xl"></i>
                <span
                    class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">2</span>
            </button>

            <!-- Messages Icon -->
            <button class="text-gray-500 hover:text-gray-700 focus:outline-none">
                <i class="far fa-comment-dots text-xl md:text-2xl"></i>
            </button>

            <!-- Bell Icon with Badge -->
            <button class="relative text-gray-500 hover:text-gray-700 focus:outline-none">
                <i class="far fa-bell text-xl md:text-2xl"></i>
                <span
                    class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">7</span>
            </button>

            <div class="flex items-center space-x-4 border-l-2 pl-4">
                <!-- Date & Time -->
                <div class="text-sm text-gray-600 hidden lg:block text-right">
                    <div id="currentDate" class="font-medium"></div>
                    <div id="currentTime" class="text-gray-500"></div>
                </div>


                <!-- User Avatar Dropdown -->
                <div class="relative">
                    <button id="userMenuBtn" class="focus:outline-none flex items-center">
                        <div
                            class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center overflow-hidden">
                            <i class="fas fa-user text-gray-500 text-xl md:text-2xl"></i>
                        </div>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="userDropdown"
                        class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-lg border hidden z-50">

                        <div class="px-4 py-3 border-b">
                           <p class="text-sm font-semibold text-gray-800">
                                {{ Auth::user()->name }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ Auth::user()->email }}
                            </p>

                        </div>

                        <ul class="py-2 text-sm text-gray-700">
                            <li>
                                <a href="javascript:void(0)"
                                onclick="openProfileSidebar()"
                                class="flex items-center px-4 py-2 hover:bg-gray-100">
                                    <i class="fas fa-user mr-3 text-gray-400"></i> My Profile
                                </a>
                            </li>


                            <li>
                                <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">
                                    <i class="fas fa-gear mr-3 text-gray-400"></i> Account Settings
                                </a>
                            </li>

                            <li>
                                <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">
                                    <i class="fas fa-bell mr-3 text-gray-400"></i> Notifications
                                </a>
                            </li>

                            <li>
                                <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">
                                    <i class="fas fa-life-ring mr-3 text-gray-400"></i> Help & Support
                                </a>
                            </li>
                        </ul>


                        <div class="border-t">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                                    <i class="fas fa-right-from-bracket mr-3"></i> Logout
                                </button>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>
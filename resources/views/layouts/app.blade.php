<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        /* Sidebar styles */
        .sidebar {
            position: fixed;
            top: 0;
            right: 0;
            width: 300px;
            height: 100%;
            background-color: #fff;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
            overflow: hidden;
            z-index: 1000;
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .back-btn {
            background-color: #1A3A66;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        .sidebar-content {
            padding: 20px;
            /* Add any additional styling for your sidebar content */
        }

        .hidden {
            display: none;
        }
    </style>
    <!-- Tailwind config colour -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#1A3A66",
                    },
                },
            },
        };
    </script>
    @yield('css')
</head>

<body class="bg-gray-50">


    @include('layouts.sidebar')
    @include('layouts.topbar')

    <!-- Main Content -->
    <main id="mainContent" class="md:ml-64 mt-20 p-4 md:p-8 transition-all duration-300">

        @yield('content')

    </main>

    <!-- Overlay -->
    <div id="leadFormOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden transition-opacity duration-300">
    </div>

    <!-- Sidebar -->
    <div id="leadFormSidebar"
        class="fixed top-0 right-0 h-full w-full md:w-[1200px] bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto">

        <!-- Header -->
        <div class="bg-[#4A5F7F] text-white p-6 flex items-center gap-4 sticky top-0 z-10">
            <button id="closeLeadFormBtn" class="text-white hover:bg-[#3d4f68] p-2 rounded-lg transition">
                <i class="fas fa-arrow-left text-xl"></i>
            </button>
            <h2 class="text-2xl font-semibold">New Lead</h2>
        </div>

        <!-- Form Content -->
        <div class="p-6">

            <!-- Top Dropdowns -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                    <select
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Status</option>
                        <option value="new">New</option>
                        <option value="contacted">Contacted</option>
                        <option value="qualified">Qualified</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Source <span class="text-red-500">*</span></label>
                    <select
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Source</option>
                        <option value="website">Website</option>
                        <option value="referral">Referral</option>
                        <option value="social">Social Media</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Assigness <span class="text-red-500">*</span></label>
                    <select
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Advanced study S</option>
                        <option value="user1">User 1</option>
                        <option value="user2">User 2</option>
                    </select>
                </div>
            </div>

            <!-- How did hear about us -->
            <div class="mb-6">
                <select
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">How did hear about us?</option>
                    <option value="google">Google Search</option>
                    <option value="friend">Friend</option>
                    <option value="ad">Advertisement</option>
                </select>
            </div>

            <!-- Personal Information Section -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-[#4A5F7F] mb-4">Personal Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 mb-2">Name <span class="text-red-500">*</span></label>
                        <input type="text"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter name">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Date of Birth</label>
                        <input type="date"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">E-Mail</label>
                        <input type="email"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter email">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 mb-2">Phone <span class="text-red-500">*</span></label>
                        <div class="flex gap-2">
                            <div class="flex items-center gap-2 border border-gray-300 rounded-lg px-3 py-3 bg-gray-50">
                                <span class="text-2xl">🇧🇩</span>
                                <span class="text-gray-700">+880</span>
                            </div>
                            <input type="tel"
                                class="flex-1 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Phone number">
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Additional Phone</label>
                        <input type="tel"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Additional phone">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Country</label>
                        <select
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Country</option>
                            <option value="bd">Bangladesh</option>
                            <option value="in">India</option>
                            <option value="pk">Pakistan</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 mb-2">City</label>
                        <input type="text"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter city">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Address</label>
                        <input type="text"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter address">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Date of contact</label>
                        <input type="date"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Aditional Informations</label>
                    <textarea
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 h-24 resize-none"
                        placeholder="Enter additional information"></textarea>
                </div>
            </div>

            <!-- Save Button -->
            <button class="w-full bg-gray-300 text-gray-600 py-4 rounded-lg font-semibold hover:bg-gray-400 transition">
                Save Lead
            </button>
        </div>
    </div>

    <script>
        const menuBtn = document.getElementById("menuBtn");
        const sidebar = document.getElementById("sidebar");
        const header = document.getElementById("header");
        const mainContent = document.getElementById("mainContent");
        const overlay = document.getElementById("overlay");

        let sidebarOpen = false;

        function openSidebar() {
            sidebar.classList.remove("-translate-x-full");

            header.classList.add("md:left-64");
            header.classList.remove("left-0");

            mainContent.classList.add("md:ml-64");

            // Mobile overlay show
            if (window.innerWidth < 768) {
                overlay.classList.remove("hidden");
            }

            sidebarOpen = true;
        }

        function closeSidebar() {
            sidebar.classList.add("-translate-x-full");

            header.classList.remove("md:left-64");
            header.classList.add("left-0");

            mainContent.classList.remove("md:ml-64");

            // Hide overlay
            overlay.classList.add("hidden");

            sidebarOpen = false;
        }

        // Initial state
        if (window.innerWidth >= 768) {
            openSidebar();
        } else {
            closeSidebar();
        }

        // Menu button toggle
        menuBtn.addEventListener("click", () => {
            sidebarOpen ? closeSidebar() : openSidebar();
        });

        // Overlay click → close sidebar (MOBILE)
        overlay.addEventListener("click", closeSidebar);

        // Handle resize
        window.addEventListener("resize", () => {
            if (window.innerWidth >= 768) {
                overlay.classList.add("hidden");
                openSidebar();
            } else {
                closeSidebar();
            }
        });


        // drop down for user 
        const userMenuBtn = document.getElementById("userMenuBtn");
        const userDropdown = document.getElementById("userDropdown");

        userMenuBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            userDropdown.classList.toggle("hidden");
        });

        // Click outside → close dropdown
        document.addEventListener("click", (e) => {
            if (!userDropdown.contains(e.target)) {
                userDropdown.classList.add("hidden");
            }
        });

        // revinew dropdown 
        const revenueBtn = document.getElementById("revenueBtn");
        const revenueDropdown = document.getElementById("revenueDropdown");
        const revenueArrow = document.getElementById("revenueArrow");

        let isRevenueOpen = false;

        revenueBtn.addEventListener("click", () => {
            isRevenueOpen = !isRevenueOpen;

            if (isRevenueOpen) {
                revenueDropdown.style.maxHeight = revenueDropdown.scrollHeight + "px";
                revenueArrow.classList.add("rotate-90");
            } else {
                revenueDropdown.style.maxHeight = "0";
                revenueArrow.classList.remove("rotate-90");
            }
        });


        // new lead sizebar
        const openLeadFormBtn = document.getElementById('openSidebar');
        const closeLeadFormBtn = document.getElementById('closeLeadFormBtn');
        const leadFormSidebar = document.getElementById('leadFormSidebar');
        const leadFormOverlay = document.getElementById('leadFormOverlay');

        // Open sidebar
        openLeadFormBtn.addEventListener('click', () => {
            leadFormSidebar.classList.remove('translate-x-full');
            leadFormOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            setTimeout(() => {
                leadFormOverlay.classList.add('opacity-100');
            }, 10);
        });

        // Close sidebar function
        function closeLeadFormSidebar() {
            leadFormSidebar.classList.add('translate-x-full');
            leadFormOverlay.classList.remove('opacity-100');
            document.body.style.overflow = 'auto';

            setTimeout(() => {
                leadFormOverlay.classList.add('hidden');
            }, 300);
        }

        // Close button click
        closeLeadFormBtn.addEventListener('click', closeLeadFormSidebar);

        // Overlay click
        leadFormOverlay.addEventListener('click', closeLeadFormSidebar);

        // Escape key press
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !leadFormOverlay.classList.contains('hidden')) {
                closeLeadFormSidebar();
            }
        });
    </script>

    {{-- Topbar Date Time --}}
    <script>
        function updateDateTime() {
            const now = new Date();

            const optionsDate = {
                weekday: 'short',
                day: 'numeric',
                month: 'long'
            };

            const date = now.toLocaleDateString('en-US', optionsDate);
            const time = now.toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            });

            document.getElementById('currentDate').innerText = date;
            document.getElementById('currentTime').innerText = time;
        }

        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>

    {{-- Topbar Date Time --}}






    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    </script>
    @endif

    @if (session('error'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    </script>
    @endif

    @if ($errors->any())
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'warning',
            title: "{{ $errors->first() }}",
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
        });
    </script>
    @endif




    @yield('js')

</body>

</html>
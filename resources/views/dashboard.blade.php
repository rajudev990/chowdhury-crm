@extends('layouts.app')

@section('title','Dashboard')

@section('content')
<h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">
    Welcome to Dashboard
</h2>
<p class="text-gray-600">
    This is your main content area. The sidebar will toggle smoothly on both
    desktop and mobile devices.
</p>

<div class="max-w-full mx-auto bg-white rounded-lg shadow-sm my-4">
    <!-- Top Action Bar -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between bg-white p-4 rounded-xl shadow-sm">

        <!-- Search Box -->
        <div class="relative w-full md:w-64">
            <input type="text" placeholder="Search in table..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg
      focus:outline-none focus:ring-2 focus:ring-[#1A3A66]/30 focus:border-[#1A3A66]" />
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-3">

            <button class="flex items-center gap-2 px-4 py-2 border rounded-lg text-[#1A3A66]
      border-[#1A3A66] hover:bg-[#1A3A66] hover:text-white transition">
                <i class="fas fa-chart-line"></i>
                Summary
            </button>

            <button class="flex items-center gap-2 px-4 py-2 border rounded-lg text-[#1A3A66]
      border-[#1A3A66] hover:bg-[#1A3A66] hover:text-white transition">
                <i class="fas fa-filter"></i>
                Advanced Filters
            </button>

            <button class="flex items-center gap-2 px-4 py-2 border rounded-lg text-[#1A3A66]
      border-[#1A3A66] hover:bg-[#1A3A66] hover:text-white transition">
                <i class="fas fa-download"></i>
                Export
            </button>

            <button class="flex items-center gap-2 px-4 py-2 border rounded-lg text-[#1A3A66]
      border-[#1A3A66] hover:bg-[#1A3A66] hover:text-white transition">
                <i class="fas fa-upload"></i>
                Import
            </button>

            <!-- Open Button -->
            <button
                class="flex items-center gap-2 px-4 py-2 rounded-lg bg-[#1A3A66] text-white hover:bg-[#163258] transition shadow-md"
                id="openSidebar">
                <i class="fas fa-plus"></i>
                New Lead
            </button>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="p-4 border-b border-gray-200">
        <div class="flex flex-wrap gap-3 items-center justify-between">
            <!-- Filter Dropdowns -->
            <div class="flex flex-wrap gap-3 flex-1">
                <div class="relative">
                    <select
                        class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2.5 pr-10 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent min-w-[150px]">
                        <option>Statuses</option>
                        <option>Active</option>
                        <option>Pending</option>
                        <option>Completed</option>
                    </select>
                    <i
                        class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                </div>

                <div class="relative">
                    <select
                        class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2.5 pr-10 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent min-w-[150px]">
                        <option>Sources</option>
                        <option>Facebook</option>
                        <option>Google</option>
                        <option>Direct</option>
                    </select>
                    <i
                        class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                </div>

                <div class="relative">
                    <select
                        class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2.5 pr-10 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent min-w-[150px]">
                        <option>Assignees</option>
                        <option>John Doe</option>
                        <option>Jane Smith</option>
                        <option>Mike Johnson</option>
                    </select>
                    <i
                        class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                </div>

                <div class="relative">
                    <button
                        class="bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent min-w-[180px] text-left flex items-center justify-between">
                        <span>Followup Date</span>
                        <i class="fas fa-calendar text-gray-400"></i>
                    </button>
                </div>

                <div class="relative">
                    <button
                        class="bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent min-w-[180px] text-left flex items-center justify-between">
                        <span>Appointment Date</span>
                        <i class="fas fa-calendar text-gray-400"></i>
                    </button>
                </div>
            </div>

            <!-- Filter and Reset Buttons -->
            <div class="flex gap-2">
                <button
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-6 py-2.5 rounded-lg transition-colors">
                    Filter
                </button>
                <button class="text-gray-500 hover:text-gray-700 font-medium px-4 py-2.5 transition-colors">
                    Reset Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Table Container with Horizontal Scroll -->
    <div class="overflow-x-auto">
        <table class="w-full min-w-max">
            <!-- Table Header -->
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left">
                        <input type="checkbox"
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    </th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">Name
                    </th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">Phone
                    </th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">Email
                    </th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">
                        Assigned</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">
                        Followup Date</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">
                        Appointment Date</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">Notes
                    </th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">
                        Preferred Countries</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">Source
                    </th>
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody class="divide-y divide-gray-200">
                <!-- Row 1 -->
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-4">
                        <input type="checkbox"
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap">qew</td>
                    <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap">+8801613402669</td>
                    <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap">vpcuwr@live.com</td>
                    <td class="px-4 py-4">
                        <div
                            class="flex items-center justify-center w-8 h-8 bg-gray-400 rounded-full text-white text-sm font-medium">
                            t
                        </div>
                    </td>
                    <td class="px-4 py-4 text-center">
                        <button class="text-gray-400 hover:text-gray-600">
                            <i class="far fa-calendar text-xl"></i>
                        </button>
                    </td>
                    <td class="px-4 py-4 text-center">
                        <button class="text-gray-400 hover:text-gray-600">
                            <i class="far fa-calendar text-xl"></i>
                        </button>
                    </td>
                    <td class="px-4 py-4 text-center">
                        <button class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-pencil text-lg"></i>
                        </button>
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap">United Kingdom</td>
                    <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap">Facebook</td>
                </tr>

                <!-- Row 2 -->
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-4">
                        <input type="checkbox"
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap">afw</td>
                    <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap">+8801324499540</td>
                    <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap">smdft@ymail.com</td>
                    <td class="px-4 py-4">
                        <div
                            class="flex items-center justify-center w-8 h-8 bg-gray-400 rounded-full text-white text-sm font-medium">
                            t
                        </div>
                    </td>
                    <td class="px-4 py-4 text-center">
                        <button class="text-gray-400 hover:text-gray-600">
                            <i class="far fa-calendar text-xl"></i>
                        </button>
                    </td>
                    <td class="px-4 py-4 text-center">
                        <button class="text-gray-400 hover:text-gray-600">
                            <i class="far fa-calendar text-xl"></i>
                        </button>
                    </td>
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-900">test1</span>
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-pencil text-sm"></i>
                            </button>
                        </div>
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap">United Kingdom</td>
                    <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap">Facebook</td>
                </tr>

                <!-- Row 3 -->
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-4">
                        <input type="checkbox"
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap">fasf</td>
                    <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap">+8801744797648</td>
                    <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap">leqzmn@protonmail.com</td>
                    <td class="px-4 py-4">
                        <div
                            class="flex items-center justify-center w-8 h-8 bg-gray-400 rounded-full text-white text-sm font-medium">
                            t
                        </div>
                    </td>
                    <td class="px-4 py-4 text-center">
                        <button class="text-gray-400 hover:text-gray-600">
                            <i class="far fa-calendar text-xl"></i>
                        </button>
                    </td>
                    <td class="px-4 py-4 text-center">
                        <button class="text-gray-400 hover:text-gray-600">
                            <i class="far fa-calendar text-xl"></i>
                        </button>
                    </td>
                    <td class="px-4 py-4 text-center">
                        <button class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-pencil text-lg"></i>
                        </button>
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap">United Kingdom</td>
                    <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap">Facebook</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
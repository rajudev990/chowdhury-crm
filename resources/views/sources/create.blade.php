@extends('layouts.app')

@section('content')

<!-- Overlay -->
<div id="statusOverlay"
    class="fixed inset-0 bg-black/40 z-40 hidden"
    onclick="closeStatusSidebar()"></div>

<!-- Sidebar -->
<div id="statusSidebar"
    class="fixed top-0 right-0 h-full w-full sm:w-[420px] bg-white z-50
            transform translate-x-full transition-transform duration-300">

    <!-- Header -->
    <div class="flex items-center gap-3 px-5 py-4 bg-[#1A3A66] text-white">
        <button onclick="closeStatusSidebar()">
            ←
        </button>
        <h2 class="text-lg font-semibold">New Project Status</h2>
    </div>

    <!-- Form -->
    <div class="p-5 space-y-4">

        <!-- Name -->
        <input type="text"
            placeholder="Name"
            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#1A3A66]" />

        <!-- SMS -->
        <textarea rows="5"
            placeholder="SMS"
            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#1A3A66]"></textarea>

        <!-- Checkbox -->
        <label class="flex items-center gap-2 text-gray-700">
            <input type="checkbox" class="w-4 h-4 accent-[#1A3A66]">
            Send SMS?
        </label>

        <!-- Add Button -->
        <button
            class="w-full flex items-center justify-center gap-2 py-2 mt-4
                   bg-gray-300 text-gray-600 rounded-lg cursor-not-allowed">
            +
            Add
        </button>

    </div>
</div>


@endsection
@extends('layouts.app')
@section('title','Leads Details')

@section('content')
<div class="container mx-auto">
    <!-- Form Heading -->
    <div class="bg-[#1A3A66] text-white p-4 rounded-t-lg">
        <h2 class="text-2xl font-semibold">Lead Details #{{ $lead->id }}</h2>
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-200 bg-white rounded-b-lg">
        <ul class="flex -mb-px" id="tabs">
            <li class="mr-1">
                <a href="#" data-tab="profile" class="tab-link inline-block py-2 px-4 text-blue-600 font-semibold border-b-2 border-transparent hover:border-blue-500">Profile</a>
            </li>
            <li class="mr-1">
                <a href="#" data-tab="attachment" class="tab-link inline-block py-2 px-4 text-gray-600 border-b-2 border-transparent hover:border-blue-500">Attachment</a>
            </li>
            <li class="mr-1">
                <a href="#" data-tab="note" class="tab-link inline-block py-2 px-4 text-gray-600 border-b-2 border-transparent hover:border-blue-500">Note</a>
            </li>
            <li class="mr-1">
                <a href="#" data-tab="task" class="tab-link inline-block py-2 px-4 text-gray-600 border-b-2 border-transparent hover:border-blue-500">Task</a>
            </li>
            <li class="mr-1">
                <a href="#" data-tab="email" class="tab-link inline-block py-2 px-4 text-gray-600 border-b-2 border-transparent hover:border-blue-500">Email</a>
            </li>
        </ul>
    </div>

    <!-- Tab Contents -->
    <div class="p-6 bg-white rounded-b-lg mt-2">
        <div id="profile" class="tab-content">
            <h3 class="text-lg font-semibold text-[#4A5F7F] mb-4">Profile Information</h3>
            <!-- Include your profile form here -->
        </div>

        <div id="attachment" class="tab-content hidden">
            <h3 class="text-lg font-semibold text-[#4A5F7F] mb-4">Attachments</h3>
            <!-- Attachment content here -->
        </div>

        <div id="note" class="tab-content hidden">
            <h3 class="text-lg font-semibold text-[#4A5F7F] mb-4">Notes</h3>
            <!-- Note content here -->
        </div>

        <div id="task" class="tab-content hidden">
            <h3 class="text-lg font-semibold text-[#4A5F7F] mb-4">Tasks</h3>
            <!-- Task content here -->
        </div>

        <div id="email" class="tab-content hidden">
            <h3 class="text-lg font-semibold text-[#4A5F7F] mb-4">Emails</h3>
            <!-- Email content here -->
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    const tabs = document.querySelectorAll('.tab-link');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', function(e){
            e.preventDefault();

            // Remove active styles from all tabs
            tabs.forEach(t => {
                t.classList.remove('text-blue-600', 'border-blue-600');
                t.classList.add('text-gray-600', 'border-transparent');
            });

            // Hide all tab contents
            contents.forEach(c => c.classList.add('hidden'));

            // Activate clicked tab
            this.classList.add('text-blue-600', 'border-blue-600');
            this.classList.remove('text-gray-600', 'border-transparent');

            // Show corresponding content
            const tabId = this.getAttribute('data-tab');
            document.getElementById(tabId).classList.remove('hidden');
        });
    });

    // Activate first tab by default
    if(tabs.length > 0){
        tabs[0].click();
    }
</script>
@endsection

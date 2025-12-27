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
                <a href="#" data-tab="profile" class="tab-link inline-block py-2 px-4 text-blue-600 font-semibold border-b-2 border-blue-600">Profile</a>
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
            <!-- Personal Information Section -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
                <!-- Header with Buttons -->
                <div class="flex justify-between items-center p-6 border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-800">Personal Information</h3>
                    <div class="flex gap-3">
                        <button class="flex items-center gap-2 bg-[#3B5998] hover:bg-[#2d4373] text-white px-5 py-2.5 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            Convert to Customer
                        </button>
                        <button class="flex items-center gap-2 bg-gray-700 hover:bg-gray-800 text-white px-5 py-2.5 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Print
                        </button>
                    </div>
                </div>

                <!-- Content Grid -->
                <div class="p-8">
                    <div class="grid grid-cols-12 gap-8">
                        <!-- Left Column - Profile Image -->
                        <div class="col-span-3 flex flex-col items-center">
                            <div class="w-44 h-44 rounded-full bg-[#3B5998] flex items-center justify-center mb-4 shadow-lg">
                                <span class="text-white text-6xl font-bold">
                                    {{ strtoupper(substr($lead->name ?? 'U', 0, 1)) }}
                                </span>
                            </div>
                            <h4 class="text-xl font-bold text-gray-800 mb-1 text-center">{{ $lead->name ?? 'N/A' }}</h4>
                            <p class="text-gray-600 text-sm text-center">{{ $lead->email ?? 'N/A' }}</p>
                        </div>

                        <!-- Middle Column -->
                        <div class="col-span-4 space-y-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Phone Number</label>
                                <p class="text-gray-800 font-medium">{{ $lead->phone ?? '–' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Additional Phone</label>
                                <p class="text-gray-800 font-medium">{{ $lead->additional_phone ?? '–' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Date of Birth</label>
                                <p class="text-gray-800 font-medium">
                                    {{ $lead->dob ? \Carbon\Carbon::parse($lead->dob)->format('M d, Y') : '–' }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Created Date</label>
                                <p class="text-gray-800 font-medium">{{ $lead->created_at ? $lead->created_at->format('M d, Y') : '–' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Date of Contact</label>
                                <p class="text-gray-800 font-medium">
                                    {{ $lead->date_of_contact ? \Carbon\Carbon::parse($lead->date_of_contact)->format('M d, Y') : '–' }}
                                </p>
                            </div>
                        </div>

                        <!-- Middle-Right Column -->
                        <div class="col-span-3 space-y-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">City</label>
                                <p class="text-gray-800 font-medium">{{ $lead->city ?? '–' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Country</label>
                                <p class="text-gray-800 font-medium">{{ $lead->country ?? '–' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Preferred Country</label>
                                <p class="text-gray-800 font-medium">{{ $lead->preferred_country ?? '–' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Address</label>
                                <p class="text-gray-800 font-medium">{{ $lead->address ?? '–' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Lead Status</label>
                                <span class="inline-block bg-blue-50 text-blue-700 px-4 py-1.5 rounded-full text-sm font-medium border border-blue-200">
                                    {{ $lead->status?->name ?? 'New' }}
                                </span>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-span-2 space-y-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Lead Source</label>
                                <p class="text-gray-800 font-medium">{{ $lead->source?->name ?? '–' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">How Did Hear About Us?</label>
                                <p class="text-gray-800 font-medium">{{ $lead->how_did_hear_about_us ?? '–' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Assigned To</label>
                                @if($lead->assignedUser)
                                    <div class="flex items-center gap-2">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center shadow-md">
                                            <span class="text-white text-sm font-bold">
                                                {{ strtoupper(substr($lead->assignedUser->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <span class="text-gray-800 font-medium text-sm">{{ $lead->assignedUser->name }}</span>
                                    </div>
                                @else
                                    <p class="text-gray-800 font-medium">–</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information Note -->
                    @if($lead->personal_information)
                        <div class="mt-8 pt-8 border-t border-gray-200">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-3">Personal Information Note</label>
                            <div class="bg-gray-50 rounded-lg p-4 text-gray-700 text-sm leading-relaxed">
                                {{ $lead->personal_information }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Additional Information Section -->
            @if($lead->additional_information)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Additional Information
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="bg-gradient-to-r from-orange-50 to-amber-50 rounded-lg p-5 border border-orange-100">
                            <p class="text-gray-700 text-sm leading-relaxed whitespace-pre-line">{{ $lead->additional_information }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Educational Qualifications Section -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Educational Qualifications
                    </h3>
                </div>
                @if($exams && count($exams) > 0)
                    <div class="p-6">
                        <div class="grid grid-cols-1 gap-4">
                            @foreach($exams as $index => $exam)
                                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg p-5 border border-purple-100">
                                    <div class="flex items-start justify-between mb-4">
                                        <div>
                                            <h4 class="text-lg font-bold text-gray-800">{{ $exam->exam_type ?? 'N/A' }}</h4>
                                            <p class="text-gray-600 font-medium text-sm">{{ $exam->institute_name ?? 'N/A' }}</p>
                                        </div>
                                        <span class="bg-purple-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                            #{{ $index + 1 }}
                                        </span>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div class="bg-white rounded-lg p-3 shadow-sm">
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Major Subject</label>
                                            <p class="text-gray-800 font-medium">{{ $exam->major_subject ?? '–' }}</p>
                                        </div>
                                        <div class="bg-white rounded-lg p-3 shadow-sm">
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Result</label>
                                            <p class="text-gray-800 font-medium">{{ $exam->result ?? '–' }}</p>
                                        </div>
                                        <div class="bg-white rounded-lg p-3 shadow-sm">
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Passing Year</label>
                                            <p class="text-gray-800 font-medium">{{ $exam->passing_year ?? '–' }}</p>
                                        </div>
                                        <div class="bg-white rounded-lg p-3 shadow-sm">
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Country</label>
                                            <p class="text-gray-800 font-medium">{{ $exam->country ?? '–' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="p-6">
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <p class="text-sm">No educational qualifications data available</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- English Language Proficiency Section -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                        </svg>
                        English Language Proficiency
                    </h3>
                </div>
                @if($englishTests && count($englishTests) > 0)
                    <div class="p-6">
                        <div class="grid grid-cols-1 gap-4">
                            @foreach($englishTests as $index => $test)
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-5 border border-blue-100">
                                    <div class="flex items-start justify-between mb-4">
                                        <h4 class="text-lg font-bold text-gray-800">Test #{{ $index + 1 }}</h4>
                                        <span class="bg-blue-600 text-white px-4 py-1.5 rounded-full text-sm font-semibold uppercase">
                                            {{ $test->test_type ?? 'N/A' }}
                                        </span>
                                    </div>

                                    @if($test->test_type == 'ielts')
                                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                                <label class="block text-xs font-semibold text-gray-600 mb-1">Overall</label>
                                                <p class="text-blue-600 font-bold text-xl">{{ $test->ielts_overall ?? '–' }}</p>
                                            </div>
                                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                                <label class="block text-xs font-semibold text-gray-600 mb-1">Listening</label>
                                                <p class="text-gray-800 font-bold text-xl">{{ $test->ielts_listening ?? '–' }}</p>
                                            </div>
                                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                                <label class="block text-xs font-semibold text-gray-600 mb-1">Reading</label>
                                                <p class="text-gray-800 font-bold text-xl">{{ $test->ielts_reading ?? '–' }}</p>
                                            </div>
                                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                                <label class="block text-xs font-semibold text-gray-600 mb-1">Writing</label>
                                                <p class="text-gray-800 font-bold text-xl">{{ $test->ielts_writing ?? '–' }}</p>
                                            </div>
                                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                                <label class="block text-xs font-semibold text-gray-600 mb-1">Speaking</label>
                                                <p class="text-gray-800 font-bold text-xl">{{ $test->ielts_speaking ?? '–' }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($test->test_type == 'pte')
                                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                                <label class="block text-xs font-semibold text-gray-600 mb-1">Overall</label>
                                                <p class="text-blue-600 font-bold text-xl">{{ $test->pte_overall ?? '–' }}</p>
                                            </div>
                                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                                <label class="block text-xs font-semibold text-gray-600 mb-1">Listening</label>
                                                <p class="text-gray-800 font-bold text-xl">{{ $test->pte_listening ?? '–' }}</p>
                                            </div>
                                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                                <label class="block text-xs font-semibold text-gray-600 mb-1">Reading</label>
                                                <p class="text-gray-800 font-bold text-xl">{{ $test->pte_reading ?? '–' }}</p>
                                            </div>
                                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                                <label class="block text-xs font-semibold text-gray-600 mb-1">Writing</label>
                                                <p class="text-gray-800 font-bold text-xl">{{ $test->pte_writing ?? '–' }}</p>
                                            </div>
                                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                                <label class="block text-xs font-semibold text-gray-600 mb-1">Speaking</label>
                                                <p class="text-gray-800 font-bold text-xl">{{ $test->pte_speaking ?? '–' }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($test->test_type == 'duolingo')
                                        <div class="flex justify-center">
                                            <div class="bg-white rounded-lg p-6 shadow-sm w-64 text-center">
                                                <label class="block text-sm font-semibold text-gray-600 mb-2">Duolingo Score</label>
                                                <p class="text-blue-600 font-bold text-xl">{{ $test->duolingo ?? '–' }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($test->test_type == 'toefl')
                                        <div class="flex justify-center">
                                            <div class="bg-white rounded-lg p-6 shadow-sm w-64 text-center">
                                                <label class="block text-sm font-semibold text-gray-600 mb-2">TOEFL Score</label>
                                                <p class="text-blue-600 font-bold text-xl">{{ $test->toefl ?? '–' }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($test->test_type == 'moi')
                                        <div class="flex justify-center">
                                            <div class="bg-white rounded-lg p-6 shadow-sm w-64 text-center">
                                                <label class="block text-sm font-semibold text-gray-600 mb-2">MOI Score</label>
                                                <p class="text-blue-600 font-bold text-xl">{{ $test->moi ?? '–' }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($test->test_type == 'oietc')
                                        <div class="flex justify-center">
                                            <div class="bg-white rounded-lg p-6 shadow-sm w-64 text-center">
                                                <label class="block text-sm font-semibold text-gray-600 mb-2">OIETC Score</label>
                                                <p class="text-blue-600 font-bold text-xl">{{ $test->oietc ?? '–' }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="p-6">
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-sm">No English language proficiency data available</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Job Experience Section -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Job Experience
                    </h3>
                </div>
                @if($jobExperiences && count($jobExperiences) > 0)
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($jobExperiences as $index => $job)
                                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-5 border border-green-100">
                                    <div class="flex items-start justify-between mb-4">
                                        <div>
                                            <h4 class="text-lg font-bold text-gray-800">{{ $job->job_title ?? 'N/A' }}</h4>
                                            <p class="text-gray-600 font-medium text-sm">{{ $job->company_name ?? 'N/A' }}</p>
                                        </div>
                                        <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                            #{{ $index + 1 }}
                                        </span>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="bg-white rounded-lg p-3 shadow-sm">
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Duration</label>
                                            <p class="text-gray-800 font-medium">{{ $job->duration ?? '–' }}</p>
                                        </div>
                                        <div class="bg-white rounded-lg p-3 shadow-sm">
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Joining Date</label>
                                            <p class="text-gray-800 font-medium">
                                                {{ $job->joining_date ? \Carbon\Carbon::parse($job->joining_date)->format('M d, Y') : '–' }}
                                            </p>
                                        </div>
                                        <div class="bg-white rounded-lg p-3 shadow-sm">
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">End Date</label>
                                            <p class="text-gray-800 font-medium">
                                                {{ $job->end_date ? \Carbon\Carbon::parse($job->end_date)->format('M d, Y') : 'Present' }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    @if($job->company_address)
                                        <div class="mt-4 bg-white rounded-lg p-3 shadow-sm">
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Company Address</label>
                                            <p class="text-gray-700 text-sm leading-relaxed">{{ $job->company_address }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="p-6">
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm">No job experience data available</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div id="attachment" class="tab-content hidden">
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Attachments</h3>
                <!-- Attachment content here -->
            </div>
        </div>

        <div id="note" class="tab-content hidden">
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Notes</h3>
                <!-- Note content here -->
            </div>
        </div>

        <div id="task" class="tab-content hidden">
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Tasks</h3>
                <!-- Task content here -->
            </div>
        </div>

        <div id="email" class="tab-content hidden">
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Emails</h3>
                <!-- Email content here -->
            </div>
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
</script>
@endsection
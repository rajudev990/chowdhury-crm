@extends('layouts.app')
@section('title','Leads Managment')

@section('css')
<style>
    /* Floating Label Styles */
    .floating-label-group {
        position: relative;
    }

    .floating-label-group input,
    .floating-label-group select,
    .floating-label-group textarea {
        width: 100%;
        padding: 1.125rem 0.75rem 0.375rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 0.95rem;
        outline: none;
        transition: all 0.2s ease;
        background: white;
    }

    .floating-label-group input:focus,
    .floating-label-group select:focus,
    .floating-label-group textarea:focus {
        border-color: #1A3A66;
        box-shadow: 0 0 0 3px rgba(26, 58, 102, 0.1);
    }

    .floating-label-group label {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.95rem;
        color: #6b7280;
        pointer-events: none;
        transition: all 0.2s ease;
        background: white;
        padding: 0 0.25rem;
        z-index: 1;
    }

    .floating-label-group textarea+label {
        top: 1.25rem;
        transform: none;
    }

    .floating-label-group input:focus+label,
    .floating-label-group input:not(:placeholder-shown)+label,
    .floating-label-group.active label,
    .floating-label-group select:focus+label,
    .floating-label-group textarea:focus+label,
    .floating-label-group textarea:not(:placeholder-shown)+label {
        top: 0;
        transform: translateY(-50%);
        font-size: 0.75rem;
        color: #1A3A66;
        font-weight: 600;
    }

    .floating-label-group label .required {
        color: #ef4444;
        margin-left: 2px;
    }

    .floating-label-group input[type="date"]:not(:focus):not(.has-value) {
        color: transparent;
    }

    .floating-label-group input[type="date"]:focus,
    .floating-label-group input[type="date"].has-value {
        color: inherit;
    }

    .floating-label-group input:disabled,
    .floating-label-group select:disabled,
    .floating-label-group textarea:disabled {
        background-color: #f9fafb;
        cursor: not-allowed;
        opacity: 0.6;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="p-4 bg-white rounded-xl shadow-md">

                <!-- Success/Error Messages -->
                @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
                @endif

                <!-- Button -->
                <div class="flex justify-end mb-6">
                    <button type="button" onclick="openStatusSidebar()"
                        class="inline-flex items-center gap-2 px-5 py-2 border border-[#1A3A66] text-[#1A3A66] rounded-lg hover:bg-[#1A3A66] hover:text-white transition duration-300">
                        <span class="text-xl">+</span>
                        New Leads
                    </button>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-50">
                            <tr class="text-sm font-semibold text-gray-700">
                                <th class="px-6 py-4 text-left">#</th>
                                <th class="px-6 py-4 text-left">Name</th>
                                <th class="px-6 py-4 text-left">Email</th>
                                <th class="px-6 py-4 text-left">Phone</th>
                                <th class="px-6 py-4 text-left">Assigned</th>
                                <th class="px-6 py-4 text-left">Date of Contact</th>
                                <th class="px-6 py-4 text-left">Preferred Country</th>
                                <th class="px-6 py-4 text-left">Source</th>
                                <th class="px-6 py-4 text-left">Status</th>
                                <th class="px-6 py-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y text-sm text-gray-700">
                            @forelse($data as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">{{ $item->name }}</td>
                                <td class="px-6 py-4">{{ $item->email }}</td>
                                <td class="px-6 py-4">{{ $item->phone ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $item->assigned?->name ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $item->date_of_contact ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if($item->preferred_country)
                                    {{ $country->firstWhere('id', $item->preferred_country)?->name ?? '-' }}
                                    @else
                                    -
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $item->source?->name ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $item->status?->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-1">
                                        <button onclick="openEditSidebar({{ $item->id }})"
                                            class="w-8 h-8 flex items-center justify-center text-[#9CA3AF] rounded-full hover:text-[#1A3A66] transition"
                                            title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <form action="{{ route('leads.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this lead?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-full hover:text-[#1A3A66] text-[#9CA3AF] transition"
                                                title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="px-6 py-8 text-center text-gray-500">
                                    No leads found. Click "New Leads" to add one.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Overlay -->
                <div id="statusOverlay" class="fixed inset-0 bg-black/40 z-40 hidden"
                    onclick="closeStatusSidebar()"></div>

                <!-- Right Sidebar -->
                <div id="statusSidebar"
                    class="fixed top-0 right-0 h-full w-full sm:w-[850px] bg-white z-50 transform translate-x-full transition-transform duration-300 overflow-y-auto">

                    <!-- Header -->
                    <div class="flex items-center gap-3 px-5 py-4 bg-[#1A3A66] text-white">
                        <button type="button" onclick="closeStatusSidebar()">←</button>
                        <h2 class="text-lg font-semibold" id="sidebarTitle">Add Lead Managment</h2>
                    </div>

                    <!-- Form -->
                    <form id="userForm" method="POST" action="{{ route('leads.store') }}" class="p-6 space-y-6">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">

                        <!-- Validation Errors -->
                        <div id="validationError"
                            class="hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                            <ul id="errorList" class="list-disc list-inside text-sm"></ul>
                        </div>

                        <!-- Basic Info Section -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="floating-label-group">
                                <select id="userStatusId" name="status_id" required>
                                    <option value=""></option>
                                    @foreach($status as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                                <label>Status <span class="required">*</span></label>
                            </div>
                            <div class="floating-label-group">
                                <select id="userSourceId" name="source_id" required>
                                    <option value=""></option>
                                    @foreach($source as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                                <label>Source <span class="required">*</span></label>
                            </div>
                            <div class="floating-label-group">
                                <select id="userAssignedId" name="assigned_id">
                                    <option value=""></option>
                                    <option value="1">Admin</option>
                                    <option value="2">user</option>

                                </select>
                                <label>Assigned <span class="required">*</span></label>
                            </div>
                        </div>

                        <div class="floating-label-group">
                            <input type="text" id="userHowDidHear" name="how_did_hear_about_us" placeholder=" ">
                            <label>How did hear about us?</label>
                        </div>

                        <!-- Personal Information -->
                        <h3 class="text-lg font-semibold text-[#1A3A66] border-b pb-2 mt-6">Personal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="floating-label-group">
                                <input type="text" id="userName" name="name" required placeholder=" ">
                                <label>Name <span class="required">*</span></label>
                            </div>
                            <div class="floating-label-group">
                                <input type="date" id="userDob" name="dob" placeholder=" ">
                                <label>Date of Birth</label>
                            </div>
                            <div class="floating-label-group">
                                <input type="email" id="userEmail" name="email" required placeholder=" ">
                                <label>E-mail <span class="required">*</span></label>
                            </div>
                            <div class="floating-label-group">
                                <input type="text" id="userPhone" name="phone" required placeholder=" ">
                                <label>Phone <span class="required">*</span></label>
                            </div>
                            <div class="floating-label-group">
                                <input type="text" id="userAdditionalPhone" name="additional_phone" placeholder=" ">
                                <label>Additional Phone</label>
                            </div>
                            <div class="floating-label-group">
                                <select id="userCountry" name="country">
                                    <option value=""></option>
                                    @foreach($country as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                                <label>Country</label>
                            </div>
                            <div class="floating-label-group">
                                <input type="text" id="userCity" name="city" placeholder=" ">
                                <label>City</label>
                            </div>
                            <div class="floating-label-group md:col-span-2">
                                <input type="text" id="userAddress" name="address" placeholder=" ">
                                <label>Address</label>
                            </div>
                            <div class="floating-label-group">
                                <input type="date" id="userDateOfContact" name="date_of_contact" placeholder=" ">
                                <label>Date of Contact</label>
                            </div>
                        </div>

                        <div class="floating-label-group">
                            <textarea id="userPersonalInformation" name="personal_information" rows="3"
                                placeholder=" "></textarea>
                            <label>Personal Information</label>
                        </div>
                        <div class="floating-label-group">
                            <textarea id="userAdditionalInformation" name="additional_information" rows="3"
                                placeholder=" "></textarea>
                            <label>Additional Information</label>
                        </div>

                        <!-- Job Experience Section -->
                        <div class="border-t pt-6 mt-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-[#1A3A66]">Job Experience</h3>
                                <label
                                    class="flex items-center cursor-pointer bg-gray-50 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                                    <input type="checkbox" id="toggleJobExperience" class="mr-2 w-4 h-4 accent-[#1A3A66]">
                                    <span class="text-sm font-medium text-gray-700">Add Job Experience</span>
                                </label>
                            </div>
                            <div id="jobExperienceSection" class="hidden space-y-4">
                                <div id="jobExperienceContainer" class="space-y-4"></div>
                                <button type="button" onclick="addJobExperience()"
                                    class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition text-sm font-medium shadow-sm">
                                    <i class="fa-solid fa-plus mr-1"></i> Add More Experience
                                </button>
                            </div>
                        </div>

                        <!-- English Language Section -->
                        <div class="border-t pt-6 mt-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-[#1A3A66]">English Language Test</h3>
                                <label
                                    class="flex items-center cursor-pointer bg-gray-50 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                                    <input type="checkbox" id="toggleEnglishLanguage" class="mr-2 w-4 h-4 accent-[#1A3A66]">
                                    <span class="text-sm font-medium text-gray-700">Add English Test</span>
                                </label>
                            </div>
                            <div id="englishLanguageSection" class="hidden">
                                <div id="englishTestsContainer" class="space-y-4"></div>
                                <button type="button" onclick="addEnglishTest()"
                                    class="mt-4 px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition text-sm font-medium shadow-sm">
                                    <i class="fa-solid fa-plus mr-1"></i> Add More Test
                                </button>
                            </div>
                        </div>

                        <!-- Educational Information Section -->
                        <div class="border-t pt-6 mt-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-[#1A3A66]">Educational Information</h3>
                                <label
                                    class="flex items-center cursor-pointer bg-gray-50 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                                    <input type="checkbox" id="toggleEducation" class="mr-2 w-4 h-4 accent-[#1A3A66]">
                                    <span class="text-sm font-medium text-gray-700">Add Education</span>
                                </label>
                            </div>
                            <div id="educationSection" class="hidden">
                                <div id="educationContainer" class="space-y-4"></div>
                                <button type="button" onclick="addEducation()"
                                    class="mt-4 px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition text-sm font-medium shadow-sm">
                                    <i class="fa-solid fa-plus mr-1"></i> Add More Education
                                </button>
                            </div>
                        </div>

                        <!-- Preferred Countries -->
                        <div class="border-t pt-6 mt-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-[#1A3A66]">Preferred Country</h3>
                            </div>
                            <div class="floating-label-group">
                                <select id="userPreferredCountry" name="preferred_country">
                                    <option value=""></option>
                                    @foreach($country as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                                <label>Preferred Country</label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="sticky bottom-0 bg-white pt-6 border-t mt-6">
                            <button type="submit" id="submitBtn"
                                class="w-full py-3.5 text-lg font-semibold bg-[#1A3A66] text-white rounded-lg hover:bg-[#163158] transition shadow-lg">
                                <i class="fa-solid fa-save mr-2"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<script>
    let jobExperienceCount = 0;
    let educationCount = 0;
    let englishTestCount = 0;

    // Initialize floating labels
    function initFloatingLabels() {
        document.querySelectorAll('.floating-label-group select, .floating-label-group input, .floating-label-group textarea').forEach(element => {
            if (element.value && element.value !== '') {
                element.parentElement.classList.add('active');
            }

            element.addEventListener('change', function() {
                if (this.value && this.value !== '') {
                    this.parentElement.classList.add('active');
                } else {
                    this.parentElement.classList.remove('active');
                }
            });

            // Handle date inputs
            if (element.type === 'date') {
                if (element.value) {
                    element.classList.add('has-value');
                    element.parentElement.classList.add('active');
                }

                element.addEventListener('change', function() {
                    if (this.value) {
                        this.classList.add('has-value');
                        this.parentElement.classList.add('active');
                    } else {
                        this.classList.remove('has-value');
                        this.parentElement.classList.remove('active');
                    }
                });
            }
        });
    }

    // Call on page load
    document.addEventListener('DOMContentLoaded', initFloatingLabels);

    // Toggle sections
    document.getElementById('toggleJobExperience')?.addEventListener('change', function() {
        const section = document.getElementById('jobExperienceSection');
        if (this.checked) {
            section.classList.remove('hidden');
            if (jobExperienceCount === 0) addJobExperience();
        } else {
            section.classList.add('hidden');
            document.getElementById('jobExperienceContainer').innerHTML = '';
            jobExperienceCount = 0;
        }
    });

    document.getElementById('toggleEnglishLanguage')?.addEventListener('change', function() {
        const section = document.getElementById('englishLanguageSection');
        if (this.checked) {
            section.classList.remove('hidden');
            if (englishTestCount === 0) addEnglishTest();
        } else {
            section.classList.add('hidden');
            document.getElementById('englishTestsContainer').innerHTML = '';
            englishTestCount = 0;
        }
    });

    document.getElementById('toggleEducation')?.addEventListener('change', function() {
        const section = document.getElementById('educationSection');
        if (this.checked) {
            section.classList.remove('hidden');
            if (educationCount === 0) addEducation();
        } else {
            section.classList.add('hidden');
            document.getElementById('educationContainer').innerHTML = '';
            educationCount = 0;
        }
    });

    // Add Job Experience
    function addJobExperience() {
        const container = document.getElementById('jobExperienceContainer');
        const html = `
    <div class="job-experience-item border-2 border-gray-200 rounded-lg p-4 relative bg-gray-50">
        <button type="button" onclick="this.parentElement.remove(); jobExperienceCount--;" 
            class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center bg-red-100 text-red-600 rounded-full hover:bg-red-600 hover:text-white transition">
            <i class="fa-solid fa-times"></i>
        </button>
        <h5 class="font-semibold text-gray-700 mb-3 flex items-center">
            <i class="fa-solid fa-briefcase mr-2 text-[#1A3A66]"></i> Experience #${jobExperienceCount + 1}
        </h5>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="floating-label-group">
                <input type="text" name="job_experiences[${jobExperienceCount}][company_name]" placeholder=" ">
                <label>Company Name</label>
            </div>
            <div class="floating-label-group">
                <input type="text" name="job_experiences[${jobExperienceCount}][job_title]" placeholder=" ">
                <label>Job Title</label>
            </div>
            <div class="floating-label-group">
                <input type="text" name="job_experiences[${jobExperienceCount}][duration]" placeholder=" ">
                <label>Duration (e.g. 2 years)</label>
            </div>
            <div class="floating-label-group">
                <input type="date" name="job_experiences[${jobExperienceCount}][joining_date]" placeholder=" ">
                <label>Joining Date</label>
            </div>
            <div class="floating-label-group">
                <input type="date" name="job_experiences[${jobExperienceCount}][end_date]" placeholder=" ">
                <label>End Date</label>
            </div>
            <div class="floating-label-group md:col-span-2">
                <textarea name="job_experiences[${jobExperienceCount}][company_address]" rows="2" placeholder=" "></textarea>
                <label>Company Address</label>
            </div>
        </div>
    </div>`;
        container.insertAdjacentHTML('beforeend', html);
        jobExperienceCount++;
        setTimeout(initFloatingLabels, 100);
    }

    // Add English Test
    function addEnglishTest() {
        const container = document.getElementById('englishTestsContainer');
        const index = englishTestCount;
        const html = `
    <div class="english-test-item border-2 border-blue-200 rounded-lg p-4 relative bg-blue-50">
        <button type="button" onclick="this.parentElement.remove(); englishTestCount--;" 
            class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center bg-red-100 text-red-600 rounded-full hover:bg-red-600 hover:text-white transition">
            <i class="fa-solid fa-times"></i>
        </button>
        <h5 class="font-semibold text-gray-700 mb-3 flex items-center">
            <i class="fa-solid fa-graduation-cap mr-2 text-blue-600"></i> English Test #${index + 1}
        </h5>
        
        <div class="mb-4 floating-label-group">
            <select id="englishTestType_${index}" onchange="toggleEnglishTestFields(${index}, this.value)">
                <option value=""></option>
                <option value="ielts">IELTS</option>
                <option value="pte">PTE</option>
                <option value="toefl">TOEFL</option>
                <option value="duolingo">Duolingo</option>
                <option value="other">Other (MOI/OIETC)</option>
            </select>
            <label>Select Test Type</label>
        </div>

        <div id="ieltsFields_${index}" class="hidden">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div class="floating-label-group">
                    <input type="text" name="english_language[${index}][ielts_overall]" placeholder=" ">
                    <label>Overall Band</label>
                </div>
                <div class="floating-label-group">
                    <input type="text" name="english_language[${index}][ielts_listening]" placeholder=" ">
                    <label>Listening</label>
                </div>
                <div class="floating-label-group">
                    <input type="text" name="english_language[${index}][ielts_reading]" placeholder=" ">
                    <label>Reading</label>
                </div>
                <div class="floating-label-group">
                    <input type="text" name="english_language[${index}][ielts_writing]" placeholder=" ">
                    <label>Writing</label>
                </div>
                <div class="floating-label-group">
                    <input type="text" name="english_language[${index}][ielts_speaking]" placeholder=" ">
                    <label>Speaking</label>
                </div>
            </div>
        </div>

        <div id="pteFields_${index}" class="hidden">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div class="floating-label-group">
                    <input type="text" name="english_language[${index}][pte_overall]" placeholder=" ">
                    <label>Overall Score</label>
                </div>
                <div class="floating-label-group">
                    <input type="text" name="english_language[${index}][pte_listening]" placeholder=" ">
                    <label>Listening</label>
                </div>
                <div class="floating-label-group">
                    <input type="text" name="english_language[${index}][pte_reading]" placeholder=" ">
                    <label>Reading</label>
                </div>
                <div class="floating-label-group">
                    <input type="text" name="english_language[${index}][pte_writing]" placeholder=" ">
                    <label>Writing</label>
                </div>
                <div class="floating-label-group">
                    <input type="text" name="english_language[${index}][pte_speaking]" placeholder=" ">
                    <label>Speaking</label>
                </div>
            </div>
        </div>

        <div id="toeflFields_${index}" class="hidden">
            <div class="floating-label-group">
                <input type="text" name="english_language[${index}][toefl]" placeholder=" ">
                <label>Total Score (0-120)</label>
            </div>
        </div>

        <div id="duolingoFields_${index}" class="hidden">
            <div class="floating-label-group">
                <input type="text" name="english_language[${index}][duolingo]" placeholder=" ">
                <label>Overall Score (10-160)</label>
            </div>
        </div>

        <div id="otherFields_${index}" class="hidden">
            <div class="grid grid-cols-2 gap-4">
                <div class="floating-label-group">
                    <input type="text" name="english_language[${index}][moi]" placeholder=" ">
                    <label>MOI (Medium of Instruction)</label>
                </div>
                <div class="floating-label-group">
                    <input type="text" name="english_language[${index}][oietc]" placeholder=" ">
                    <label>OIETC</label>
                </div>
            </div>
        </div>
    </div>`;
        
        container.insertAdjacentHTML('beforeend', html);
        englishTestCount++;
        setTimeout(initFloatingLabels, 100);
    }

    function toggleEnglishTestFields(index, testType) {
        document.querySelectorAll(`#ieltsFields_${index}, #pteFields_${index}, #toeflFields_${index}, #duolingoFields_${index}, #otherFields_${index}`).forEach(el => {
            el.classList.add('hidden');
        });

        if (testType === 'ielts') document.getElementById(`ieltsFields_${index}`).classList.remove('hidden');
        if (testType === 'pte') document.getElementById(`pteFields_${index}`).classList.remove('hidden');
        if (testType === 'toefl') document.getElementById(`toeflFields_${index}`).classList.remove('hidden');
        if (testType === 'duolingo') document.getElementById(`duolingoFields_${index}`).classList.remove('hidden');
        if (testType === 'other') document.getElementById(`otherFields_${index}`).classList.remove('hidden');

        setTimeout(initFloatingLabels, 100);
    }

    // Add Education
    function addEducation() {
        const container = document.getElementById('educationContainer');
        const index = educationCount;
        
        // Get countries from blade variable
        const countries = @json($country);
        
        let countryOptions = '<option value="">Select Country</option>';
        countries.forEach(country => {
            countryOptions += `<option value="${country.id}">${country.name}</option>`;
        });
        
        const html = `
    <div class="education-item border-2 border-indigo-200 rounded-lg p-4 relative bg-indigo-50">
        <button type="button" onclick="this.parentElement.remove(); educationCount--;" 
            class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center bg-red-100 text-red-600 rounded-full hover:bg-red-600 hover:text-white transition">
            <i class="fa-solid fa-times"></i>
        </button>
        <h5 class="font-semibold text-gray-700 mb-3 flex items-center">
            <i class="fa-solid fa-graduation-cap mr-2 text-indigo-600"></i> Education #${index + 1}
        </h5>
        
        <div class="mb-4 floating-label-group">
            <select id="educationExamType_${index}" onchange="toggleEducationFields(${index}, this.value)">
                <option value=""></option>
                <option value="SSC">SSC / O Level</option>
                <option value="HSC">HSC / A Level</option>
                <option value="Bachelor">Bachelor / Undergraduate</option>
                <option value="Master">Master / Postgraduate</option>
                <option value="Diploma">Diploma</option>
                <option value="PhD">PhD / Doctorate</option>
            </select>
            <label>Select Education Level</label>
        </div>

        <div id="educationFields_${index}" class="hidden">
            <input type="hidden" name="exam_types[${index}][exam_type]" id="examTypeValue_${index}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="floating-label-group">
                    <input type="text" name="exam_types[${index}][institute_name]" placeholder=" ">
                    <label>Institute Name</label>
                </div>
                <div class="floating-label-group">
                    <input type="text" name="exam_types[${index}][major_subject]" placeholder=" ">
                    <label>Major Subject / Group</label>
                </div>
                <div class="floating-label-group">
                    <input type="text" name="exam_types[${index}][result]" placeholder=" ">
                    <label>Result (CGPA/Grade)</label>
                </div>
                <div class="floating-label-group">
                    <input type="text" name="exam_types[${index}][passing_year]" placeholder=" ">
                    <label>Passing Year</label>
                </div>
                <div class="floating-label-group">
                    <select name="exam_types[${index}][country]">
                        ${countryOptions}
                    </select>
                    <label>Country</label>
                </div>
            </div>
        </div>
    </div>`;
        
        container.insertAdjacentHTML('beforeend', html);
        educationCount++;
        setTimeout(initFloatingLabels, 100);
    }

    function toggleEducationFields(index, examType) {
        const fieldsDiv = document.getElementById(`educationFields_${index}`);
        const examTypeValue = document.getElementById(`examTypeValue_${index}`);
        
        if (examType) {
            fieldsDiv.classList.remove('hidden');
            examTypeValue.value = examType;
        } else {
            fieldsDiv.classList.add('hidden');
            examTypeValue.value = '';
        }
        
        setTimeout(initFloatingLabels, 100);
    }

    function openStatusSidebar() {
        document.getElementById('statusOverlay').classList.remove('hidden');
        document.getElementById('statusSidebar').classList.remove('translate-x-full');
        document.getElementById('sidebarTitle').textContent = 'Add Lead';
        document.getElementById('userForm').action = '{{ route("leads.store") }}';
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('submitBtn').innerHTML = '<i class="fa-solid fa-save mr-2"></i> Submit';

        // Reset form
        document.getElementById('userForm').reset();
        document.getElementById('validationError').classList.add('hidden');

        // Reset all floating labels
        document.querySelectorAll('.floating-label-group').forEach(group => {
            group.classList.remove('active');
        });

        // Reset dynamic sections
        document.getElementById('jobExperienceSection').classList.add('hidden');
        document.getElementById('englishLanguageSection').classList.add('hidden');
        document.getElementById('educationSection').classList.add('hidden');
        document.getElementById('toggleJobExperience').checked = false;
        document.getElementById('toggleEnglishLanguage').checked = false;
        document.getElementById('toggleEducation').checked = false;
        document.getElementById('jobExperienceContainer').innerHTML = '';
        document.getElementById('englishTestsContainer').innerHTML = '';
        document.getElementById('educationContainer').innerHTML = '';
        jobExperienceCount = 0;
        englishTestCount = 0;
        educationCount = 0;
    }

    function openEditSidebar(id) {
        // Open sidebar
        document.getElementById('statusOverlay').classList.remove('hidden');
        document.getElementById('statusSidebar').classList.remove('translate-x-full');
        document.getElementById('sidebarTitle').textContent = 'Edit Lead';
        document.getElementById('userForm').action = `/leads/${id}`;
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('submitBtn').innerHTML = '<i class="fa-solid fa-save mr-2"></i> Update';

        // Reset form
        document.getElementById('userForm').reset();
        document.getElementById('validationError').classList.add('hidden');

        // Reset dynamic sections
        document.getElementById('jobExperienceContainer').innerHTML = '';
        document.getElementById('englishTestsContainer').innerHTML = '';
        document.getElementById('educationContainer').innerHTML = '';
        document.getElementById('jobExperienceSection').classList.add('hidden');
        document.getElementById('englishLanguageSection').classList.add('hidden');
        document.getElementById('educationSection').classList.add('hidden');
        document.getElementById('toggleJobExperience').checked = false;
        document.getElementById('toggleEnglishLanguage').checked = false;
        document.getElementById('toggleEducation').checked = false;
        jobExperienceCount = 0;
        englishTestCount = 0;
        educationCount = 0;

        // Get CSRF token
        const csrfToken = document.querySelector('input[name="_token"]')?.value || 
                         document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // Show loading state
        document.getElementById('submitBtn').disabled = true;
        document.getElementById('submitBtn').innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Loading...';

        // Fetch user data
        fetch(`/leads/${id}/edit`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                credentials: 'same-origin'
            })
            .then(response => {
                console.log('Edit Response Status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Edit Data Received:', data);
                if (data.success && data.user) {
                    loadUserData(data.user);
                } else {
                    throw new Error('No user data received');
                }
                
                // Reset button
                document.getElementById('submitBtn').disabled = false;
                document.getElementById('submitBtn').innerHTML = '<i class="fa-solid fa-save mr-2"></i> Update';
            })
            .catch(error => {
                console.error('Error fetching user data:', error);
                alert('Error loading user data: ' + error.message);
                
                // Reset button and close sidebar
                document.getElementById('submitBtn').disabled = false;
                document.getElementById('submitBtn').innerHTML = '<i class="fa-solid fa-save mr-2"></i> Update';
                closeStatusSidebar();
            });
    }

    function loadUserData(user) {
        console.log('Loading user data:', user);

        // Fill basic fields
        document.getElementById('userName').value = user.name ?? '';
        document.getElementById('userEmail').value = user.email ?? '';
        document.getElementById('userPhone').value = user.phone ?? '';
        document.getElementById('userAdditionalPhone').value = user.additional_phone ?? '';
        document.getElementById('userDob').value = user.dob ?? '';
        document.getElementById('userCountry').value = user.country ?? '';
        document.getElementById('userPreferredCountry').value = user.preferred_country ?? '';
        document.getElementById('userCity').value = user.city ?? '';
        document.getElementById('userAddress').value = user.address ?? '';
        document.getElementById('userPersonalInformation').value = user.personal_information ?? '';
        document.getElementById('userAdditionalInformation').value = user.additional_information ?? '';
        document.getElementById('userDateOfContact').value = user.date_of_contact ?? '';
        document.getElementById('userStatusId').value = user.status_id ?? '';
        document.getElementById('userSourceId').value = user.source_id ?? '';
        document.getElementById('userAssignedId').value = user.assigned_id ?? '';
        document.getElementById('userHowDidHear').value = user.how_did_hear_about_us ?? '';

        // Load Job Experiences
        if (user.jobexpriences && user.jobexpriences.length > 0) {
            document.getElementById('toggleJobExperience').checked = true;
            document.getElementById('jobExperienceSection').classList.remove('hidden');

            user.jobexpriences.forEach((exp, index) => {
                const container = document.getElementById('jobExperienceContainer');
                const html = `
            <div class="job-experience-item border-2 border-gray-200 rounded-lg p-4 relative bg-gray-50">
                <button type="button" onclick="this.parentElement.remove(); jobExperienceCount--;" 
                    class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center bg-red-100 text-red-600 rounded-full hover:bg-red-600 hover:text-white transition">
                    <i class="fa-solid fa-times"></i>
                </button>
                <h5 class="font-semibold text-gray-700 mb-3 flex items-center">
                    <i class="fa-solid fa-briefcase mr-2 text-[#1A3A66]"></i> Experience #${index + 1}
                </h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="floating-label-group ${exp.company_name ? 'active' : ''}">
                        <input type="text" name="job_experiences[${index}][company_name]" value="${exp.company_name ?? ''}" placeholder=" ">
                        <label>Company Name</label>
                    </div>
                    <div class="floating-label-group ${exp.job_title ? 'active' : ''}">
                        <input type="text" name="job_experiences[${index}][job_title]" value="${exp.job_title ?? ''}" placeholder=" ">
                        <label>Job Title</label>
                    </div>
                    <div class="floating-label-group ${exp.duration ? 'active' : ''}">
                        <input type="text" name="job_experiences[${index}][duration]" value="${exp.duration ?? ''}" placeholder=" ">
                        <label>Duration (e.g. 2 years)</label>
                    </div>
                    <div class="floating-label-group ${exp.joining_date ? 'active' : ''}">
                        <input type="date" name="job_experiences[${index}][joining_date]" value="${exp.joining_date ?? ''}" placeholder=" " class="${exp.joining_date ? 'has-value' : ''}">
                        <label>Joining Date</label>
                    </div>
                    <div class="floating-label-group ${exp.end_date ? 'active' : ''}">
                        <input type="date" name="job_experiences[${index}][end_date]" value="${exp.end_date ?? ''}" placeholder=" " class="${exp.end_date ? 'has-value' : ''}">
                        <label>End Date</label>
                    </div>
                    <div class="floating-label-group md:col-span-2 ${exp.company_address ? 'active' : ''}">
                        <textarea name="job_experiences[${index}][company_address]" rows="2" placeholder=" ">${exp.company_address ?? ''}</textarea>
                        <label>Company Address</label>
                    </div>
                </div>
            </div>`;
                container.insertAdjacentHTML('beforeend', html);
                jobExperienceCount++;
            });
        }

        // Load English Language
        if (user.englishlanguages && user.englishlanguages.length > 0) {
            document.getElementById('toggleEnglishLanguage').checked = true;
            document.getElementById('englishLanguageSection').classList.remove('hidden');

            user.englishlanguages.forEach((eng, index) => {
                const container = document.getElementById('englishTestsContainer');
                
                // Detect test type
                let testType = '';
                if (eng.ielts_overall) testType = 'ielts';
                else if (eng.pte_overall) testType = 'pte';
                else if (eng.toefl) testType = 'toefl';
                else if (eng.duolingo) testType = 'duolingo';
                else if (eng.moi || eng.oietc) testType = 'other';

                const html = `
            <div class="english-test-item border-2 border-blue-200 rounded-lg p-4 relative bg-blue-50">
                <button type="button" onclick="this.parentElement.remove(); englishTestCount--;" 
                    class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center bg-red-100 text-red-600 rounded-full hover:bg-red-600 hover:text-white transition">
                    <i class="fa-solid fa-times"></i>
                </button>
                <h5 class="font-semibold text-gray-700 mb-3 flex items-center">
                    <i class="fa-solid fa-graduation-cap mr-2 text-blue-600"></i> English Test #${index + 1}
                </h5>
                
                <div class="mb-4 floating-label-group active">
                    <select id="englishTestType_${index}" onchange="toggleEnglishTestFields(${index}, this.value)">
                        <option value=""></option>
                        <option value="ielts" ${testType === 'ielts' ? 'selected' : ''}>IELTS</option>
                        <option value="pte" ${testType === 'pte' ? 'selected' : ''}>PTE</option>
                        <option value="toefl" ${testType === 'toefl' ? 'selected' : ''}>TOEFL</option>
                        <option value="duolingo" ${testType === 'duolingo' ? 'selected' : ''}>Duolingo</option>
                        <option value="other" ${testType === 'other' ? 'selected' : ''}>Other (MOI/OIETC)</option>
                    </select>
                    <label>Select Test Type</label>
                </div>

                <div id="ieltsFields_${index}" class="${testType === 'ielts' ? '' : 'hidden'}">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="floating-label-group ${eng.ielts_overall ? 'active' : ''}">
                            <input type="text" name="english_language[${index}][ielts_overall]" value="${eng.ielts_overall ?? ''}" placeholder=" ">
                            <label>Overall Band</label>
                        </div>
                        <div class="floating-label-group ${eng.ielts_listening ? 'active' : ''}">
                            <input type="text" name="english_language[${index}][ielts_listening]" value="${eng.ielts_listening ?? ''}" placeholder=" ">
                            <label>Listening</label>
                        </div>
                        <div class="floating-label-group ${eng.ielts_reading ? 'active' : ''}">
                            <input type="text" name="english_language[${index}][ielts_reading]" value="${eng.ielts_reading ?? ''}" placeholder=" ">
                            <label>Reading</label>
                        </div>
                        <div class="floating-label-group ${eng.ielts_writing ? 'active' : ''}">
                            <input type="text" name="english_language[${index}][ielts_writing]" value="${eng.ielts_writing ?? ''}" placeholder=" ">
                            <label>Writing</label>
                        </div>
                        <div class="floating-label-group ${eng.ielts_speaking ? 'active' : ''}">
                            <input type="text" name="english_language[${index}][ielts_speaking]" value="${eng.ielts_speaking ?? ''}" placeholder=" ">
                            <label>Speaking</label>
                        </div>
                    </div>
                </div>

                <div id="pteFields_${index}" class="${testType === 'pte' ? '' : 'hidden'}">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="floating-label-group ${eng.pte_overall ? 'active' : ''}">
                            <input type="text" name="english_language[${index}][pte_overall]" value="${eng.pte_overall ?? ''}" placeholder=" ">
                            <label>Overall Score</label>
                        </div>
                        <div class="floating-label-group ${eng.pte_listening ? 'active' : ''}">
                            <input type="text" name="english_language[${index}][pte_listening]" value="${eng.pte_listening ?? ''}" placeholder=" ">
                            <label>Listening</label>
                        </div>
                        <div class="floating-label-group ${eng.pte_reading ? 'active' : ''}">
                            <input type="text" name="english_language[${index}][pte_reading]" value="${eng.pte_reading ?? ''}" placeholder=" ">
                            <label>Reading</label>
                        </div>
                        <div class="floating-label-group ${eng.pte_writing ? 'active' : ''}">
                            <input type="text" name="english_language[${index}][pte_writing]" value="${eng.pte_writing ?? ''}" placeholder=" ">
                            <label>Writing</label>
                        </div>
                        <div class="floating-label-group ${eng.pte_speaking ? 'active' : ''}">
                            <input type="text" name="english_language[${index}][pte_speaking]" value="${eng.pte_speaking ?? ''}" placeholder=" ">
                            <label>Speaking</label>
                        </div>
                    </div>
                </div>

                <div id="toeflFields_${index}" class="${testType === 'toefl' ? '' : 'hidden'}">
                    <div class="floating-label-group ${eng.toefl ? 'active' : ''}">
                        <input type="text" name="english_language[${index}][toefl]" value="${eng.toefl ?? ''}" placeholder=" ">
                        <label>Total Score (0-120)</label>
                    </div>
                </div>

                <div id="duolingoFields_${index}" class="${testType === 'duolingo' ? '' : 'hidden'}">
                    <div class="floating-label-group ${eng.duolingo ? 'active' : ''}">
                        <input type="text" name="english_language[${index}][duolingo]" value="${eng.duolingo ?? ''}" placeholder=" ">
                        <label>Overall Score (10-160)</label>
                    </div>
                </div>

                <div id="otherFields_${index}" class="${testType === 'other' ? '' : 'hidden'}">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="floating-label-group ${eng.moi ? 'active' : ''}">
                            <input type="text" name="english_language[${index}][moi]" value="${eng.moi ?? ''}" placeholder=" ">
                            <label>MOI (Medium of Instruction)</label>
                        </div>
                        <div class="floating-label-group ${eng.oietc ? 'active' : ''}">
                            <input type="text" name="english_language[${index}][oietc]" value="${eng.oietc ?? ''}" placeholder=" ">
                            <label>OIETC</label>
                        </div>
                    </div>
                </div>
            </div>`;
                
                container.insertAdjacentHTML('beforeend', html);
                englishTestCount++;
            });
        }

        // Load Education
        if (user.examtypes && user.examtypes.length > 0) {
            document.getElementById('toggleEducation').checked = true;
            document.getElementById('educationSection').classList.remove('hidden');

            // Get countries from blade variable
            const countries = @json($country);

            user.examtypes.forEach((exam, index) => {
                const container = document.getElementById('educationContainer');
                
                // Generate country options with selection
                let countryOptions = '<option value="">Select Country</option>';
                countries.forEach(country => {
                    const selected = exam.country == country.id ? 'selected' : '';
                    countryOptions += `<option value="${country.id}" ${selected}>${country.name}</option>`;
                });
                
                const html = `
            <div class="education-item border-2 border-indigo-200 rounded-lg p-4 relative bg-indigo-50">
                <button type="button" onclick="this.parentElement.remove(); educationCount--;" 
                    class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center bg-red-100 text-red-600 rounded-full hover:bg-red-600 hover:text-white transition">
                    <i class="fa-solid fa-times"></i>
                </button>
                <h5 class="font-semibold text-gray-700 mb-3 flex items-center">
                    <i class="fa-solid fa-graduation-cap mr-2 text-indigo-600"></i> Education #${index + 1}
                </h5>
                
                <div class="mb-4 floating-label-group active">
                    <select id="educationExamType_${index}" onchange="toggleEducationFields(${index}, this.value)">
                        <option value=""></option>
                        <option value="SSC" ${exam.exam_type === 'SSC' ? 'selected' : ''}>SSC / O Level</option>
                        <option value="HSC" ${exam.exam_type === 'HSC' ? 'selected' : ''}>HSC / A Level</option>
                        <option value="Bachelor" ${exam.exam_type === 'Bachelor' ? 'selected' : ''}>Bachelor / Undergraduate</option>
                        <option value="Master" ${exam.exam_type === 'Master' ? 'selected' : ''}>Master / Postgraduate</option>
                        <option value="Diploma" ${exam.exam_type === 'Diploma' ? 'selected' : ''}>Diploma</option>
                        <option value="PhD" ${exam.exam_type === 'PhD' ? 'selected' : ''}>PhD / Doctorate</option>
                    </select>
                    <label>Select Education Level</label>
                </div>

                <div id="educationFields_${index}" class="${exam.exam_type ? '' : 'hidden'}">
                    <input type="hidden" name="exam_types[${index}][exam_type]" id="examTypeValue_${index}" value="${exam.exam_type ?? ''}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="floating-label-group ${exam.institute_name ? 'active' : ''}">
                            <input type="text" name="exam_types[${index}][institute_name]" value="${exam.institute_name ?? ''}" placeholder=" ">
                            <label>Institute Name</label>
                        </div>
                        <div class="floating-label-group ${exam.major_subject ? 'active' : ''}">
                            <input type="text" name="exam_types[${index}][major_subject]" value="${exam.major_subject ?? ''}" placeholder=" ">
                            <label>Major Subject / Group</label>
                        </div>
                        <div class="floating-label-group ${exam.result ? 'active' : ''}">
                            <input type="text" name="exam_types[${index}][result]" value="${exam.result ?? ''}" placeholder=" ">
                            <label>Result (CGPA/Grade)</label>
                        </div>
                        <div class="floating-label-group ${exam.passing_year ? 'active' : ''}">
                            <input type="text" name="exam_types[${index}][passing_year]" value="${exam.passing_year ?? ''}" placeholder=" ">
                            <label>Passing Year</label>
                        </div>
                        <div class="floating-label-group ${exam.country ? 'active' : ''}">
                            <select name="exam_types[${index}][country]">
                                ${countryOptions}
                            </select>
                            <label>Country</label>
                        </div>
                    </div>
                </div>
            </div>`;
                container.insertAdjacentHTML('beforeend', html);
                educationCount++;
            });
        }

        // Initialize floating labels
        setTimeout(initFloatingLabels, 100);
    }

    function closeStatusSidebar() {
        document.getElementById('statusOverlay').classList.add('hidden');
        document.getElementById('statusSidebar').classList.add('translate-x-full');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeStatusSidebar();
    });

    // Form Submit Handler
    document.getElementById('userForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const submitBtn = document.getElementById('submitBtn');
        const errorDiv = document.getElementById('validationError');
        const errorList = document.getElementById('errorList');

        if (submitBtn.disabled) return;

        const formData = new FormData(form);
        const originalBtnContent = submitBtn.innerHTML;
        const csrfToken = form.querySelector('input[name="_token"]').value;

        // Debug: Log all form data
        console.log('=== Form Data Debug ===');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
        console.log('======================');

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Processing...';

        errorDiv.classList.add('hidden');
        errorList.innerHTML = '';

        fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                credentials: 'same-origin'
            })
            .then(response => {
                console.log('Response Status:', response.status);
                if (!response.ok) {
                    return response.json().then(data => {
                        console.log('Error Response:', data);
                        throw {
                            errors: data.errors || {},
                            message: data.message
                        };
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Success Response:', data);
                if (data.success) {
                    window.location.reload();
                } else {
                    throw {
                        errors: data.errors || {},
                        message: data.message || 'Unknown error'
                    };
                }
            })
            .catch(error => {
                console.error('Catch Error:', error);

                if (error.errors && Object.keys(error.errors).length > 0) {
                    for (let field in error.errors) {
                        error.errors[field].forEach(err => {
                            const li = document.createElement('li');
                            li.textContent = err;
                            errorList.appendChild(li);
                        });
                    }
                    errorDiv.classList.remove('hidden');
                    errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    const li = document.createElement('li');
                    li.textContent = error.message || 'Something went wrong. Please try again.';
                    errorList.appendChild(li);
                    errorDiv.classList.remove('hidden');
                }

                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnContent;
            });
    });
</script>
@endsection
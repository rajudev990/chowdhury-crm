@extends('layouts.app')

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

    /* Active state for label */
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

    /* Date input handling */
    .floating-label-group input[type="date"]:not(:focus):not(.has-value) {
        color: transparent;
    }

    .floating-label-group input[type="date"]:focus,
    .floating-label-group input[type="date"].has-value {
        color: inherit;
    }

    /* Disabled state */
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
                                <th class="px-6 py-4 text-left">Preferred Countries</th>
                                <th class="px-6 py-4 text-left">Source</th>
                                <th class="px-6 py-4 text-left">Status</th>
                                <th class="px-6 py-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y text-sm text-gray-700">
                            @foreach($data as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">{{ $item->name }}</td>
                                <td class="px-6 py-4">{{ $item->email }}</td>
                                <td class="px-6 py-4">{{ $item->phone ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $item->assigned?->name ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $item->date_of_contact ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $item->preferred_country ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $item->source?->name ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $item->status?->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-1">
                                        <button onclick="openEditSidebar({{ $item->id }}, @json($item))"
                                            class="w-8 h-8 flex items-center justify-center text-[#9CA3AF] rounded-full hover:text-[#1A3A66] transition" title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <form action="{{ route('users.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="w-8 h-8 flex items-center justify-center rounded-full hover:text-[#1A3A66] text-[#9CA3AF] transition" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Overlay -->
                <div id="statusOverlay" class="fixed inset-0 bg-black/40 z-40 hidden" onclick="closeStatusSidebar()"></div>

                <!-- Right Sidebar -->
                <div id="statusSidebar" class="fixed top-0 right-0 h-full w-full sm:w-[850px] bg-white z-50 transform translate-x-full transition-transform duration-300 overflow-y-auto">

                    <!-- Header -->
                    <div class="flex items-center justify-between px-6 py-5 bg-[#1A3A66] text-white sticky top-0 z-10">
                        <h2 class="text-xl font-semibold" id="sidebarTitle">Add New Leads</h2>
                        <button onclick="closeStatusSidebar()" class="text-2xl hover:text-gray-300">&times;</button>
                    </div>

                    <!-- Form -->
                    <form id="userForm" method="POST" action="{{ route('users.store') }}" class="p-6 space-y-6">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">

                        <!-- Validation Errors -->
                        <div id="validationError" class="hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                            <ul id="errorList" class="list-disc list-inside text-sm"></ul>
                        </div>

                        <!-- Basic Info Section -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="floating-label-group">
                                <select id="userStatusId" name="status_id">
                                    <option value=""></option>
                                    @foreach($status as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                                <label>Status <span class="required">*</span></label>
                            </div>
                            <div class="floating-label-group">
                                <select id="userSourceId" name="source_id">
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
                                    <option value="1">Admin User</option>
                                    <option value="2">Sales Team</option>
                                </select>
                                <label>Assigned <span class="required">*</span></label>
                            </div>
                        </div>

                        <div class="floating-label-group">
                            <input type="text" id="userHowDidHear" name="how_did_hear_about_us" required placeholder=" ">
                            <label>How did hear about us? <span class="required">*</span></label>
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
                            <div class="floating-label-group">
                                <input type="text" id="userAddress" name="address" placeholder=" ">
                                <label>Address</label>
                            </div>
                            <div class="floating-label-group">
                                <input type="date" id="userDateOfContact" name="date_of_contact" placeholder=" ">
                                <label>Date of Contact</label>
                            </div>
                        </div>

                        <div class="floating-label-group">
                            <textarea id="userPersonalInformation" name="personal_information" rows="3" placeholder=" "></textarea>
                            <label>Personal Information</label>
                        </div>
                        <div class="floating-label-group">
                            <textarea id="userAdditionalInformation" name="additional_information" rows="3" placeholder=" "></textarea>
                            <label>Additional Information</label>
                        </div>

                        <!-- Job Experience Section -->
                        <div class="border-t pt-6 mt-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-[#1A3A66]">Job Experience</h3>
                                <label class="flex items-center cursor-pointer bg-gray-50 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
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
                                <label class="flex items-center cursor-pointer bg-gray-50 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                                    <input type="checkbox" id="toggleEnglishLanguage" class="mr-2 w-4 h-4 accent-[#1A3A66]">
                                    <span class="text-sm font-medium text-gray-700">Add English Test</span>
                                </label>
                            </div>
                            <div id="englishLanguageSection" class="hidden">
                                <div class="mb-4 floating-label-group">
                                    <select id="englishTestType">
                                        <option value=""></option>
                                        <option value="ielts">IELTS</option>
                                        <option value="pte">PTE</option>
                                        <option value="toefl">TOEFL</option>
                                        <option value="duolingo">Duolingo</option>
                                        <option value="other">Other (MOI/OIETC)</option>
                                    </select>
                                    <label>Select Test Type <span class="required">*</span></label>
                                </div>

                                <!-- IELTS Fields -->
                                <div id="ieltsFields" class="hidden">
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                        <h4 class="font-semibold text-blue-900 mb-3 flex items-center">
                                            <i class="fa-solid fa-graduation-cap mr-2"></i> IELTS Scores
                                        </h4>
                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                            <div class="floating-label-group">
                                                <input type="text" name="english_language[ielts_overall]" placeholder=" ">
                                                <label>Overall Band</label>
                                            </div>
                                            <div class="floating-label-group">
                                                <input type="text" name="english_language[ielts_listening]" placeholder=" ">
                                                <label>Listening</label>
                                            </div>
                                            <div class="floating-label-group">
                                                <input type="text" name="english_language[ielts_reading]" placeholder=" ">
                                                <label>Reading</label>
                                            </div>
                                            <div class="floating-label-group">
                                                <input type="text" name="english_language[ielts_writing]" placeholder=" ">
                                                <label>Writing</label>
                                            </div>
                                            <div class="floating-label-group">
                                                <input type="text" name="english_language[ielts_speaking]" placeholder=" ">
                                                <label>Speaking</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- PTE Fields -->
                                <div id="pteFields" class="hidden">
                                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                                        <h4 class="font-semibold text-purple-900 mb-3 flex items-center">
                                            <i class="fa-solid fa-graduation-cap mr-2"></i> PTE Scores
                                        </h4>
                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                            <div class="floating-label-group">
                                                <input type="text" name="english_language[pte_overall]" placeholder=" ">
                                                <label>Overall Score</label>
                                            </div>
                                            <div class="floating-label-group">
                                                <input type="text" name="english_language[pte_listening]" placeholder=" ">
                                                <label>Listening</label>
                                            </div>
                                            <div class="floating-label-group">
                                                <input type="text" name="english_language[pte_reading]" placeholder=" ">
                                                <label>Reading</label>
                                            </div>
                                            <div class="floating-label-group">
                                                <input type="text" name="english_language[pte_writing]" placeholder=" ">
                                                <label>Writing</label>
                                            </div>
                                            <div class="floating-label-group">
                                                <input type="text" name="english_language[pte_speaking]" placeholder=" ">
                                                <label>Speaking</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TOEFL Fields -->
                                <div id="toeflFields" class="hidden">
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                        <h4 class="font-semibold text-green-900 mb-3 flex items-center">
                                            <i class="fa-solid fa-graduation-cap mr-2"></i> TOEFL Score
                                        </h4>
                                        <div class="floating-label-group">
                                            <input type="text" name="english_language[toefl]" placeholder=" ">
                                            <label>Total Score (0-120)</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Duolingo Fields -->
                                <div id="duolingoFields" class="hidden">
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                        <h4 class="font-semibold text-yellow-900 mb-3 flex items-center">
                                            <i class="fa-solid fa-graduation-cap mr-2"></i> Duolingo Score
                                        </h4>
                                        <div class="floating-label-group">
                                            <input type="text" name="english_language[duolingo]" placeholder=" ">
                                            <label>Overall Score (10-160)</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Other Fields (MOI/OIETC) -->
                                <div id="otherFields" class="hidden">
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                            <i class="fa-solid fa-graduation-cap mr-2"></i> Other Certifications
                                        </h4>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="floating-label-group">
                                                <input type="text" name="english_language[moi]" placeholder=" ">
                                                <label>MOI (Medium of Instruction)</label>
                                            </div>
                                            <div class="floating-label-group">
                                                <input type="text" name="english_language[oietc]" placeholder=" ">
                                                <label>OIETC</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Educational Information Section -->
                        <div class="border-t pt-6 mt-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-[#1A3A66]">Educational Information</h3>
                                <label class="flex items-center cursor-pointer bg-gray-50 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                                    <input type="checkbox" id="toggleEducation" class="mr-2 w-4 h-4 accent-[#1A3A66]">
                                    <span class="text-sm font-medium text-gray-700">Add Education</span>
                                </label>
                            </div>
                            <div id="educationSection" class="hidden">
                                <div class="mb-4 floating-label-group">
                                    <select id="educationExamType">
                                        <option value=""></option>
                                        <option value="SSC">SSC / O Level</option>
                                        <option value="HSC">HSC / A Level</option>
                                        <option value="Bachelor">Bachelor / Undergraduate</option>
                                        <option value="Master">Master / Postgraduate</option>
                                        <option value="Diploma">Diploma</option>
                                        <option value="PhD">PhD / Doctorate</option>
                                    </select>
                                    <label>Select Education Level <span class="required">*</span></label>
                                </div>

                                <div id="educationFieldsContainer" class="hidden">
                                    <div id="educationContainer" class="space-y-4"></div>
                                    <button type="button" onclick="addEducation()"
                                        class="mt-4 px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition text-sm font-medium shadow-sm">
                                        <i class="fa-solid fa-plus mr-1"></i> Add More Education
                                    </button>
                                </div>
                            </div>
                        </div>


                        <!-- Preferred Countries -->
                        <div class="border-t pt-6 mt-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-[#1A3A66]">Preferred Countries</h3>
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

    // Handle select floating labels
    document.querySelectorAll('.floating-label-group select').forEach(select => {
        // Check on load if select has value
        if (select.value) {
            select.parentElement.classList.add('active');
        }

        // Add change event
        select.addEventListener('change', function() {
            if (this.value) {
                this.parentElement.classList.add('active');
            } else {
                this.parentElement.classList.remove('active');
            }
        });
    });

    // Toggle sections
    document.getElementById('toggleJobExperience')?.addEventListener('change', function() {
        const section = document.getElementById('jobExperienceSection');
        if (this.checked) {
            section.classList.remove('hidden');
            if (jobExperienceCount === 0) addJobExperience();
        } else {
            section.classList.add('hidden');
        }
    });

    document.getElementById('toggleEnglishLanguage')?.addEventListener('change', function() {
        const section = document.getElementById('englishLanguageSection');
        section.classList.toggle('hidden', !this.checked);
    });

    document.getElementById('toggleEducation')?.addEventListener('change', function() {
        const section = document.getElementById('educationSection');
        if (this.checked) {
            section.classList.remove('hidden');
            if (educationCount === 0) addEducation();
        } else {
            section.classList.add('hidden');
        }
    });

    // English Test Type Change
    document.getElementById('englishTestType')?.addEventListener('change', function() {
        document.querySelectorAll('#ieltsFields, #pteFields, #toeflFields, #duolingoFields, #otherFields').forEach(el => el.classList.add('hidden'));
        const selectedTest = this.value;
        if (selectedTest === 'ielts') document.getElementById('ieltsFields').classList.remove('hidden');
        if (selectedTest === 'pte') document.getElementById('pteFields').classList.remove('hidden');
        if (selectedTest === 'toefl') document.getElementById('toeflFields').classList.remove('hidden');
        if (selectedTest === 'duolingo') document.getElementById('duolingoFields').classList.remove('hidden');
        if (selectedTest === 'other') document.getElementById('otherFields').classList.remove('hidden');
    });

    // Add Job Experience
    function addJobExperience() {
        const container = document.getElementById('jobExperienceContainer');
        const html = `
        <div class="job-experience-item border border-gray-300 rounded-lg p-4 relative">
            <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-red-600 hover:text-red-800">
                <i class="fa-solid fa-times"></i>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Company Name</label>
                    <input type="text" name="job_experiences[${jobExperienceCount}][company_name]" class="w-full border border-gray-300 rounded-lg px-4 py-2.5">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Job Title</label>
                    <input type="text" name="job_experiences[${jobExperienceCount}][job_title]" class="w-full border border-gray-300 rounded-lg px-4 py-2.5">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Duration</label>
                    <input type="text" name="job_experiences[${jobExperienceCount}][duration]" class="w-full border border-gray-300 rounded-lg px-4 py-2.5" placeholder="e.g. 2 years">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Joining Date</label>
                    <input type="date" name="job_experiences[${jobExperienceCount}][joining_date]" class="w-full border border-gray-300 rounded-lg px-4 py-2.5">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">End Date</label>
                    <input type="date" name="job_experiences[${jobExperienceCount}][end_date]" class="w-full border border-gray-300 rounded-lg px-4 py-2.5">
                </div>
                <div class="md:col-span-2">
                    <label class="block mb-1 text-sm font-medium text-gray-700">Company Address</label>
                    <textarea name="job_experiences[${jobExperienceCount}][company_address]" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-3 resize-none"></textarea>
                </div>
            </div>
        </div>
    `;
        container.insertAdjacentHTML('beforeend', html);
        jobExperienceCount++;
    }

    // Add Education
    function addEducation() {
        const container = document.getElementById('educationContainer');
        const html = `
        <div class="education-item border border-gray-300 rounded-lg p-4 relative">
            <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-red-600 hover:text-red-800">
                <i class="fa-solid fa-times"></i>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Exam Type</label>
                    <select name="exam_types[${educationCount}][exam_type]" class="w-full border border-gray-300 rounded-lg px-4 py-2.5">
                        <option value="">Select Type</option>
                        <option value="SSC">SSC</option>
                        <option value="HSC">HSC</option>
                        <option value="Bachelor">Bachelor</option>
                        <option value="Master">Master</option>
                        <option value="Diploma">Diploma</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Institute Name</label>
                    <input type="text" name="exam_types[${educationCount}][institute_name]" class="w-full border border-gray-300 rounded-lg px-4 py-2.5">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Major Subject</label>
                    <input type="text" name="exam_types[${educationCount}][major_subject]" class="w-full border border-gray-300 rounded-lg px-4 py-2.5">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Result</label>
                    <input type="text" name="exam_types[${educationCount}][result]" class="w-full border border-gray-300 rounded-lg px-4 py-2.5" placeholder="e.g. CGPA 3.50">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Passing Year</label>
                    <input type="text" name="exam_types[${educationCount}][passing_year]" class="w-full border border-gray-300 rounded-lg px-4 py-2.5" placeholder="e.g. 2020">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Country</label>
                    <input type="text" name="exam_types[${educationCount}][country]" class="w-full border border-gray-300 rounded-lg px-4 py-2.5">
                </div>
            </div>
        </div>
    `;
        container.insertAdjacentHTML('beforeend', html);
        educationCount++;
    }

    function openStatusSidebar() {
        document.getElementById('statusOverlay').classList.remove('hidden');
        document.getElementById('statusSidebar').classList.remove('translate-x-full');
        document.getElementById('sidebarTitle').textContent = 'Add User';
        document.getElementById('userForm').action = '{{ route("users.store") }}';
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('submitBtn').textContent = 'Save User';

        // Reset form
        document.getElementById('userForm').reset();
        document.getElementById('validationError').classList.add('hidden');

        // Reset dynamic sections
        document.getElementById('jobExperienceSection').classList.add('hidden');
        document.getElementById('englishLanguageSection').classList.add('hidden');
        document.getElementById('educationSection').classList.add('hidden');
        document.getElementById('toggleJobExperience').checked = false;
        document.getElementById('toggleEnglishLanguage').checked = false;
        document.getElementById('toggleEducation').checked = false;
        document.getElementById('jobExperienceContainer').innerHTML = '';
        document.getElementById('educationContainer').innerHTML = '';
        jobExperienceCount = 0;
        educationCount = 0;
    }

    function openEditSidebar(id, user) {
        document.getElementById('statusOverlay').classList.remove('hidden');
        document.getElementById('statusSidebar').classList.remove('translate-x-full');
        document.getElementById('sidebarTitle').textContent = 'Edit User';
        document.getElementById('userForm').action = '/users/' + id;
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('submitBtn').textContent = 'Update User';

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

        // Load job experiences if exists
        if (user.job_experiences && user.job_experiences.length > 0) {
            document.getElementById('toggleJobExperience').checked = true;
            document.getElementById('jobExperienceSection').classList.remove('hidden');
            document.getElementById('jobExperienceContainer').innerHTML = '';
            user.job_experiences.forEach(exp => {
                // Add logic to populate job experiences
            });
        }

        document.getElementById('validationError').classList.add('hidden');
    }

    function closeStatusSidebar() {
        document.getElementById('statusOverlay').classList.add('hidden');
        document.getElementById('statusSidebar').classList.add('translate-x-full');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeStatusSidebar();
    });

    // AJAX submit
    document.getElementById('userForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const submitBtn = document.getElementById('submitBtn');
        const errorDiv = document.getElementById('validationError');
        const errorList = document.getElementById('errorList');

        submitBtn.disabled = true;
        submitBtn.textContent = 'Processing...';
        errorDiv.classList.add('hidden');
        errorList.innerHTML = '';

        fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            }).then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    if (data.errors) {
                        for (let field in data.errors) {
                            data.errors[field].forEach(err => {
                                const li = document.createElement('li');
                                li.textContent = err;
                                errorList.appendChild(li);
                            });
                        }
                        errorDiv.classList.remove('hidden');
                    }
                }
                submitBtn.disabled = false;
                submitBtn.textContent = document.getElementById('formMethod').value === 'POST' ? 'Save User' : 'Update User';
            })
            .catch(err => {
                console.error(err);
                const li = document.createElement('li');
                li.textContent = 'Something went wrong.';
                errorList.appendChild(li);
                errorDiv.classList.remove('hidden');
                submitBtn.disabled = false;
                submitBtn.textContent = document.getElementById('formMethod').value === 'POST' ? 'Save User' : 'Update User';
            });
    });
</script>
@endsection
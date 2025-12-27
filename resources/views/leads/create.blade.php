@extends('layouts.app')
@section('title', isset($lead) ? 'Edit Lead' : 'Create Lead')

@section('content')
<div class="container mx-auto mt-5">
    <div class="mx-auto bg-white rounded-lg shadow-xl border border-gray-200">
        <h5 class="bg-[#1A3A66] font-semibold mb-6 p-3 text-2xl text-white">
            {{ isset($lead) ? 'Edit Lead' : 'Create Lead' }}
        </h5>

        <!-- Validation Errors -->
        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ isset($lead) ? route('leads.update', $lead->id) : route('leads.store') }}" method="POST" class="p-6">
            @csrf
            @if(isset($lead)) @method('PUT') @endif

            <!-- Status, Source, Assigness -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                    <select name="status_id" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Status</option>
                        @foreach($status as $item)
                        <option value="{{ $item->id }}" @if(isset($lead) && $lead->status_id==$item->id) selected @endif>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Source <span class="text-red-500">*</span></label>
                    <select name="source_id" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Source</option>
                        @foreach($source as $item)
                        <option value="{{ $item->id }}" @if(isset($lead) && $lead->source_id==$item->id) selected @endif>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Assigness <span class="text-red-500">*</span></label>
                    <select name="assigned_id" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Assigness</option>
                        @foreach($users as $item)
                        <option value="{{ $item->id }}" @if(isset($lead) && $lead->assigned_id==$item->id) selected @endif>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-4">
                <div>                    <input type="text" name="how_did_hear_about_us" value="{{ old('how_did_hear_about_us', $lead->how_did_hear_about_us ?? '') }}" placeholder="How did hear about us"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Personal Information -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-[#4A5F7F] mb-4">Personal Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 mb-2">Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $lead->name ?? '') }}" placeholder="Enter name"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Date of Birth</label>
                        <input type="date" name="dob" value="{{ old('dob', $lead->dob ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $lead->email ?? '') }}" placeholder="Enter email"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 mb-2">Phone <span class="text-red-500">*</span></label>
                        <div class="flex gap-2">
                            {{-- <div class="flex items-center gap-2 border border-gray-300 rounded-lg px-3 py-3 bg-gray-50">
                                <span class="text-2xl">🇧🇩</span>
                                <span class="text-gray-700">+880</span>
                            </div> --}}
                            <input type="tel" name="phone" value="{{ old('phone', $lead->phone ?? '') }}" placeholder="Phone number"
                                   class="flex-1 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Additional Phone</label>
                        <input type="tel" name="additional_phone" value="{{ old('additional_phone', $lead->additional_phone ?? '') }}" placeholder="Additional phone"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Country</label>
                        <select name="country" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Country</option>
                            @foreach($country as $c)
                            <option value="{{ $c->name }}" @if(isset($lead) && $lead->country==$c->name) selected @endif>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 mb-2">City</label>
                        <input type="text" name="city" value="{{ old('city', $lead->city ?? '') }}" placeholder="Enter city"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Address</label>
                        <input type="text" name="address" value="{{ old('address', $lead->address ?? '') }}" placeholder="Enter address"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Date of Contact</label>
                        <input type="date" name="date_of_contact" value="{{ old('date_of_contact', $lead->date_of_contact ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Additional Information</label>
                    <textarea name="additional_information" placeholder="Enter additional information"
                              class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 h-24 resize-none">{{ old('additional_information', $lead->additional_information ?? '') }}</textarea>
                </div>
            </div>

            <hr class="my-6">

             <!-- Exam / Education Section -->
            <div class="mb-6 border-b mb-6">
                <div class="flex justify-between">
                    <h3 class="text-lg font-semibold text-[#4A5F7F] mb-4">Educational Information</h3>
                    <p class="text-[#4A5F7F]" onclick="addExam()">+ Add Exam</p>
                </div>

                <div id="examWrapper"></div>
                
            </div>


             <!-- English Language Section -->
            <div class="mb-6 border-b mb-6">
                <div class="flex justify-between">
                    <h3 class="text-lg font-semibold text-[#4A5F7F] mb-4">English Language Proficiency</h3>
                    <p class="text-[#4A5F7F]" onclick="addEnglishTest()">+ Add Course</p>
                </div>

                <div id="englishWrapper"></div>
                
            </div>


            <!-- Job Experience Section -->
            <div class="mb-6 border-b mb-6">
                <div class="flex justify-between">
                    <h3 class="text-lg font-semibold text-[#4A5F7F] mb-4">Job Experience</h3>
                    <p class="text-[#4A5F7F]" onclick="addJobExperience()">+ Add Job Experience</p>
                </div>
          
                <div id="jobExperienceWrapper"></div>
               
            </div>

            <div class="mb-5">
                <div>
                    <label class="block text-gray-700 mb-2">Preferred Country</label>
                    <select name="preferred_country" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Country</option>
                        @foreach($country as $item)
                        <option value="{{ $item->name }}" @if(isset($lead) && $lead->preferred_country==$item->name) selected @endif>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

           

           

            <div class="text-right">
                <button type="submit" class="py-3 px-4 bg-[#1A3A66] text-white rounded-lg hover:bg-[#16305a] transition">
                {{ isset($lead) ? 'Update Lead' : 'Create Lead' }}
                </button>
            </div>

        </form>
    </div>
</div>
@endsection

@section('js')
<script>
// On page load, pre-fill existing data (edit mode)
document.addEventListener("DOMContentLoaded", function(){
    @if(isset($jobExperiences))
        @foreach($jobExperiences as $exp)
            addJobExperience(@json($exp));
        @endforeach
    @endif

    @if(isset($englishTests))
        @foreach($englishTests as $test)
            addEnglishTest(@json($test));
        @endforeach
    @endif

    @if(isset($exams))
        @foreach($exams as $exam)
            addExam(@json($exam));
        @endforeach
    @endif
});
</script>

<script>
let jobCount = 0;
let englishCount = 0;
let examCount = 0;

// JOB EXPERIENCE
function addJobExperience(data = {}) {
    const html = `
    <div class="border border-gray-300 rounded-lg p-4 mb-4 relative bg-gray-50">
        <button type="button" onclick="this.parentElement.remove()" 
            class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Remove</button>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
            <input type="text" name="job_experience[${jobCount}][company_name]" placeholder="Company Name" value="${data.company_name || ''}" class="border px-3 py-2 rounded w-full">
            <input type="text" name="job_experience[${jobCount}][job_title]" placeholder="Job Title" value="${data.job_title || ''}" class="border px-3 py-2 rounded w-full">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-2">
            <input type="text" name="job_experience[${jobCount}][duration]" placeholder="Duration" value="${data.duration || ''}" class="border px-3 py-2 rounded w-full">
            <input type="date" name="job_experience[${jobCount}][joining_date]" placeholder="Joining Date" value="${data.joining_date || ''}" class="border px-3 py-2 rounded w-full">
            <input type="date" name="job_experience[${jobCount}][end_date]" placeholder="End Date" value="${data.end_date || ''}" class="border px-3 py-2 rounded w-full">
        </div>
        <textarea name="job_experience[${jobCount}][company_address]" placeholder="Company Address" class="border px-3 py-2 rounded w-full">${data.company_address || ''}</textarea>
    </div>`;
    document.getElementById('jobExperienceWrapper').insertAdjacentHTML('beforeend', html);
    jobCount++;
}

function addEnglishTest(data = {}) {
    const html = `
    <div class="border border-blue-300 rounded-lg p-4 mb-4 relative bg-blue-50 english-test-block">
        <button type="button" onclick="this.parentElement.remove()" 
            class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Remove</button>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
            <select name="english_test[${englishCount}][test_type]" 
                    onchange="showEnglishFields(this)" 
                    class="border px-3 py-2 rounded w-full">
                <option value="">Select Test Type</option>
                <option value="duolingo" ${data.test_type=='duolingo' ? 'selected':''}>DUOLINGO</option>
                <option value="ielts" ${data.test_type=='ielts' ? 'selected':''}>IELTS</option>
                <option value="moi" ${data.test_type=='moi' ? 'selected':''}>MOI</option>
                <option value="oietc" ${data.test_type=='oietc' ? 'selected':''}>OIETC</option>
                <option value="pte" ${data.test_type=='pte' ? 'selected':''}>PTE</option>
                <option value="toefl" ${data.test_type=='toefl' ? 'selected':''}>TOEFL</option>
            </select>
        </div>

        <div class="english-fields">
            <div class="ielts-fields ${data.test_type!='ielts' ? 'hidden':''} grid grid-cols-1 md:grid-cols-5 gap-2 mb-2">
                <input type="text" name="english_test[${englishCount}][ielts_overall]" placeholder="Overall" value="${data.ielts_overall || ''}" class="border px-3 py-2 rounded">
                <input type="text" name="english_test[${englishCount}][ielts_listening]" placeholder="Listening" value="${data.ielts_listening || ''}" class="border px-3 py-2 rounded">
                <input type="text" name="english_test[${englishCount}][ielts_writing]" placeholder="Writing" value="${data.ielts_writing || ''}" class="border px-3 py-2 rounded">
                <input type="text" name="english_test[${englishCount}][ielts_speaking]" placeholder="Speaking" value="${data.ielts_speaking || ''}" class="border px-3 py-2 rounded">
                <input type="text" name="english_test[${englishCount}][ielts_reading]" placeholder="Reading" value="${data.ielts_reading || ''}" class="border px-3 py-2 rounded">
            </div>

            <div class="pte-fields ${data.test_type!='pte' ? 'hidden':''} grid grid-cols-1 md:grid-cols-5 gap-2 mb-2">
                <input type="text" name="english_test[${englishCount}][pte_overall]" placeholder="Overall" value="${data.pte_overall || ''}" class="border px-3 py-2 rounded">
                <input type="text" name="english_test[${englishCount}][pte_listening]" placeholder="Listening" value="${data.pte_listening || ''}" class="border px-3 py-2 rounded">
                <input type="text" name="english_test[${englishCount}][pte_writing]" placeholder="Writing" value="${data.pte_writing || ''}" class="border px-3 py-2 rounded">
                <input type="text" name="english_test[${englishCount}][pte_speaking]" placeholder="Speaking" value="${data.pte_speaking || ''}" class="border px-3 py-2 rounded">
                <input type="text" name="english_test[${englishCount}][pte_reading]" placeholder="Reading" value="${data.pte_reading || ''}" class="border px-3 py-2 rounded">
            </div>

            <div class="duolingo-fields ${data.test_type!='duolingo' ? 'hidden':''} mb-2">
                <input type="text" name="english_test[${englishCount}][duolingo]" placeholder="Score" value="${data.duolingo || ''}" class="border px-3 py-2 rounded w-full">
            </div>

            <div class="moi-fields ${data.test_type!='moi' ? 'hidden':''} mb-2">
                <input type="text" name="english_test[${englishCount}][moi]" placeholder="MOI Score" value="${data.moi || ''}" class="border px-3 py-2 rounded w-full">
            </div>

            <div class="oietc-fields ${data.test_type!='oietc' ? 'hidden':''} mb-2">
                <input type="text" name="english_test[${englishCount}][oietc]" placeholder="OIETC Score" value="${data.oietc || ''}" class="border px-3 py-2 rounded w-full">
            </div>

            <div class="toefl-fields ${data.test_type!='toefl' ? 'hidden':''} mb-2">
                <input type="text" name="english_test[${englishCount}][toefl]" placeholder="TOEFL Score" value="${data.toefl || ''}" class="border px-3 py-2 rounded w-full">
            </div>
        </div>
    </div>`;
    document.getElementById('englishWrapper').insertAdjacentHTML('beforeend', html);
    englishCount++;
}

function showEnglishFields(select){
    const parent = select.closest('.english-test-block').querySelector('.english-fields');
    ['ielts','pte','toefl','duolingo','moi','oietc'].forEach(type=>{
        const div = parent.querySelector(`.${type}-fields`);
        if(div) div.classList.add('hidden');
    });
    if(select.value) parent.querySelector(`.${select.value}-fields`).classList.remove('hidden');
}


// EXAM / EDUCATION
function addExam(data={}){
    const examTypes = ['SSC','HSC','Bachelor','Diploma','Masters','O Level','A Level'];
    let examOptions = '<option value="">Select Exam Type</option>';
    examTypes.forEach(t=> examOptions += `<option value="${t}" ${data.exam_type==t?'selected':''}>${t}</option>`);

    const countries = @json($country);
    let countryOptions = '<option value="">Select Country</option>';
    countries.forEach(c=> countryOptions += `<option value="${c.name}" ${data.country==c.name?'selected':''}>${c.name}</option>`);

    const html = `
    <div class="border border-green-300 rounded-lg p-4 mb-4 relative bg-green-50">
        <button type="button" onclick="this.parentElement.remove()" 
            class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Remove</button>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
            <select name="exam[${examCount}][exam_type]" class="border px-3 py-2 rounded w-full">
                ${examOptions}
            </select>
            <input type="text" name="exam[${examCount}][institute_name]" placeholder="Institute Name" value="${data.institute_name || ''}" class="border px-3 py-2 rounded w-full">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-2">
            <input type="text" name="exam[${examCount}][major_subject]" placeholder="Major Subject" value="${data.major_subject || ''}" class="border px-3 py-2 rounded w-full">
            <input type="text" name="exam[${examCount}][result]" placeholder="Result" value="${data.result || ''}" class="border px-3 py-2 rounded w-full">
            <input type="text" name="exam[${examCount}][passing_year]" placeholder="Passing Year" value="${data.passing_year || ''}" class="border px-3 py-2 rounded w-full">
        </div>
        <select name="exam[${examCount}][country]" class="border px-3 py-2 rounded w-full">
            ${countryOptions}
        </select>
    </div>`;
    document.getElementById('examWrapper').insertAdjacentHTML('beforeend', html);
    examCount++;
}

</script>
@endsection
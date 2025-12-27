<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\EnglishLanguage;
use App\Models\ExamType;
use App\Models\JobExprience;
use App\Models\Source;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LeadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view leads')->only('index','show');
        $this->middleware('permission:create leads')->only(['create', 'store']);
        $this->middleware('permission:edit leads')->only(['edit', 'update']);
        $this->middleware('permission:delete leads')->only('destroy');
    }

    public function index()
    {
        $status = Status::where('status', 1)->get();
        $source = Source::where('status', 1)->get();
        $country = Country::where('status', 1)->get();
        $users = User::where('type','admin')->get();
        $leads = User::where('type','leads')->latest()->get();

        return view('leads.index', compact('status', 'source', 'country','users','leads'));
    }

    // Create page
    public function create()
    {
        $status = Status::where('status', 1)->get();
        $source = Source::where('status', 1)->get();
        $country = Country::where('status', 1)->get();
        $users = User::where('type','admin')->get();

        return view('leads.create', compact('status', 'source', 'country','users'));
    }

    // Store lead
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'additional_phone' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'personal_information' => 'nullable|string',
            'additional_information' => 'nullable|string',
            'date_of_contact' => 'nullable|date',
            'status_id' => 'nullable|integer',
            'how_did_hear_about_us' => 'nullable|string',
            'assigned_id' => 'nullable|integer',
        ]);

        DB::transaction(function () use ($request) {
            $lead = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'additional_phone' => $request->additional_phone,
                'dob' => $request->dob,
                'country' => $request->country,
                'city' => $request->city,
                'address' => $request->address,
                'personal_information' => $request->personal_information,
                'additional_information' => $request->additional_information,
                'date_of_contact' => $request->date_of_contact,
                'status_id' => $request->status_id,
                'source_id' => $request->source_id,
                'how_did_hear_about_us' => $request->how_did_hear_about_us,
                'assigned_id' => $request->assigned_id,
                'preferred_country' => $request->preferred_country,
                'password' => bcrypt('password'),
                'type' => 'leads',
            ]);

            // Job Experience
            if ($request->job_experience && is_array($request->job_experience)) {
                foreach ($request->job_experience as $experience) {
                    JobExprience::create(array_merge($experience, ['user_id' => $lead->id]));
                }
            }

            // English Language
            if ($request->english_test && is_array($request->english_test)) {
                foreach ($request->english_test as $test) {
                    EnglishLanguage::create(array_merge($test, ['user_id' => $lead->id]));
                }
            }

            // Exam Type
            if ($request->exam && is_array($request->exam)) {
                foreach ($request->exam as $exam) {
                    ExamType::create(array_merge($exam, ['user_id' => $lead->id]));
                }
            }
        });

        return redirect()->route('leads.index')->with('success', 'Lead created successfully');
    }

    // Edit page
    public function edit(User $lead)
    {
        $status = Status::where('status', 1)->get();
        $source = Source::where('status', 1)->get();
        $country = Country::where('status', 1)->get();
        $users = User::where('type','admin')->get();

        $jobExperiences = $lead->jobExperiences ?? [];
        $englishTests = $lead->englishLanguages ?? [];
        $exams = $lead->examTypes ?? [];

        return view('leads.create', compact('lead','status','source','country','users','jobExperiences','englishTests','exams'));
    }
    public function show(User $lead)
    {
        $status = Status::where('status', 1)->get();
        $source = Source::where('status', 1)->get();
        $country = Country::where('status', 1)->get();
        $users = User::where('type','admin')->get();

        $jobExperiences = $lead->jobExperiences ?? [];
        $englishTests = $lead->englishLanguages ?? [];
        $exams = $lead->examTypes ?? [];

        return view('leads.view', compact('lead','status','source','country','users','jobExperiences','englishTests','exams'));
    }

    // Update lead
    public function update(Request $request, User $lead)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $lead->id,
            'phone' => 'required|string|max:20',
            'additional_phone' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'personal_information' => 'nullable|string',
            'additional_information' => 'nullable|string',
            'date_of_contact' => 'nullable|date',
            'status_id' => 'nullable|integer',
            'how_did_hear_about_us' => 'nullable|string',
            'assigned_id' => 'nullable|integer',
        ]);

        DB::transaction(function () use ($request, $lead) {
            $lead->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'additional_phone' => $request->additional_phone,
                'dob' => $request->dob,
                'country' => $request->country,
                'city' => $request->city,
                'address' => $request->address,
                'personal_information' => $request->personal_information,
                'additional_information' => $request->additional_information,
                'date_of_contact' => $request->date_of_contact,
                'status_id' => $request->status_id,
                'source_id' => $request->source_id,
                'how_did_hear_about_us' => $request->how_did_hear_about_us,
                'assigned_id' => $request->assigned_id,
                'preferred_country' => $request->preferred_country,
                'password' => bcrypt('password'),
                'type' => 'leads',
            ]);

            // Delete old related data and recreate
            $lead->jobExperiences()->delete();
            $lead->englishLanguages()->delete();
            $lead->examTypes()->delete();

            if ($request->job_experience) {
                foreach ($request->job_experience as $experience) {
                    JobExprience::create(array_merge($experience, ['user_id' => $lead->id]));
                }
            }

            if ($request->english_test) {
                foreach ($request->english_test as $test) {
                    EnglishLanguage::create(array_merge($test, ['user_id' => $lead->id]));
                }
            }

            if ($request->exam) {
                foreach ($request->exam as $exam) {
                    ExamType::create(array_merge($exam, ['user_id' => $lead->id]));
                }
            }
        });

        return redirect()->route('leads.index')->with('success', 'Lead updated successfully');
    }

  
}

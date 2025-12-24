<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Source;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;

class LeadsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::latest()->get();
        $status = Status::where('status',1)->get();
        $source = Source::where('status',1)->get();
        $country = Country::where('status',1)->get();
        return view('users.index', compact('data','status','source','country'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not needed, we use sidebar
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                       => 'required|string|max:255',
            'email'                      => 'required|email|unique:users,email',
            'phone'                      => 'nullable|unique:users,phone',
            'additional_phone'           => 'nullable|string|max:20',
            'dob'                        => 'nullable|string|max:50',
            'country'                    => 'nullable|string',
            'preferred_country'          => 'nullable|string',
            'city'                       => 'nullable|string',
            'address'                    => 'nullable|string',
            'personal_information'       => 'nullable|string',
            'additional_information'     => 'nullable|string',
            'date_of_contact'            => 'nullable|string',
            'status_id'                  => 'nullable|string',
            'source_id'                  => 'nullable|string',
            'assigned_id'                => 'nullable|string',
            'how_did_hear_about_us'      => 'nullable|string',
            'type'                       => 'nullable|string',
            'image'                      => 'nullable|string',

            // Job Experience validation
            'job_experiences'            => 'nullable|array',
            'job_experiences.*.company_name' => 'nullable|string',
            'job_experiences.*.job_title' => 'nullable|string',
            'job_experiences.*.duration' => 'nullable|string',
            'job_experiences.*.joining_date' => 'nullable|string',
            'job_experiences.*.end_date' => 'nullable|string',
            'job_experiences.*.company_address' => 'nullable|string',

            // English Language validation
            'english_language.duolingo' => 'nullable|string',
            'english_language.ielts_overall' => 'nullable|string',
            'english_language.ielts_listening' => 'nullable|string',
            'english_language.ielts_writing' => 'nullable|string',
            'english_language.ielts_speaking' => 'nullable|string',
            'english_language.ielts_reading' => 'nullable|string',
            'english_language.moi' => 'nullable|string',
            'english_language.oietc' => 'nullable|string',
            'english_language.pte_overall' => 'nullable|string',
            'english_language.pte_listening' => 'nullable|string',
            'english_language.pte_speaking' => 'nullable|string',
            'english_language.pte_writing' => 'nullable|string',
            'english_language.pte_reading' => 'nullable|string',
            'english_language.toefl' => 'nullable|string',

            // Exam Types validation
            'exam_types'                 => 'nullable|array',
            'exam_types.*.exam_type'     => 'nullable|string',
            'exam_types.*.institute_name' => 'nullable|string',
            'exam_types.*.major_subject' => 'nullable|string',
            'exam_types.*.result'        => 'nullable|string',
            'exam_types.*.passing_year'  => 'nullable|string',
            'exam_types.*.country'       => 'nullable|string',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        // Create user
        $user = User::create($validated);

        // Save Job Experiences
        if ($request->has('job_experiences')) {
            foreach ($request->job_experiences as $experience) {
                if (!empty(array_filter($experience))) {
                    $user->jobExperiences()->create($experience);
                }
            }
        }

        // Save English Language
        if ($request->has('english_language')) {
            $englishData = array_filter($request->english_language);
            if (!empty($englishData)) {
                $user->englishLanguage()->create($englishData);
            }
        }

        // Save Exam Types
        if ($request->has('exam_types')) {
            foreach ($request->exam_types as $exam) {
                if (!empty(array_filter($exam))) {
                    $user->examTypes()->create($exam);
                }
            }
        }

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('users.index')
            ->with('success', 'User created successfully!');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'                       => 'required|string|max:255',
            'email'                      => 'required|email|unique:users,email,' . $user->id,
            'phone'                      => 'nullable|unique:users,phone,' . $user->id,
            'additional_phone'           => 'nullable|string|max:20',
            'dob'                        => 'nullable|string|max:50',
            'country'                    => 'nullable|string',
            'preferred_country'          => 'nullable|string',
            'city'                       => 'nullable|string',
            'address'                    => 'nullable|string',
            'personal_information'       => 'nullable|string',
            'additional_information'     => 'nullable|string',
            'date_of_contact'            => 'nullable|string',
            'status_id'                  => 'nullable|string',
            'source_id'                  => 'nullable|string',
            'assigned_id'                => 'nullable|string',
            'how_did_hear_about_us'      => 'nullable|string',
            'password'                   => 'nullable|string|min:6',
            'type'                       => 'nullable|string',
            'image'                      => 'nullable|string',

            // Job Experience validation
            'job_experiences'            => 'nullable|array',
            'job_experiences.*.company_name' => 'nullable|string',
            'job_experiences.*.job_title' => 'nullable|string',
            'job_experiences.*.duration' => 'nullable|string',
            'job_experiences.*.joining_date' => 'nullable|string',
            'job_experiences.*.end_date' => 'nullable|string',
            'job_experiences.*.company_address' => 'nullable|string',

            // English Language validation
            'english_language.duolingo' => 'nullable|string',
            'english_language.ielts_overall' => 'nullable|string',
            'english_language.ielts_listening' => 'nullable|string',
            'english_language.ielts_writing' => 'nullable|string',
            'english_language.ielts_speaking' => 'nullable|string',
            'english_language.ielts_reading' => 'nullable|string',
            'english_language.moi' => 'nullable|string',
            'english_language.oietc' => 'nullable|string',
            'english_language.pte_overall' => 'nullable|string',
            'english_language.pte_listening' => 'nullable|string',
            'english_language.pte_speaking' => 'nullable|string',
            'english_language.pte_writing' => 'nullable|string',
            'english_language.pte_reading' => 'nullable|string',
            'english_language.toefl' => 'nullable|string',

            // Exam Types validation
            'exam_types'                 => 'nullable|array',
            'exam_types.*.exam_type'     => 'nullable|string',
            'exam_types.*.institute_name' => 'nullable|string',
            'exam_types.*.major_subject' => 'nullable|string',
            'exam_types.*.result'        => 'nullable|string',
            'exam_types.*.passing_year'  => 'nullable|string',
            'exam_types.*.country'       => 'nullable|string',
        ]);

        // Only update password if provided
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        // Update Job Experiences
        $user->jobExperiences()->delete();
        if ($request->has('job_experiences')) {
            foreach ($request->job_experiences as $experience) {
                if (!empty(array_filter($experience))) {
                    $user->jobExperiences()->create($experience);
                }
            }
        }

        // Update English Language
        $user->englishLanguage()->delete();
        if ($request->has('english_language')) {
            $englishData = array_filter($request->english_language);
            if (!empty($englishData)) {
                $user->englishLanguage()->create($englishData);
            }
        }

        // Update Exam Types
        $user->examTypes()->delete();
        if ($request->has('exam_types')) {
            foreach ($request->exam_types as $exam) {
                if (!empty(array_filter($exam))) {
                    $user->examTypes()->create($exam);
                }
            }
        }

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully!');
    }
}

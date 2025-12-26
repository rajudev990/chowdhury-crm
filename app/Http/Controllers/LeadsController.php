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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::with(['jobexpriences', 'englishlanguages', 'examtypes', 'status', 'source'])
            ->latest()
            ->get();
        $status = Status::where('status', 1)->get();
        $source = Source::where('status', 1)->get();
        $country = Country::where('status', 1)->get();
        return view('users.index', compact('data', 'status', 'source', 'country'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            Log::info('Edit request for user ID: ' . $id);

            $user = User::with(['jobexpriences', 'englishlanguages', 'examtypes', 'status', 'source',])
                ->findOrFail($id);

            Log::info('User data found:', ['user_id' => $user->id, 'name' => $user->name]);

            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('User not found with ID: ' . $id);
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Edit Error: ' . $e->getMessage());
            Log::error('Stack Trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error fetching user: ' . $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Log incoming data for debugging
        Log::info('Store Request Data:', $request->all());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20|unique:users,phone',
            'status_id' => 'required',
            'source_id' => 'required',
            'assigned_id' => 'required',
        ]);

        DB::beginTransaction();

        try {
            // Create Lead with proper null handling
            $lead = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'additional_phone' => $request->additional_phone,
                'dob' => $request->dob,
                'country' => $request->country ? (int)$request->country : null,
                'city' => $request->city,
                'address' => $request->address,
                'personal_information' => $request->personal_information,
                'additional_information' => $request->additional_information,
                'date_of_contact' => $request->date_of_contact,
                'status_id' => (int)$request->status_id,
                'source_id' => (int)$request->source_id,
                'assigned_id' => (int)$request->assigned_id,
                'how_did_hear_about_us' => $request->how_did_hear_about_us,
                'preferred_country' => $request->preferred_country ? (int)$request->preferred_country : null,
            ]);

            // Save Job Experiences
            if ($request->has('job_experiences') && is_array($request->job_experiences)) {
                foreach ($request->job_experiences as $experience) {
                    // Check if at least one field has value
                    $filtered = array_filter($experience, function ($value) {
                        return !is_null($value) && $value !== '';
                    });

                    if (!empty($filtered)) {
                        JobExprience::create([
                            'user_id' => $lead->id,
                            'company_name' => $experience['company_name'] ?? null,
                            'job_title' => $experience['job_title'] ?? null,
                            'duration' => $experience['duration'] ?? null,
                            'joining_date' => !empty($experience['joining_date']) ? $experience['joining_date'] : null,
                            'end_date' => !empty($experience['end_date']) ? $experience['end_date'] : null,
                            'company_address' => $experience['company_address'] ?? null,
                        ]);
                    }
                }
            }

            // Save English Language Tests
            if ($request->has('english_language') && is_array($request->english_language)) {
                foreach ($request->english_language as $test) {
                    // Check if any field has value
                    $filtered = array_filter($test, function ($value) {
                        return !is_null($value) && $value !== '';
                    });

                    if (!empty($filtered)) {
                        EnglishLanguage::create([
                            'user_id' => $lead->id,
                            'ielts_overall' => $test['ielts_overall'] ?? null,
                            'ielts_listening' => $test['ielts_listening'] ?? null,
                            'ielts_reading' => $test['ielts_reading'] ?? null,
                            'ielts_writing' => $test['ielts_writing'] ?? null,
                            'ielts_speaking' => $test['ielts_speaking'] ?? null,
                            'pte_overall' => $test['pte_overall'] ?? null,
                            'pte_listening' => $test['pte_listening'] ?? null,
                            'pte_reading' => $test['pte_reading'] ?? null,
                            'pte_writing' => $test['pte_writing'] ?? null,
                            'pte_speaking' => $test['pte_speaking'] ?? null,
                            'toefl' => $test['toefl'] ?? null,
                            'duolingo' => $test['duolingo'] ?? null,
                            'moi' => $test['moi'] ?? null,
                            'oietc' => $test['oietc'] ?? null,
                        ]);
                    }
                }
            }

            // Save Education/Exam Types
            if ($request->has('exam_types') && is_array($request->exam_types)) {
                foreach ($request->exam_types as $exam) {
                    // Check if at least one field has value
                    $filtered = array_filter($exam, function ($value) {
                        return !is_null($value) && $value !== '';
                    });

                    if (!empty($filtered)) {
                        ExamType::create([
                            'user_id' => $lead->id,
                            'exam_type' => $exam['exam_type'] ?? null,
                            'institute_name' => $exam['institute_name'] ?? null,
                            'major_subject' => $exam['major_subject'] ?? null,
                            'result' => $exam['result'] ?? null,
                            'passing_year' => $exam['passing_year'] ?? null,
                            'country' => $exam['country'] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Lead created successfully!',
                'data' => $lead
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lead Store Error: ' . $e->getMessage());
            Log::error('Stack Trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error creating lead: ' . $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Log incoming data for debugging
        Log::info('Update Request Data for ID ' . $id . ':', $request->all());

        // Log only phone related fields
        Log::info('Phone fields:', [
            'phone' => $request->phone,
            'additional_phone' => $request->additional_phone,
        ]);

        // Check for any unexpected phone fields
        $allKeys = array_keys($request->all());
        $phoneKeys = array_filter($allKeys, function ($key) {
            return strpos($key, 'phone') !== false;
        });
        Log::info('All phone-related keys in request:', $phoneKeys);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone' => 'required|string|unique:users,phone,' . $id,
            'status_id' => 'required',
            'source_id' => 'required',
            'assigned_id' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $lead = User::findOrFail($id);

            // Update Lead with proper null handling - ONLY specified fields
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'additional_phone' => $request->additional_phone,
                'dob' => $request->dob,
                'country' => $request->country ? (int)$request->country : null,
                'city' => $request->city,
                'address' => $request->address,
                'personal_information' => $request->personal_information,
                'additional_information' => $request->additional_information,
                'date_of_contact' => $request->date_of_contact,
                'status_id' => (int)$request->status_id,
                'source_id' => (int)$request->source_id,
                'assigned_id' =>$request->assigned_id,
                'how_did_hear_about_us' => $request->how_did_hear_about_us,
                'preferred_country' => $request->preferred_country ? (int)$request->preferred_country : null,
            ];

            Log::info('Update data prepared:', $updateData);

            $lead->update($updateData);

            // Delete old related records
            $lead->jobexpriences()->delete();
            $lead->englishlanguages()->delete();
            $lead->examtypes()->delete();

            // Save Job Experiences
            if ($request->has('job_experiences') && is_array($request->job_experiences)) {
                foreach ($request->job_experiences as $experience) {
                    // Check if at least one field has value
                    $filtered = array_filter($experience, function ($value) {
                        return !is_null($value) && $value !== '';
                    });

                    if (!empty($filtered)) {
                        JobExprience::create([
                            'user_id' => $lead->id,
                            'company_name' => $experience['company_name'] ?? null,
                            'job_title' => $experience['job_title'] ?? null,
                            'duration' => $experience['duration'] ?? null,
                            'joining_date' => !empty($experience['joining_date']) ? $experience['joining_date'] : null,
                            'end_date' => !empty($experience['end_date']) ? $experience['end_date'] : null,
                            'company_address' => $experience['company_address'] ?? null,
                        ]);
                    }
                }
            }

            // Save English Language Tests
            if ($request->has('english_language') && is_array($request->english_language)) {
                foreach ($request->english_language as $test) {
                    // Check if any field has value
                    $filtered = array_filter($test, function ($value) {
                        return !is_null($value) && $value !== '';
                    });

                    if (!empty($filtered)) {
                        EnglishLanguage::create([
                            'user_id' => $lead->id,
                            'ielts_overall' => $test['ielts_overall'] ?? null,
                            'ielts_listening' => $test['ielts_listening'] ?? null,
                            'ielts_reading' => $test['ielts_reading'] ?? null,
                            'ielts_writing' => $test['ielts_writing'] ?? null,
                            'ielts_speaking' => $test['ielts_speaking'] ?? null,
                            'pte_overall' => $test['pte_overall'] ?? null,
                            'pte_listening' => $test['pte_listening'] ?? null,
                            'pte_reading' => $test['pte_reading'] ?? null,
                            'pte_writing' => $test['pte_writing'] ?? null,
                            'pte_speaking' => $test['pte_speaking'] ?? null,
                            'toefl' => $test['toefl'] ?? null,
                            'duolingo' => $test['duolingo'] ?? null,
                            'moi' => $test['moi'] ?? null,
                            'oietc' => $test['oietc'] ?? null,
                        ]);
                    }
                }
            }

            // Save Education/Exam Types
            if ($request->has('exam_types') && is_array($request->exam_types)) {
                foreach ($request->exam_types as $exam) {
                    // Check if at least one field has value
                    $filtered = array_filter($exam, function ($value) {
                        return !is_null($value) && $value !== '';
                    });

                    if (!empty($filtered)) {
                        ExamType::create([
                            'user_id' => $lead->id,
                            'exam_type' => $exam['exam_type'] ?? null,
                            'institute_name' => $exam['institute_name'] ?? null,
                            'major_subject' => $exam['major_subject'] ?? null,
                            'result' => $exam['result'] ?? null,
                            'passing_year' => $exam['passing_year'] ?? null,
                            'country' => $exam['country'] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Lead updated successfully!',
                'data' => $lead->fresh(['jobexpriences', 'englishlanguages', 'examtypes'])
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lead Update Error: ' . $e->getMessage());
            Log::error('Stack Trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error updating lead: ' . $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);

            // Delete related records first
            $user->jobexpriences()->delete();
            $user->englishlanguages()->delete();
            $user->examtypes()->delete();

            // Delete the user
            $user->delete();

            DB::commit();

            return redirect()->route('leads.index')
                ->with('success', 'Lead deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lead Delete Error: ' . $e->getMessage());

            return redirect()->route('leads.index')
                ->with('error', 'Error deleting lead: ' . $e->getMessage());
        }
    }
}

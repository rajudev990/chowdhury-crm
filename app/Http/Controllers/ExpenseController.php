<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view expenses')->only('index');
        $this->middleware('permission:create expenses')->only(['create', 'store']);
        $this->middleware('permission:edit expenses')->only(['edit', 'update']);
        $this->middleware('permission:delete expenses')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::latest()->paginate(10);
        return view('expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::where('type', 'admin')->latest()->get();
        return view('expenses.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'expense_date' => 'required|date',
            'payment_method' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'nullable',
            'attachment' => 'nullable',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        // Prepare data array
        $data = [
            'title' => $request->title,
            'amount' => $request->amount,
            'category' => $request->category,
            'expense_date' => $request->expense_date,
            'payment_method' => $request->payment_method,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'status' => $request->status,
        ];

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $data['attachment'] = ImageHelper::uploadImage($request->file('attachment'));
        }

        Expense::create($data);

        return redirect()->route('expenses.index')->with('success', 'Expense created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $expense = Expense::findOrFail($id);
        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $expense = Expense::findOrFail($id);
        $user = User::where('type', 'admin')->latest()->get();
        return view('expenses.create', compact('expense', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $expense = Expense::findOrFail($id);

        $request->validate([
            'title' => 'required|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'expense_date' => 'required|date',
            'payment_method' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'nullable',
            'attachment' => 'nullable',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        // Prepare data array
        $data = [
            'title' => $request->title,
            'amount' => $request->amount,
            'category' => $request->category,
            'expense_date' => $request->expense_date,
            'payment_method' => $request->payment_method,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'status' => $request->status,
        ];

        // Handle file upload
        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($expense->attachment) {
                Storage::disk('public')->delete($expense->attachment);
            }
            $data['attachment'] = ImageHelper::uploadImage($request->file('attachment'));
        }

        $expense->update($data);

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $expense = Expense::findOrFail($id);

        // Delete attachment if exists
        if ($expense->attachment) {
            Storage::disk('public')->delete($expense->attachment);
        }

        $expense->delete();

        return back()->with('success', 'Expense deleted successfully');
    }
}

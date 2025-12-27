@extends('layouts.app')
@section('title', isset($expense) ? 'Edit Expense' : 'Create Expense')
@section('content')
<div class="container mx-auto mt-3">
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-xl border border-gray-200">
        <h5 class="bg-[#1A3A66] font-semibold mb-6 p-2 text-xl text-white">
            {{ isset($expense) ? 'Edit Expense' : 'Create Expense' }}
        </h5>

        <!-- Error Messages -->
        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 mx-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Success Message -->
        @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 mx-6">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ isset($expense) ? route('expenses.update', $expense->id) : route('expenses.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="p-6">
            @csrf
            @if(isset($expense)) @method('PUT') @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- User -->
                <div>
                    <label for="user_id" class="block text-[#1A3A66] font-semibold mb-2">User</label>
                    <select name="user_id" id="user_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]">
                        <option value="">Select Option</option>
                        @foreach($user as $item)
                        <option value="{{$item->id}}" {{ old('user_id', isset($expense) ? $expense->user_id : '') == $item->id ? 'selected' : '' }}>
                            {{$item->name}}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-[#1A3A66] font-semibold mb-2">Title</label>
                    <input type="text" id="title" name="title"
                        value="{{ old('title', $expense->title ?? '') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]"
                        placeholder="Enter expense title" required>
                </div>

                <!-- Amount -->
                <div>
                    <label for="amount" class="block text-[#1A3A66] font-semibold mb-2">Amount</label>
                    <input type="number" id="amount" name="amount" step="0.01" min="0"
                        value="{{ old('amount', $expense->amount ?? '') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]"
                        placeholder="0.00" required>
                </div>

                <!-- Expense Date -->
               <div>
                    <label for="expense_date" class="block text-[#1A3A66] font-semibold mb-2">
                        Expense Date
                    </label>

                    <input
                        type="date"
                        id="expense_date"
                        name="expense_date"
                        value="{{ old(
                            'expense_date',
                            isset($expense) ? \Carbon\Carbon::parse($expense->expense_date)->format('Y-m-d') : ''
                        ) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg
                            focus:outline-none focus:ring-2 focus:ring-[#1A3A66]"
                        required
                    >
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-[#1A3A66] font-semibold mb-2">Category</label>
                    <input type="text" id="category" name="category"
                        value="{{ old('category', $expense->category ?? '') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]"
                        placeholder="e.g., Travel, Food, Office">
                </div>

                <!-- Payment Method -->
                <div>
                    <label for="payment_method" class="block text-[#1A3A66] font-semibold mb-2">Payment Method</label>
                    <select id="payment_method" name="payment_method"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]">
                        <option value="">Select payment method</option>
                        <option value="Cash" {{ old('payment_method', $expense->payment_method ?? '') == 'Cash' ? 'selected' : '' }}>Cash</option>
                        <option value="Credit Card" {{ old('payment_method', $expense->payment_method ?? '') == 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                        <option value="Debit Card" {{ old('payment_method', $expense->payment_method ?? '') == 'Debit Card' ? 'selected' : '' }}>Debit Card</option>
                        <option value="Bank Transfer" {{ old('payment_method', $expense->payment_method ?? '') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="Mobile Payment" {{ old('payment_method', $expense->payment_method ?? '') == 'Mobile Payment' ? 'selected' : '' }}>Mobile Payment</option>
                    </select>
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-[#1A3A66] font-semibold mb-2">Description</label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]"
                        placeholder="Enter expense description">{{ old('description', $expense->description ?? '') }}</textarea>
                </div>

                <!-- Attachment -->
                <div>
                    <label for="attachment" class="block text-[#1A3A66] font-semibold mb-2">Attachment (Invoice/Receipt)</label>
                    <input type="file" id="attachment" name="attachment"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]">
                    @if(isset($expense) && $expense->attachment)
                    <div class="mt-2">
                        <a href="{{ Storage::url($expense->attachment) }}" target="_blank"
                            class="text-[#1A3A66] hover:underline text-sm">
                            <i class="fa-solid fa-paperclip"></i> View Current Attachment
                        </a>
                    </div>
                    @endif
                </div>


                  <!-- Status -->
                <div >
                    <label for="status" class="block text-[#1A3A66] font-semibold mb-2">Status</label>
                    <select id="status" name="status"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]"
                        required>
                        <option value="pending" {{ old('status', $expense->status ?? 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ old('status', $expense->status ?? '') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ old('status', $expense->status ?? '') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('expenses.index') }}"
                    class="px-4 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-300">
                    Cancel
                </a>
                <button type="submit"
                    class="px-4 py-3 bg-[#1A3A66] text-white rounded-lg hover:bg-[#163258] transition duration-300 focus:outline-none focus:ring-2 focus:ring-[#1A3A66]">
                    {{ isset($expense) ? 'Update Expense' : 'Create Expense' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
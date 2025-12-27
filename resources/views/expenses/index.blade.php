@extends('layouts.app')
@section('title','Expenses')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">

            <div class="p-4 bg-white rounded-xl shadow-md">

                <div class="flex justify-end mb-6">
                    <a href="{{ route('expenses.create') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg bg-[#1A3A66] text-white hover:bg-[#163258] transition shadow-md">
                        <span class="text-xl">+</span>
                        New Expense
                    </a>
                </div>

                <!-- Success Message -->
                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Error Message -->
                @if (session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-50">
                            <tr class="text-sm font-semibold text-gray-700">
                                <th class="px-6 py-4 text-left">#</th>
                                <th class="px-6 py-4 text-left">User</th>
                                <th class="px-6 py-4 text-left">Title</th>
                                <th class="px-6 py-4 text-left">Amount</th>
                                <th class="px-6 py-4 text-left">Date</th>
                                <th class="px-6 py-4 text-left">Payment Method</th>
                                <th class="px-6 py-4 text-left">Status</th>
                                <th class="px-6 py-4 text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y text-sm text-gray-700">
                            @forelse($expenses as $expense)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">{{ $expense->user?->name }}</td>
                                <td class="px-6 py-4">{{ $expense->title }}</td>
                                <td class="px-6 py-4">${{ number_format($expense->amount, 2) }}</td>
                              <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($expense->expense_date)->format('M d, Y') }}
                                </td>

                                <td class="px-6 py-4">{{ $expense->payment_method ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    @if($expense->status == 'approved')
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Approved</span>
                                    @elseif($expense->status == 'rejected')
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Rejected</span>
                                    @else
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-1">
                                        @if($expense->attachment)
                                            <a href="{{ Storage::url($expense->attachment) }}" target="_blank"
                                               class="w-8 h-8 flex items-center justify-center
                                                      text-[#9CA3AF] rounded-full
                                                      hover:text-[#1A3A66] transition" title="View Attachment">
                                                <i class="fa-solid fa-paperclip"></i>
                                            </a>
                                        @endif

                                        <a href="{{ route('expenses.edit', $expense->id) }}"
                                           class="w-8 h-8 flex items-center justify-center
                                                  text-[#9CA3AF] rounded-full
                                                  hover:text-[#1A3A66] transition" title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this expense?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="w-8 h-8 flex items-center justify-center
                                                           rounded-full hover:text-[#1A3A66]
                                                           text-[#9CA3AF] transition" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                    No expenses found. Create your first expense to get started.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>

                    <div class="mt-4">
                        {{ $expenses->links() }}
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
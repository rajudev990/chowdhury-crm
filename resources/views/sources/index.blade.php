@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">

            <div class="p-4 bg-white rounded-xl shadow-md">

                <!-- Button -->
                <div class="flex justify-end mb-6">
                    <button
                        type="button"
                        onclick="openStatusSidebar()"
                        class="inline-flex items-center gap-2 px-5 py-2
                               border border-[#1A3A66] text-[#1A3A66] rounded-lg
                               hover:bg-[#1A3A66] hover:text-white
                               transition duration-300">
                        <span class="text-xl">+</span>
                        New Source
                    </button>
                </div>


                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-50">
                            <tr class="text-sm font-semibold text-gray-700">
                                <th class="px-6 py-4 text-left">#</th>
                                <th class="px-6 py-4 text-left">Name</th>
                                <th class="px-6 py-4 text-left">Status</th>
                                <th class="px-6 py-4 text-center">Actions</th>
                            </tr>
                        </thead>


                        <tbody class="divide-y text-sm text-gray-700">
                            @foreach($data as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>

                                <td class="px-6 py-4">{{ $item->name }}</td>

                                <td class="px-6 py-4">
                                    @if($item->status == 1)
                                    <span class="px-3 py-1 bg-[#1A3A66] text-white font-bold rounded-full text-xs">
                                        Active
                                    </span>
                                    @else
                                    <span class="px-3 py-1 bg-[#9CA3AF] text-white font-bold rounded-full text-xs">
                                        Inactive
                                    </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-1">
                                        <button
                                            onclick="openEditSidebar({{ $item->id }}, '{{ $item->name }}', {{ $item->status }})"
                                            class="w-8 h-8 flex items-center justify-center
                                                    text-[#9CA3AF] rounded-full
                                                   hover:text-[#1A3A66] transition" title="Edit">
                                            <i class="fa-solid fa-pen"></i> 
                                        </button>

                                        <form action="{{ route('sources.destroy', $item->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="w-8 h-8 flex items-center justify-center
                                                            rounded-full  hover:text-[#1A3A66]
                                                            text-[#9CA3AF] transition" title="Delete">
                                                <i class="fa-solid fa-trash "></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>

                   

                </div>

            </div>
        </div>
    </div>
</div>

@endsection
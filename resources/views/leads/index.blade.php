@extends('layouts.app')
@section('title','Leads')
@section('content')
<div class="max-w-full mx-auto bg-white rounded-lg shadow-sm my-4">
    
    <div class="max-w-full mx-auto bg-white rounded-lg shadow-sm my-4">
    <!-- Top Action Bar -->
    <form method="GET" action="{{ route('leads.index') }}">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between bg-white p-4 rounded-xl shadow-sm">

            <!-- Search Box -->
            <div class="relative w-full md:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search in table..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]/30 focus:border-[#1A3A66]" />
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3">
                <button class="flex items-center gap-2 px-4 py-2 border rounded-lg text-[#1A3A66] border-[#1A3A66] hover:bg-[#1A3A66] hover:text-white transition">
                    <i class="fas fa-chart-line"></i> Summary
                </button>
                <button class="flex items-center gap-2 px-4 py-2 border rounded-lg text-[#1A3A66] border-[#1A3A66] hover:bg-[#1A3A66] hover:text-white transition">
                    <i class="fas fa-upload"></i> Import
                </button>
                <a href="{{ route('leads.create') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-[#1A3A66] text-white hover:bg-[#163258] transition shadow-md">
                    <i class="fas fa-plus"></i> New Lead
                </a>
            </div>
        </div>

        <div class="p-4 border-b border-gray-200">
            <div class="flex flex-wrap gap-3 items-center justify-between">
                <!-- Filter Dropdowns -->
                <div class="flex flex-wrap gap-3 flex-1 min-w-0">

                    <!-- Status -->
                    <div class="relative">
                        <select name="status" class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2.5 pr-10 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent min-w-[150px]">
                            <option value="">Status</option>
                            @foreach ($status as $item)
                                <option value="{{ $item->id }}" {{ request('status') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                    </div>

                    <!-- Source -->
                    <div class="relative">
                        <select name="source" class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2.5 pr-10 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent min-w-[150px]">
                            <option value="">Sources</option>
                            @foreach ($source as $item)
                                <option value="{{ $item->id }}" {{ request('source') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                    </div>

                    <!-- Assignee -->
                    <div class="relative">
                        <select name="assigned" class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2.5 pr-10 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent min-w-[150px]">
                            <option value="">Assignees</option>
                            @foreach ($users as $item)
                                <option value="{{ $item->id }}" {{ request('assigned') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                    </div>

                    <!-- Followup Date -->
                    <div class="relative min-w-[180px]">
                        <input type="text" name="followup_date" value="{{ request('followup_date') }}"
                               class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               onfocus="this.type='date'" 
                                onblur="if(!this.value)this.type='text'" 
                                placeholder="Followup Date">
                    </div>

                    <!-- Appointment Date -->
                    <div class="relative min-w-[180px]">
                        <input type="text" name="appointment_date" value="{{ request('appointment_date') }}"
                               class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               onfocus="this.type='date'" 
                                onblur="if(!this.value)this.type='text'" 
                                placeholder="Appointment Date">
                    </div>

                </div>

                <!-- Filter & Reset Buttons -->
                <div class="flex gap-2 mt-2 md:mt-0">
                    <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-6 py-2.5 rounded-lg transition-colors">
                        Filter
                    </button>
                    <a href="{{ route('leads.index') }}" class="text-gray-500 hover:text-gray-700 font-medium px-4 py-2.5 transition-colors">Reset Filter</a>
                </div>
            </div>
        </div>
    </form>
</div>


    <!-- Table Container with Horizontal Scroll -->
    <div class="overflow-x-auto">
        <table class="w-full min-w-max">
            <!-- Table Header -->
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left">
                        <input type="checkbox"
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    </th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">Name
                    </th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">Phone
                    </th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">Email
                    </th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">
                        Assigned</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">
                        Followup Date</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">
                        Appointment Date</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">Notes
                    </th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">
                        Preferred Countries</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">Source
                    </th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">Actions
                    </th>
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody class="divide-y divide-gray-200">
                <!-- Row 1 -->
                @foreach ($leads as $item)

                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-4">
                        <input type="checkbox"
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $item->name }}</td>
                    <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $item->phone }}</td>
                    <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $item->email }}</td>
                    <td class="px-4 py-4">
                        <div class="flex items-center justify-center w-8 h-8 bg-gray-400 rounded-full text-white text-sm font-medium"
                            title="{{ $item->assignedUser?->name ?? 'Unassigned' }}">
                            {{ strtoupper(substr($item->assignedUser?->name ?? 'U', 0, 1)) }}
                        </div>
                    </td>

                     <td class="px-4 py-4 text-center">
                        <input type="date" value="{{ $item->follow_up_date }}"
                            onchange="updateDate({{ $item->id }}, 'follow_up_date', this.value)"
                            class="border rounded px-2 py-1">
                    </td>


                    <td class="px-4 py-4 text-center">
                        <input type="date" value="{{ $item->appointment_date }}"
                            onchange="updateDate({{ $item->id }}, 'appointment_date', this.value)"
                            class="border rounded px-2 py-1">
                    </td>

                   





                    <td class="px-4 py-4 text-center">
                        <button class="text-gray-400 hover:text-gray-600 open-notes" data-user-id="{{ $item->id }}">
                            <i class="fas fa-pencil text-lg"></i>
                        </button>
                    </td>

                    <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $item->preferred_country }}</td>
                    <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $item->source->name }}</td>
                    <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap">
                        <div class="flex">
                            <a href="{{ route('leads.show', $item->id) }}" class="w-8 h-8 flex items-center justify-center
                                        text-[#9CA3AF] rounded-full
                                        hover:text-[#1A3A66] transition" title="Details">
                                <i class="fas fa-sliders-h mr-2 text-gray-400"></i>
                            </a>

                            <a href="{{ route('leads.edit', $item->id) }}" class="w-8 h-8 flex items-center justify-center
                                        text-[#9CA3AF] rounded-full
                                        hover:text-[#1A3A66] transition" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <form action="{{ route('leads.destroy', $item->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button class="w-8 h-8 flex items-center justify-center
                                                rounded-full  hover:text-[#1A3A66]
                                                text-[#9CA3AF] transition" title="Delete">
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
</div>


{{-- Notes --}}
<!-- Notes Modal -->
<div id="notesModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white w-full max-w-lg rounded-lg shadow-lg relative">

        <!-- Header -->
        <div class="flex justify-between items-center px-4 py-2 bg-[#1A3A66] text-white">
            <h4 class="font-semibold">Customer Notes</h4>
            <button id="closeNotesModal">&times;</button>
        </div>

        <!-- Body -->
        <div class="p-4">
            <input type="hidden" id="noteUserId">
            <input type="hidden" id="noteId">

            <textarea rows="5" cols="5" id="noteText" class="w-full border rounded p-2"
                placeholder="Write note..."></textarea>
            <p class="text-red-500 text-sm mt-1 hidden" id="noteError"></p>

            <button id="saveNote" class="mt-3 bg-[#1A3A66] text-white px-4 py-2 rounded">
                Save Note
            </button>

            <hr class="my-4">

            <div id="notesList" class="space-y-2"></div>
        </div>
    </div>
</div>



@endsection

@section('js')

<script>
    function updateDate(id, field, value) {
    fetch(`/users/update-date/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            field: field,
            value: value
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: data.message,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        } else {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Update failed',
                showConfirmButton: false,
                timer: 3000,
            });
        }
    })
    .catch(err => {
        console.error(err);
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Something went wrong',
            showConfirmButton: false,
            timer: 3000,
        });
    });
}
</script>

{{-- UserNotes --}}
<script>
    let modal = $('#notesModal');

// OPEN MODAL
$('.open-notes').click(function(){
    let userId = $(this).data('user-id');
    $('#noteUserId').val(userId);
    $('#noteId').val('');
    $('#noteText').val('');
    $('#noteError').addClass('hidden');

    modal.removeClass('hidden');
    loadNotes(userId);
});

// CLOSE MODAL
$('#closeNotesModal').click(()=> modal.addClass('hidden'));

// LOAD NOTES
function loadNotes(userId){
    $.get(`/users/${userId}/notes`, function(notes){
        let html = '';
        notes.forEach(n=>{
            html += `
            <div class="border p-2 rounded flex justify-between items-center">
                <span class="note-text">${n.note}</span>
                <div>
                    <button class="edit-note text-blue-500" data-id="${n.id}" data-note="${n.note}"><i class="fa-solid fa-pen"></i></button>
                    <button class="delete-note text-red-500 ml-2" data-id="${n.id}"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>`;
        });
        $('#notesList').html(html);
    });
}

// STORE / UPDATE
$('#saveNote').click(function(){
    let userId = $('#noteUserId').val();
    let noteId = $('#noteId').val();
    let note = $('#noteText').val();

    let url = noteId ? `/notes/${noteId}` : `/users/${userId}/notes`;
    let type = noteId ? 'PUT' : 'POST';

    $.ajax({
        url, type,
        data:{ note, _token:'{{ csrf_token() }}' },
        success(){
            Swal.fire({
                toast:true,
                position:'top-end',
                icon:'success',
                title:'Note saved',
                timer:2000,
                showConfirmButton:false
            });
            $('#noteText').val('');
            $('#noteId').val('');
            loadNotes(userId);
        },
        error(xhr){
            $('#noteError').removeClass('hidden').text(xhr.responseJSON.message);
        }
    });
});

// EDIT
$(document).on('click','.edit-note',function(){
    $('#noteId').val($(this).data('id'));
    $('#noteText').val($(this).data('note'));
});

// DELETE
$(document).on('click','.delete-note',function(){
    let id = $(this).data('id');
    let userId = $('#noteUserId').val();

    $.ajax({
        url:`/notes/${id}`,
        type:'DELETE',
        data:{ _token:'{{ csrf_token() }}' },
        success(){
            Swal.fire({
                toast:true,
                position:'top-end',
                icon:'success',
                title:'Note deleted',
                timer:2000,
                showConfirmButton:false
            });
            loadNotes(userId);
        }
    });
});
</script>

@endsection
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
                        New Status
                    </button>
                </div>


                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-50">
                            <tr class="text-sm font-semibold text-gray-700">
                                <th class="px-6 py-4 text-left">#</th>
                                <th class="px-6 py-4 text-left">Status Name</th>
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

                                        <form action="{{ route('statuses.destroy', $item->id) }}"
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

                    <!-- Overlay -->
                    <div id="statusOverlay"
                        class="fixed inset-0 bg-black/40 z-40 hidden"
                        onclick="closeStatusSidebar()"></div>

                    <!-- Sidebar -->
                    <div id="statusSidebar"
                        class="fixed top-0 right-0 h-full w-full sm:w-[420px] bg-white z-50
                        transform translate-x-full transition-transform duration-300">

                        <!-- Header -->
                        <div class="flex items-center gap-3 px-5 py-4 bg-[#1A3A66] text-white">
                            <button type="button" onclick="closeStatusSidebar()">←</button>
                            <h2 class="text-lg font-semibold" id="sidebarTitle">Add Project Status</h2>
                        </div>

                        <!-- Form -->
                        <form id="statusForm" action="{{ route('statuses.store') }}" method="POST" class="p-5 space-y-4">
                            @csrf
                            <input type="hidden" name="_method" id="formMethod" value="POST">

                            <!-- Validation Error Alert -->
                            <div id="validationError" class="hidden p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                                <p class="text-sm font-semibold">Error:</p>
                                <ul id="errorList" class="text-sm mt-1 list-disc list-inside"></ul>
                            </div>

                            <div>
                                <input type="text" name="name" id="statusName"
                                    placeholder="Name"
                                    class="w-full border rounded-lg px-4 py-2 focus:ring-[#1A3A66]"
                                    required />
                            </div>

                            <!-- Status Active/Inactive -->
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="status" id="statusActive" value="1" class="accent-[#1A3A66]">
                                Active?
                            </label>

                            <button type="submit" id="submitBtn"
                                class="w-full py-2 border border-[#1A3A66] text-[#1A3A66] rounded-lg
                                hover:bg-[#1A3A66] hover:text-white
                                transition duration-300">
                                + Add
                            </button>
                        </form>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    // Sidebar open for new status
    function openStatusSidebar() {
        document.getElementById('statusOverlay').classList.remove('hidden');
        document.getElementById('statusSidebar').classList.remove('translate-x-full');
        
        // Reset form for new entry
        document.getElementById('sidebarTitle').textContent = 'Add Project Status';
        document.getElementById('statusForm').action = '{{ route("statuses.store") }}';
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('statusName').value = '';
        document.getElementById('statusActive').checked = false;
        document.getElementById('submitBtn').textContent = '+ Add';
        
        // Hide validation errors
        document.getElementById('validationError').classList.add('hidden');
    }

    // Sidebar open for edit
    function openEditSidebar(id, name, status) {
        document.getElementById('statusOverlay').classList.remove('hidden');
        document.getElementById('statusSidebar').classList.remove('translate-x-full');
        
        // Set form for editing
        document.getElementById('sidebarTitle').textContent = 'Edit Project Status';
        document.getElementById('statusForm').action = '/statuses/' + id;
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('statusName').value = name;
        document.getElementById('statusActive').checked = (status == 1);
        document.getElementById('submitBtn').textContent = 'Update';
        
        // Hide validation errors
        document.getElementById('validationError').classList.add('hidden');
    }

    // Close sidebar
    function closeStatusSidebar() {
        document.getElementById('statusOverlay').classList.add('hidden');
        document.getElementById('statusSidebar').classList.add('translate-x-full');
    }

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeStatusSidebar();
        }
    });

    // AJAX Form Submission
    document.getElementById('statusForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const formData = new FormData(form);
        const submitBtn = document.getElementById('submitBtn');
        const errorDiv = document.getElementById('validationError');
        const errorList = document.getElementById('errorList');
        
        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.textContent = 'Processing...';
        
        // Hide previous errors
        errorDiv.classList.add('hidden');
        errorList.innerHTML = '';

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Success - reload page
                window.location.reload();
            } else {
                // Show validation errors
                if (data.errors) {
                    for (let field in data.errors) {
                        data.errors[field].forEach(error => {
                            const li = document.createElement('li');
                            li.textContent = error;
                            errorList.appendChild(li);
                        });
                    }
                    errorDiv.classList.remove('hidden');
                }
            }
            
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.textContent = document.getElementById('formMethod').value === 'POST' ? '+ Add' : 'Update';
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Show generic error
            const li = document.createElement('li');
            li.textContent = 'Something went wrong. Please try again.';
            errorList.appendChild(li);
            errorDiv.classList.remove('hidden');
            
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.textContent = document.getElementById('formMethod').value === 'POST' ? '+ Add' : 'Update';
        });
    });

    // Check if there are validation errors on page load
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            // Open sidebar if there are errors
            @if(session('edit_id'))
                openEditSidebar({{ session('edit_id') }}, '{{ session('edit_name') }}', {{ session('edit_status') }});
            @else
                openStatusSidebar();
            @endif
            
            // Show errors
            const errorDiv = document.getElementById('validationError');
            const errorList = document.getElementById('errorList');
            
            @foreach($errors->all() as $error)
                const li = document.createElement('li');
                li.textContent = '{{ $error }}';
                errorList.appendChild(li);
            @endforeach
            
            errorDiv.classList.remove('hidden');
        });
    @endif
</script>
@endsection
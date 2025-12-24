@extends('layouts.app')

@section('content')

<!-- Profile Sidebar -->
<div id="profileSidebar"
    class="fixed top-0 right-0 w-[380px] h-full bg-white shadow-2xl
            transform translate-x-full transition-transform duration-300 z-50">

    <!-- Header -->
    <div class="flex justify-between items-center px-5 py-4 border-b">
        <h2 class="text-lg font-semibold">My Profile</h2>
        <button onclick="closeProfileSidebar()" class="text-gray-500 hover:text-red-500">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Body -->
    <div class="p-5 overflow-y-auto h-full">

        <form action="{{ route('profile.settings.update') }}"
            method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-4">
                <label class="block text-sm mb-1">Name</label>
                <input type="text" name="name"
                    value="{{ auth()->user()->name }}"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring"
                    required>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-sm mb-1">Email</label>
                <input type="email" name="email"
                    value="{{ auth()->user()->email }}"
                    class="w-full border rounded px-3 py-2"
                    required>
            </div>

            <!-- Phone -->
            <div class="mb-4">
                <label class="block text-sm mb-1">Phone</label>
                <input type="text" name="phone"
                    value="{{ auth()->user()->phone }}"
                    class="w-full border rounded px-3 py-2">
            </div>

            <!-- Image -->
            <div class="mb-4 text-center">
                <img id="previewImage"
                    src="{{ auth()->user()->image ? asset('storage/'.auth()->user()->image) : asset('images/user.png') }}"
                    class="w-24 h-24 rounded-full mx-auto mb-2 object-cover">

                <input type="file" name="image" class="w-full text-sm"
                    onchange="previewProfileImage(event)">
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Update Profile
            </button>
        </form>

    </div>
</div>


@endsection

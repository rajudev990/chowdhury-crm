@extends('layouts.app')
@section('title','Change Password')

@section('content')
<div class="container mx-auto mt-6">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-xl border border-gray-200">
        <h5 class="text-3xl font-semibold text-[#1A3A66] mb-6">Update Password</h5>

        <!-- Error messages from server -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Success message -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('change.password.update') }}" method="POST" onsubmit="return validatePasswordForm()">
            @csrf
            @method('PUT')

            <!-- Current Password -->
            <div class="mb-6 relative">
                <label for="current_password" class="block text-[#1A3A66] font-semibold mb-2">Current Password</label>
                <div class="relative">
                    <input type="password" id="current_password" name="current_password"
                        placeholder="Enter your current password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]" required>
                    <i class="fa-solid fa-eye absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer text-[#1A3A66]"
                       onclick="togglePassword('current_password', this)"></i>
                    <p id="current_password_error" class="text-red-600 text-sm mt-1 hidden"></p>
                </div>
            </div>

            <!-- New Password -->
            <div class="mb-6 relative">
                <label for="new_password" class="block text-[#1A3A66] font-semibold mb-2">New Password</label>
                <div class="relative">
                    <input type="password" id="new_password" name="new_password"
                        placeholder="Enter your new password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]" required>
                    <i class="fa-solid fa-eye absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer text-[#1A3A66]"
                       onclick="togglePassword('new_password', this)"></i>
                    <p id="new_password_error" class="text-red-600 text-sm mt-1 hidden"></p>
                </div>
            </div>

            <!-- Confirm New Password -->
            <div class="mb-6 relative">
                <label for="new_password_confirmation" class="block text-[#1A3A66] font-semibold mb-2">Confirm New Password</label>
                <div class="relative">
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                        placeholder="Confirm your new password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]" required>
                    <i class="fa-solid fa-eye absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer text-[#1A3A66]"
                       onclick="togglePassword('new_password_confirmation', this)"></i>
                    <p id="confirm_password_error" class="text-red-600 text-sm mt-1 hidden"></p>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="w-full px-4 py-3 bg-[#1A3A66] text-white rounded-lg hover:bg-[#163158] transition duration-300 focus:outline-none focus:ring-2 focus:ring-[#1A3A66]">
                    Update Password
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Eye toggle function
    function togglePassword(inputId, icon) {
        const input = document.getElementById(inputId);
        if(input.type === 'password'){
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    // Client-side validation before submit
    function validatePasswordForm() {
        let valid = true;

        const current = document.getElementById('current_password');
        const newPass = document.getElementById('new_password');
        const confirmPass = document.getElementById('new_password_confirmation');

        const currentErr = document.getElementById('current_password_error');
        const newErr = document.getElementById('new_password_error');
        const confirmErr = document.getElementById('confirm_password_error');

        // reset
        currentErr.classList.add('hidden');
        newErr.classList.add('hidden');
        confirmErr.classList.add('hidden');

        if(current.value.trim() === '') {
            currentErr.innerText = 'Current password is required';
            currentErr.classList.remove('hidden');
            valid = false;
        }

        if(newPass.value.length < 6) {
            newErr.innerText = 'New password must be at least 6 characters';
            newErr.classList.remove('hidden');
            valid = false;
        }

        if(newPass.value !== confirmPass.value) {
            confirmErr.innerText = 'Passwords do not match';
            confirmErr.classList.remove('hidden');
            valid = false;
        }

        return valid; // false prevents submit
    }
</script>

@endsection

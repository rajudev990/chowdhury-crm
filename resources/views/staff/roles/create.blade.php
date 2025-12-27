@extends('layouts.app')
@section('title', isset($role) ? 'Edit Role' : 'Create Role')

@section('content')
<div class="container mx-auto mt-3">
    <div class="max-w-xl mx-auto bg-white rounded-lg shadow-xl border border-gray-200">
        <h5 class="bg-[#1A3A66] font-semibold mb-6 p-2 text-xl text-white">
            {{ isset($role) ? 'Edit Role' : 'Create Role' }}
        </h5>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ isset($role) ? route('roles.update', $role->id) : route('roles.store') }}" method="POST" class="p-6">
            @csrf
            @if(isset($role)) @method('PUT') @endif

            <!-- Role Name -->
            <div class="mb-6">
                <label for="name" class="block text-[#1A3A66] font-semibold mb-2">Role Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $role->name ?? '') }}" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]" required>
            </div>

            <!-- Permissions -->
            <div class="mb-6">
                <label for="permissions" class="block text-[#1A3A66] font-semibold mb-2">Assign Permissions</label>
                <select name="permissions[]" id="permissions" multiple
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]">
                    @foreach($permissions as $permission)
                        <option value="{{ $permission->name }}"
                            @if(isset($rolePermissions) && in_array($permission->name, $rolePermissions)) selected @endif>
                            {{ $permission->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-gray-500 text-sm mt-1">Hold Ctrl (Windows) / Command (Mac) to select multiple permissions</p>
            </div>

            <!-- Submit Button -->
            <div class="text-right">
                <button type="submit" 
                class="px-4 py-3 bg-[#1A3A66] text-white rounded-lg hover:bg-[#1A3A66] transition duration-300 focus:outline-none focus:ring-2 focus:ring-[#1A3A66]">
                {{ isset($role) ? 'Update Role' : 'Create Role' }}
            </button>
            </div>
        </form>
    </div>
</div>
@endsection

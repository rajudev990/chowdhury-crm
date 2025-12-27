@extends('layouts.app')
@section('title', isset($user) ? 'Edit User' : 'Create User')

@section('content')
<div class="container mx-auto mt-3">
    <div class="max-w-xl mx-auto bg-white rounded-lg shadow-xl border border-gray-200">
        <h5 class="bg-[#1A3A66] font-semibold mb-6 p-2 text-xl text-white">
            {{ isset($user) ? 'Edit User' : 'Create User' }}
        </h5>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST" class="p-6" enctype="multipart/form-data">
            @csrf
            @if(isset($user)) @method('PUT') @endif

            <div class="mb-6">
                <label for="name" class="block text-[#1A3A66] font-semibold mb-2">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]" required>
            </div>

            <div class="mb-6">
                <label for="email" class="block text-[#1A3A66] font-semibold mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]" required>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-[#1A3A66] font-semibold mb-2">Password @if(isset($user)) <small>(Leave blank to keep current)</small> @endif</label>
                <input type="password" id="password" name="password" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]" {{ isset($user) ? '' : 'required' }}>
            </div>

            <div class="mb-6">
                <label for="roles" class="block text-[#1A3A66] font-semibold mb-2">Roles</label>
                <select name="roles[]" id="roles" multiple class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]">
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" 
                            @if(isset($user) && $user->hasRole($role->name)) selected @endif>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-6 text-right">
                <button type="submit" 
                    class="px-4 py-3 bg-[#1A3A66] text-white rounded-lg hover:bg-[#1A3A66] transition duration-300 focus:outline-none focus:ring-2 focus:ring-[#1A3A66]">
                    {{ isset($user) ? 'Update User' : 'Create User' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

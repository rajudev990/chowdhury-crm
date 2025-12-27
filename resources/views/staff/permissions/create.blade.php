@extends('layouts.app')
@section('title', isset($permission) ? 'Edit Permission' : 'Create Permission')

@section('content')
<div class="container mx-auto mt-3">
    <div class="max-w-xl mx-auto bg-white rounded-lg shadow-xl border border-gray-200">
        <h5 class="bg-[#1A3A66] font-semibold mb-6 p-2 text-xl text-white">
            {{ isset($permission) ? 'Edit Permission' : 'Create Permission' }}
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

        <form action="{{ isset($permission) ? route('permissions.update', $permission->id) : route('permissions.store') }}" method="POST" class="p-6">
            @csrf
            @if(isset($permission)) @method('PUT') @endif

            <div class="mb-6">
                <label for="name" class="block text-[#1A3A66] font-semibold mb-2">Permission Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $permission->name ?? '') }}" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]" required>
            </div>
            <div class="text-right">
            <button type="submit" 
                class="px-4 py-3 bg-[#1A3A66] text-white rounded-lg hover:bg-[#1A3A66] transition duration-300 focus:outline-none focus:ring-2 focus:ring-[#1A3A66]">
                {{ isset($permission) ? 'Update Permission' : 'Create Permission' }}
            </button>
            </div>
        </form>
    </div>
</div>
@endsection

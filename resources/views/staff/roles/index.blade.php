@extends('layouts.app')
@section('title','Roles')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">

            <div class="p-4 bg-white rounded-xl shadow-md">

                <div class="flex justify-end mb-6">
                    <a href="{{ route('roles.create') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg bg-[#1A3A66] text-white hover:bg-[#163258] transition shadow-md">
                        <span class="text-xl">+</span>
                        New Role
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-50">
                            <tr class="text-sm font-semibold text-gray-700">
                                <th class="px-6 py-4 text-left">#</th>
                                <th class="px-6 py-4 text-left">Role Name</th>
                                <th class="px-6 py-4 text-left">Permissions</th>
                                <th class="px-6 py-4 text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y text-sm text-gray-700">
                            @foreach($roles as $role)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">{{ $role->name }}</td>
                                <td class="px-6 py-4">
                                    @foreach($role->permissions as $perm)
                                        <span class="px-2 py-1 bg-gray-200 rounded-full text-xs mr-1">{{ $perm->name }}</span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-1">
                                        <a href="{{ route('roles.edit', $role->id) }}"
                                           class="w-8 h-8 flex items-center justify-center
                                                  text-[#9CA3AF] rounded-full
                                                  hover:text-[#1A3A66] transition" title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
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

                    <div class="mt-4">
                        {{ $roles->links() }}
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection

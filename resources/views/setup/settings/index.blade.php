@extends('layouts.app')
@section('title', 'Settings')

@section('content')
<div class="container mx-auto mt-3">
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-xl border border-gray-200">
        <h5 class="bg-[#1A3A66] font-semibold mb-6 p-4 text-xl text-white">
            <i class="fa-solid fa-gear mr-2"></i> Website Settings
        </h5>

        <!-- Success Message -->
        @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 mx-6">
            <i class="fa-solid fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 mx-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('settings.update',$setting->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Website Name -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-[#1A3A66] font-semibold mb-2">
                        <i class="fa-solid fa-building mr-1"></i> Website Name
                    </label>
                    <input type="text" id="name" name="name"
                        value="{{ old('name', $setting->name ?? '') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]"
                        placeholder="Enter website name">
                </div>


                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-[#1A3A66] font-semibold mb-2">
                        <i class="fa-solid fa-phone mr-1"></i> Phone Number
                    </label>
                    <input type="text" id="phone" name="phone"
                        value="{{ old('phone', $setting->phone ?? '') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]"
                        placeholder="+880 1234567890">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-[#1A3A66] font-semibold mb-2">
                        <i class="fa-solid fa-envelope mr-1"></i> Email Address
                    </label>
                    <input type="email" id="email" name="email"
                        value="{{ old('email', $setting->email ?? '') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]"
                        placeholder="info@example.com">
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label for="address" class="block text-[#1A3A66] font-semibold mb-2">
                        <i class="fa-solid fa-location-dot mr-1"></i> Address
                    </label>
                    <textarea id="address" name="address" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]"
                        placeholder="Enter full address">{{ old('address', $setting->address ?? '') }}</textarea>
                </div>

                <!-- Copyright -->
                <div>
                    <label for="copyright" class="block text-[#1A3A66] font-semibold mb-2">
                        <i class="fa-solid fa-copyright mr-1"></i> Copyright Text
                    </label>
                    <input type="text" id="copyright" name="copyright"
                        value="{{ old('copyright', $setting->copyright ?? '') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]"
                        placeholder="© 2024 Your Company. All rights reserved.">
                </div>

                 <!-- Logo Upload -->
                <div>
                    <label for="logo" class="block text-[#1A3A66] font-semibold mb-2">
                        <i class="fa-solid fa-image mr-1"></i> Website Logo
                    </label>

                    <input type="file" id="logo" name="logo"
                        accept="image/*"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]">
                    @if($setting->logo)
                    <div class="mb-3 flex items-center gap-4 mt-3">
                        <img src="{{Storage::url($setting->logo) }}"
                            alt="Current Logo"
                            class="h-20 w-auto border border-gray-300 rounded-lg p-2">
                    </div>
                    @endif
                </div>
          

                <!-- Social Media Links -->
                <div class="md:col-span-2 border-t pt-6">
                    <h6 class="text-[#1A3A66] font-semibold mb-4">
                        <i class="fa-solid fa-share-nodes mr-1"></i> Social Media Links
                    </h6>
                </div>

                <!-- Facebook -->
                <div>
                    <label for="facebook" class="block text-[#1A3A66] font-semibold mb-2">
                        <i class="fa-brands fa-facebook mr-1"></i> Facebook
                    </label>
                    <input type="url" id="facebook" name="facebook"
                        value="{{ old('facebook', $setting->facebook ?? '') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]"
                        placeholder="https://facebook.com/yourpage">
                </div>

                <!-- Twitter -->
                <div>
                    <label for="twitter" class="block text-[#1A3A66] font-semibold mb-2">
                        <i class="fa-brands fa-twitter mr-1"></i> Twitter
                    </label>
                    <input type="url" id="twitter" name="twitter"
                        value="{{ old('twitter', $setting->twitter ?? '') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]"
                        placeholder="https://twitter.com/yourprofile">
                </div>

                <!-- LinkedIn -->
                <div>
                    <label for="linkedin" class="block text-[#1A3A66] font-semibold mb-2">
                        <i class="fa-brands fa-linkedin mr-1"></i> LinkedIn
                    </label>
                    <input type="url" id="linkedin" name="linkedin"
                        value="{{ old('linkedin', $setting->linkedin ?? '') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]"
                        placeholder="https://linkedin.com/company/yourcompany">
                </div>

                <!-- YouTube -->
                <div>
                    <label for="youtube" class="block text-[#1A3A66] font-semibold mb-2">
                        <i class="fa-brands fa-youtube mr-1"></i> YouTube
                    </label>
                    <input type="url" id="youtube" name="youtube"
                        value="{{ old('youtube', $setting->youtube ?? '') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1A3A66]"
                        placeholder="https://youtube.com/@yourchannel">
                </div>

            </div>

            <!-- Submit Button -->
            <div class="flex justify-end mt-8">
                <button type="submit"
                    class="px-6 py-3 bg-[#1A3A66] text-white rounded-lg hover:bg-[#163258] transition duration-300 focus:outline-none focus:ring-2 focus:ring-[#1A3A66]">
                    <i class="fa-solid fa-save mr-2"></i>
                    {{ $setting->id ? 'Update Settings' : 'Save Settings' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
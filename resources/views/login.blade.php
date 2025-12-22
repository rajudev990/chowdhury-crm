<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-emerald-50 to-teal-100">

    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">

            <!-- Title -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Admin Login</h1>
                <p class="text-gray-400 text-sm mt-1">
                    Sign in to your dashboard
                </p>
            </div>

            <!-- Error Message -->
            @if(session('error'))
                <div class="mb-4 p-3 rounded bg-red-100 text-red-600 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-4 p-3 rounded bg-red-100 text-red-600 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Email Address
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        placeholder="admin@gmail.com"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300
                               focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500
                               outline-none transition"
                    >
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Password
                    </label>
                    <input
                        type="password"
                        name="password"
                        required
                        placeholder="••••••••"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300
                               focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500
                               outline-none transition"
                    >
                </div>

                <!-- Remember -->
                <div class="flex items-center">
                    <input
                        type="checkbox"
                        name="remember"
                        id="remember"
                        class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500"
                    >
                    <label for="remember" class="ml-2 text-sm text-gray-600">
                        Remember me
                    </label>
                </div>

                <!-- Button -->
                <button
                    type="submit"
                    class="w-full py-3 rounded-lg text-white font-semibold
                           bg-gradient-to-r from-emerald-500 to-teal-500
                           hover:from-emerald-600 hover:to-teal-600
                           transition shadow-md"
                >
                    Login
                </button>
            </form>

            <!-- Footer -->
            <p class="text-center text-xs text-gray-400 mt-6">
                © {{ date('Y') }} Admin Panel. All rights reserved.
            </p>

        </div>
    </div>

</body>
</html>

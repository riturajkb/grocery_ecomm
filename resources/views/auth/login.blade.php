<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dipika Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50" style="color: #475569;">
    <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <!-- Logo & Branding -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex flex-col items-center group">
                <div class="h-16 w-16 rounded-2xl flex items-center justify-center text-white shadow-xl mb-4 transform group-hover:scale-105 transition-transform duration-300"
                    style="background: linear-gradient(135deg, #2D6A4F, #1d4430); box-shadow: 0 20px 25px -5px rgba(45, 106, 79, 0.3);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Dipika Store</h1>
                <p class="text-gray-500 text-sm mt-1">Fresh groceries, delivered</p>
            </a>
        </div>

        <!-- Login Card -->
        <div class="w-full max-w-md">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <!-- Card Header -->
                <div class="px-8 pt-8 pb-6 border-b border-gray-100" style="background-color: #FDFBF7;">
                    <h2 class="text-2xl font-bold text-gray-900 text-center">Welcome Back</h2>
                    <p class="text-gray-500 text-sm text-center mt-1">Sign in to your account</p>
                </div>

                <!-- Card Body -->
                <div class="px-8 py-8">
                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                            <ul class="space-y-1">
                                @foreach($errors->all() as $error)
                                    <li class="flex items-center gap-2">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                Email Address
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:border-transparent transition-all"
                                style="focus:ring-color: #2D6A4F;" placeholder="you@example.com">
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                Password
                            </label>
                            <input type="password" id="password" name="password" required
                                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:border-transparent transition-all"
                                style="focus:ring-color: #2D6A4F;" placeholder="••••••••">
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input type="checkbox" id="remember" name="remember"
                                class="h-4 w-4 rounded border-gray-300 focus:ring-2" style="accent-color: #2D6A4F;">
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                Remember me
                            </label>
                        </div>

                        <!-- Login Button -->
                        <button type="submit"
                            class="w-full py-3 px-4 rounded-lg font-bold text-white transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
                            style="background-color: #2D6A4F;" onmouseover="this.style.backgroundColor='#255740'"
                            onmouseout="this.style.backgroundColor='#2D6A4F'">
                            Sign In
                        </button>
                    </form>
                </div>

                <!-- Card Footer -->
                <div class="px-8 py-6 border-t border-gray-100 text-center" style="background-color: #FDFBF7;">
                    <p class="text-sm text-gray-600">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="font-semibold hover:underline transition-colors"
                            style="color: #2D6A4F;">
                            Sign up
                        </a>
                    </p>
                </div>
            </div>

            <!-- Additional Links -->
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}"
                    class="text-sm text-gray-500 hover:text-gray-700 transition-colors inline-flex items-center gap-1">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to store
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-12 text-center text-xs text-gray-500">
            <p>&copy; {{ date('Y') }} Dipika Store. All rights reserved.</p>
        </div>
    </div>

    <style>
        input:focus {
            ring-color: #2D6A4F;
            border-color: #2D6A4F;
        }
    </style>
</body>

</html>
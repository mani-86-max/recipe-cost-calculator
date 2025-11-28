<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Recipe Cost Calculator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-overlay {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.95) 0%, rgba(118, 75, 162, 0.95) 100%);
        }
        
        .animate-fade-in {
            animation: fadeIn 0.8s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .bg-image {
            background-image: url('https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=1920&q=80');
            background-size: cover;
            background-position: center;
        }
        
        .pulse-icon {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
    </style>
</head>
<body class="h-full bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Left Side - Image with Overlay -->
        <div class="hidden lg:flex lg:w-1/2 bg-image relative">
            <div class="gradient-overlay absolute inset-0 flex items-center justify-center">
                <div class="text-white text-center p-12 animate-fade-in">
                    <div class="mb-8 pulse-icon">
                        <i class="fas fa-calculator text-9xl drop-shadow-2xl"></i>
                    </div>
                    <h1 class="text-6xl font-extrabold mb-6 drop-shadow-lg">Recipe Cost Calculator</h1>
                    <p class="text-2xl opacity-90 max-w-lg mx-auto font-light">
                        Professional recipe management and cost analysis for your restaurant business
                    </p>
                    <div class="mt-16 grid grid-cols-3 gap-12">
                        <div class="text-center transform hover:scale-110 transition-transform">
                            <div class="text-5xl font-extrabold mb-2">500+</div>
                            <div class="text-base opacity-80">Restaurants</div>
                        </div>
                        <div class="text-center transform hover:scale-110 transition-transform">
                            <div class="text-5xl font-extrabold mb-2">10K+</div>
                            <div class="text-base opacity-80">Recipes</div>
                        </div>
                        <div class="text-center transform hover:scale-110 transition-transform">
                            <div class="text-5xl font-extrabold mb-2">99%</div>
                            <div class="text-base opacity-80">Accuracy</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gradient-to-br from-gray-50 to-gray-100">
            <div class="max-w-md w-full animate-fade-in">
                <!-- Logo for Mobile -->
                <div class="lg:hidden text-center mb-10">
                    <div class="inline-block p-5 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl mb-4 shadow-xl">
                        <i class="fas fa-utensils text-white text-5xl"></i>
                    </div>
                    <h2 class="text-4xl font-extrabold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                        Recipe Calculator
                    </h2>
                </div>

                <div class="bg-white rounded-3xl shadow-2xl p-10">
                    <div class="mb-10">
                        <h2 class="text-4xl font-extrabold text-gray-800 mb-3">Welcome Back!</h2>
                        <p class="text-gray-600 text-lg">Sign in to manage your recipes</p>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                            <p class="text-green-700 text-sm flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>{{ session('status') }}
                            </p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">
                                <i class="fas fa-envelope text-purple-600 mr-2"></i>Email Address
                            </label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                class="w-full px-5 py-4 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-purple-300 focus:border-purple-500 transition text-lg @error('email') border-red-500 @enderror"
                                placeholder="your@email.com">
                            @error('email')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">
                                <i class="fas fa-lock text-purple-600 mr-2"></i>Password
                            </label>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="w-full px-5 py-4 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-purple-300 focus:border-purple-500 transition text-lg @error('password') border-red-500 @enderror"
                                placeholder="••••••••">
                            @error('password')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="remember" class="w-5 h-5 rounded border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500">
                                <span class="ml-3 text-sm text-gray-700 font-medium">Remember me</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-purple-600 hover:text-purple-800 font-semibold transition-colors">
                                    Forgot Password?
                                </a>
                            @endif
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="w-full bg-gradient-to-r from-purple-600 via-purple-500 to-pink-600 text-white py-4 rounded-xl font-bold text-lg hover:shadow-2xl transition-all transform hover:scale-105 active:scale-95">
                            <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                        </button>
                    </form>

                    <!-- Register Link -->
                    <div class="mt-10 pt-8 border-t-2 border-gray-200 text-center">
                        <p class="text-gray-600 mb-5 text-lg font-medium">Don't have an account?</p>
                        <a href="{{ route('register') }}" class="inline-block w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 rounded-xl font-bold text-lg hover:shadow-2xl transition-all transform hover:scale-105 active:scale-95">
                            <i class="fas fa-user-plus mr-2"></i>Create New Account
                        </a>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center text-sm text-gray-600">
                    <p>&copy; 2025 Recipe Cost Calculator. Made with <i class="fas fa-heart text-red-500"></i> in India</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
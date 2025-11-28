<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Recipe Cost Calculator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('images/myicon.png') }}">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-overlay {
            background: linear-gradient(135deg, rgba(234, 88, 12, 0.95) 0%, rgba(220, 38, 38, 0.95) 100%);
        }
        
        .animate-fade-in {
            animation: fadeIn 0.8s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .bg-image {
            background-image: url('https://images.unsplash.com/photo-1585937421612-70a008356fbe?w=1920&q=80');
            background-size: cover;
            background-position: center;
        }
        
        .feature-card {
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateX(10px);
        }
    </style>
</head>
<body class="h-full bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Left Side - Register Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gradient-to-br from-gray-50 to-gray-100">
            <div class="max-w-md w-full animate-fade-in">
                <!-- Logo for Mobile -->
                <div class="lg:hidden text-center mb-10">
                    <div class="inline-block p-5 bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl mb-4 shadow-xl">
                        <i class="fas fa-utensils text-white text-5xl"></i>
                    </div>
                    <h2 class="text-4xl font-extrabold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">
                        Recipe Calculator
                    </h2>
                </div>

                <div class="bg-white rounded-3xl shadow-2xl p-10">
                    <div class="mb-10">
                        <h2 class="text-4xl font-extrabold text-gray-800 mb-3">Create Account</h2>
                        <p class="text-gray-600 text-lg">Start managing your recipes today</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">
                                <i class="fas fa-user text-orange-600 mr-2"></i>Full Name
                            </label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                                class="w-full px-5 py-4 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-orange-300 focus:border-orange-500 transition text-lg @error('name') border-red-500 @enderror"
                                placeholder="John Doe">
                            @error('name')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">
                                <i class="fas fa-envelope text-orange-600 mr-2"></i>Email Address
                            </label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                                class="w-full px-5 py-4 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-orange-300 focus:border-orange-500 transition text-lg @error('email') border-red-500 @enderror"
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
                                <i class="fas fa-lock text-orange-600 mr-2"></i>Password
                            </label>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                class="w-full px-5 py-4 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-orange-300 focus:border-orange-500 transition text-lg @error('password') border-red-500 @enderror"
                                placeholder="••••••••">
                            @error('password')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-gray-700 font-bold mb-2 text-sm uppercase tracking-wide">
                                <i class="fas fa-lock text-orange-600 mr-2"></i>Confirm Password
                            </label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                class="w-full px-5 py-4 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-orange-300 focus:border-orange-500 transition text-lg"
                                placeholder="••••••••">
                        </div>

                        <!-- Register Button -->
                        <button type="submit" class="w-full bg-gradient-to-r from-orange-600 via-orange-500 to-red-600 text-white py-4 rounded-xl font-bold text-lg hover:shadow-2xl transition-all transform hover:scale-105 active:scale-95 mt-6">
                            <i class="fas fa-user-plus mr-2"></i>Create Account
                        </button>
                    </form>

                    <!-- Login Link -->
                    <div class="mt-10 pt-8 border-t-2 border-gray-200 text-center">
                        <p class="text-gray-600 mb-5 text-lg font-medium">Already have an account?</p>
                        <a href="{{ route('login') }}" class="inline-block w-full bg-gradient-to-r from-gray-700 to-gray-900 text-white py-4 rounded-xl font-bold text-lg hover:shadow-2xl transition-all transform hover:scale-105 active:scale-95">
                            <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                        </a>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center text-sm text-gray-600">
                    <p>&copy; 2025 Recipe Cost Calculator. Made with <i class="fas fa-heart text-red-500"></i> in India</p>
                </div>
            </div>
        </div>

        <!-- Right Side - Image with Overlay -->
        <div class="hidden lg:flex lg:w-1/2 bg-image relative">
            <div class="gradient-overlay absolute inset-0 flex items-center justify-center">
                <div class="text-white text-center p-12 animate-fade-in">
                    <div class="mb-8">
                        <i class="fas fa-concierge-bell text-9xl drop-shadow-2xl"></i>
                    </div>
                    <h1 class="text-6xl font-extrabold mb-8 drop-shadow-lg">Start Your Journey</h1>
                    <p class="text-2xl opacity-90 max-w-lg mx-auto mb-16 font-light">
                        Join thousands of restaurant owners managing their recipes efficiently
                    </p>
                    <div class="space-y-6 text-left max-w-lg mx-auto">
                        <div class="flex items-center space-x-5 feature-card">
                            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                                <i class="fas fa-book text-3xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-xl">Recipe Management</h3>
                                <p class="text-base opacity-80">Organize all your recipes in one place</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-5 feature-card">
                            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                                <i class="fas fa-calculator text-3xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-xl">Cost Calculation</h3>
                                <p class="text-base opacity-80">Accurate pricing for profitability</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-5 feature-card">
                            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                                <i class="fas fa-store text-3xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-xl">Multi-Restaurant</h3>
                                <p class="text-base opacity-80">Manage multiple locations easily</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
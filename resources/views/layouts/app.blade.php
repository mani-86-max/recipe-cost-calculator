<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Recipe Cost Calculator')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CKEditor 5 CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card-hover { transition: all 0.3s cubic-bezier(0.4,0,0.2,1); }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }
        .animate-fade-in { animation: fadeIn 0.5s ease-in; }
        @keyframes fadeIn { from{opacity:0;transform:translateY(20px);} to{opacity:1;transform:translateY(0);} }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); transition: .3s; }
        .btn-primary:hover { transform: scale(1.05); box-shadow: 0 10px 20px rgba(102,126,234,.4); }
        .badge { padding: .25rem .75rem; border-radius: 9999px; font-size: .75rem; font-weight: 600; }
    </style>
</head>

<body class="bg-gray-50 h-full flex flex-col">

    <!-- Navigation -->
        <nav class="bg-gradient-to-r from-yellow-400 to-blue-500 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('restaurants.index') }}" class="flex items-center space-x-3 group">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-2 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-utensils text-white text-xl"></i>
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                            Recipe Calculator
                        </span>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('restaurants.index') }}" class="flex items-center space-x-2 text-gray-700 hover:text-purple-600 transition-colors">
                            <i class="fas fa-store"></i>
                            <span class="hidden md:inline">My Restaurants</span>
                        </a>
                        <div class="flex items-center space-x-3 border-l pl-4">
                            <div class="hidden md:block text-right">
                                <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="inline">@csrf
                            <button class="text-gray-700 hover:text-red-600 transition-colors p-2 hover:bg-red-50 rounded-lg">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-purple-600 transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 py-2 rounded-lg hover:shadow-lg transition-all">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Alerts -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-4 w-full animate-fade-in">
            <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded-lg shadow-md flex justify-between">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-green-600 hover:text-green-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 px-4 py-3 rounded-lg shadow-md">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto px-4 py-8 w-full">
        @yield('content')
    </main>

    <!-- Clean Footer (Quick Links & Connect Removed) -->
    <footer class="bg-gradient-to-r from-gray-800 to-gray-900 text-white py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4">

            <div class="mb-2">
                <h3 class="text-2xl font-bold mb- flex items-center justify-center">
                    <i class="fas fa-utensils mr-2 text-red-400"></i>
                    Recipe Calculator
                </h3>
                <p class="flex flex-col items-center text-center mb-4">
                    Professional recipe cost management for restaurants and food businesses.
                </p>
            </div>

            <div class="border-t border-gray-700 pt-6 text-center text-gray-400 text-sm">
                <p>&copy; 2025 Recipe Cost Calculator. All rights reserved. Made with 
                    <i class="fas fa-heart text-red-500"></i> in India
                </p>
            </div>

        </div>
    </footer>

    @stack('scripts')
</body>
</html>

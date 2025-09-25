<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'M-Blog' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireStyles
    
    <!-- SPA Loading Styles -->
    <style>
        .spa-loading-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 9999;
        }
        .spa-loading-bar.loading {
            animation: loading 1s ease-in-out infinite;
        }
        @keyframes loading {
            0% { transform: translateX(-100%); }
            50% { transform: translateX(0%); }
            100% { transform: translateX(100%); }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- SPA Loading Bar -->
    <div class="spa-loading-bar" wire:loading.class="loading" wire:target="$navigate"></div>
    <!-- Navigation -->
    <nav class="bg-white/95 backdrop-blur-md shadow-lg border-b border-gray-200/50 sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-18">
                <!-- Logo Section -->
                <div class="flex items-center">
                    <a wire:navigate href="{{ route('blog.index') }}" class="flex items-center group">
                        <span class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                            M-Blog
                        </span>
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-1">
                    <a wire:navigate href="{{ route('blog.index') }}" 
                       class="relative px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('blog.index') ? 'text-blue-600' : '' }}">
                        <span class="relative z-10">Home</span>
                        @if(request()->routeIs('blog.index'))
                            <div class="absolute inset-0 bg-blue-50 rounded-lg"></div>
                            <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-6 h-0.5 bg-blue-600 rounded-full"></div>
                        @else
                            <div class="absolute inset-0 bg-gray-50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                        @endif
                    </a>
                    
                    <a wire:navigate href="{{ route('about') }}" 
                       class="relative px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('about') ? 'text-blue-600' : '' }}">
                        <span class="relative z-10">About</span>
                        @if(request()->routeIs('about'))
                            <div class="absolute inset-0 bg-blue-50 rounded-lg"></div>
                            <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-6 h-0.5 bg-blue-600 rounded-full"></div>
                        @else
                            <div class="absolute inset-0 bg-gray-50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                        @endif
                    </a>
                    
                    <a wire:navigate href="{{ route('services') }}" 
                       class="relative px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('services') ? 'text-blue-600' : '' }}">
                        <span class="relative z-10">Services</span>
                        @if(request()->routeIs('services'))
                            <div class="absolute inset-0 bg-blue-50 rounded-lg"></div>
                            <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-6 h-0.5 bg-blue-600 rounded-full"></div>
                        @else
                            <div class="absolute inset-0 bg-gray-50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                        @endif
                    </a>
                    
                    <a wire:navigate href="{{ route('contact') }}" 
                       class="relative px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('contact') ? 'text-blue-600' : '' }}">
                        <span class="relative z-10">Contact</span>
                        @if(request()->routeIs('contact'))
                            <div class="absolute inset-0 bg-blue-50 rounded-lg"></div>
                            <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-6 h-0.5 bg-blue-600 rounded-full"></div>
                        @else
                            <div class="absolute inset-0 bg-gray-50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                        @endif
                    </a>
                    
                    <!-- Auth Section -->
                    <div class="ml-4 pl-4 border-l border-gray-200 flex items-center space-x-3">
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a wire:navigate href="{{ route('admin.dashboard') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-800 to-gray-900 text-white text-sm font-medium rounded-lg hover:from-gray-900 hover:to-black transition-all duration-200 shadow-md hover:shadow-lg">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Admin
                                </a>
                            @endif
                            
                            <div class="flex items-center space-x-3">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-purple-600 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                                </div>
                                
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" 
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200 group border border-gray-200 hover:border-red-200"
                                        onclick="return confirm('Are you sure you want to logout?')"
                                        title="Logout">
                                        <svg class="w-4 h-4 mr-1 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        @else
                            <a wire:navigate href="{{ route('login') }}" 
                               class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                                Login
                            </a>
                            <a wire:navigate href="{{ route('register') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg">
                                Register
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="p-2 rounded-lg text-gray-700 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="md:hidden">
            <div class="px-4 pt-2 pb-4 space-y-2 bg-white/95 backdrop-blur-md border-t border-gray-200/50">
                <a wire:navigate href="{{ route('blog.index') }}" 
                   class="block px-4 py-3 rounded-lg text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 transition-all duration-200 {{ request()->routeIs('blog.index') ? 'text-blue-600 bg-blue-50 border-l-4 border-blue-600' : '' }}" 
                   @click="mobileMenuOpen = false">
                    Home
                </a>
                <a wire:navigate href="{{ route('about') }}" 
                   class="block px-4 py-3 rounded-lg text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 transition-all duration-200 {{ request()->routeIs('about') ? 'text-blue-600 bg-blue-50 border-l-4 border-blue-600' : '' }}" 
                   @click="mobileMenuOpen = false">
                    About
                </a>
                <a wire:navigate href="{{ route('services') }}" 
                   class="block px-4 py-3 rounded-lg text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 transition-all duration-200 {{ request()->routeIs('services') ? 'text-blue-600 bg-blue-50 border-l-4 border-blue-600' : '' }}" 
                   @click="mobileMenuOpen = false">
                    Services
                </a>
                <a wire:navigate href="{{ route('contact') }}" 
                   class="block px-4 py-3 rounded-lg text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 transition-all duration-200 {{ request()->routeIs('contact') ? 'text-blue-600 bg-blue-50 border-l-4 border-blue-600' : '' }}" 
                   @click="mobileMenuOpen = false">
                    Contact
                </a>
                <div class="pt-2 mt-2 border-t border-gray-200">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a wire:navigate href="{{ route('admin.dashboard') }}" 
                               class="flex items-center px-4 py-3 bg-gradient-to-r from-gray-800 to-gray-900 text-white rounded-lg hover:from-gray-900 hover:to-black transition-all duration-200" 
                               @click="mobileMenuOpen = false">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Admin Panel
                            </a>
                        @endif
                        
                        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 rounded-lg mt-2">
                            <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="space-y-2">
                            <a wire:navigate href="{{ route('login') }}" 
                               class="block px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-all duration-200" 
                               @click="mobileMenuOpen = false">
                                Login
                            </a>
                            <a wire:navigate href="{{ route('register') }}" 
                               class="flex items-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200" 
                               @click="mobileMenuOpen = false">
                                Register
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="text-center text-gray-600">
                <p>&copy; 2025 M-Blog</p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Digital Repository')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&display=swap" rel="stylesheet">

        <!-- Tailwind CSS & Vite JS -->
        @vite(['resources/css/app.css', "resources/js/app.js"])

        <!-- Font Awesome (CRITICAL: This makes the <i class="fas fa-..."> icons work in your views) -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>
    
    <!-- x-data is for Alpine.js (Breeze uses this to toggle the mobile menu) -->
    <body class="font-sans antialiased bg-gray-100 text-gray-900" x-data="{ open: false }">

        <!-- ==================== TOP NAVIGATION ==================== -->
        <nav class="bg-white border-b border-gray-100">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    
                    <!-- Left Side: Logo & Main Links -->
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600 tracking-tight">
                                <i class="fas fa-landmark mr-2"></i>DigiRepo
                            </a>
                        </div>

                        <!-- Desktop Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                                <i class="fas fa-folder-open mr-1.5 text-xs"></i> Repository
                            </x-nav-link>
                            
                            @auth
                                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                    <i class="fas fa-gauge-high mr-1.5 text-xs"></i> Dashboard
                                </x-nav-link>
                            @endauth
                        </div>
                    </div>

                    <!-- Right Side: Actions & User Menu -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6 sm:space-x-4">
                        
                        <!-- Upload Button (Only visible when logged in) -->
                        @auth
                            <a href="{{ route('documents.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-cloud-arrow-up mr-1.5"></i> Upload Record
                            </a>
                        @endauth

                        <!-- Breeze User Dropdown -->
                        @auth
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:bg-gray-50 transition">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold mr-2">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                        {{ Auth::user()->name }}
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <!-- My Uploads Link (Bonus feature) -->
                                    <x-dropdown-link :href="route('documents.index', ['user_id' => Auth::id()])">
                                        <i class="fas fa-user mr-2 text-gray-400"></i> My Uploads
                                    </x-dropdown-link>

                                    <x-dropdown-link :href="route('profile.edit')">
                                        <i class="fas fa-cog mr-2 text-gray-400"></i> {{ __('Profile') }}
                                    </x-dropdown-link>

                                    <!-- Logout Form -->
                                    <form method="POST" action="{{ route('logout') }}" class="pt-2 border-t border-gray-100">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')" 
                                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                            <i class="fas fa-right-from-bracket mr-2 text-gray-400"></i> {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        @else
                            <!-- Login/Register Buttons (For Guests) -->
                            <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">Log in</a>
                            <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">Register</a>
                        @endauth
                    </div>

                    <!-- Hamburger Menu Button (Mobile) -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu (Mobile) -->
            <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        <i class="fas fa-folder-open mr-2"></i> Repository
                    </x-responsive-nav-link>
                    
                    @auth
                        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            <i class="fas fa-gauge-high mr-2"></i> Dashboard
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('documents.create')" :active="request()->routeIs('documents.create')">
                            <i class="fas fa-cloud-arrow-up mr-2"></i> Upload Record
                        </x-responsive-nav-link>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- ==================== PAGE CONTENT ==================== -->
        <main>
            {{ $slot }}
        </main>

    </body>
</html>
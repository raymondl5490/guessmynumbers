<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/fontawesome/all.min.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="relative bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="flex justify-between items-center border-b-2 border-gray-100 py-6 md:justify-start md:space-x-10">
                    <div class="flex justify-start lg:w-0 lg:flex-1">
                        <a href="{{ url('/') }}">
                            {{ config('app.name', 'Guess My Numbers') }}
                            <span class="sr-only">
                            {{ config('app.name', 'Guess My Numbers') }}
                            </span>
                        </a>
                    </div>
                    <div class="-mr-2 -my-2 md:hidden">
                        <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-expanded="false">
                            <span class="sr-only">Open menu</span>
                            <!-- Heroicon name: outline/menu -->
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                    <div class="hidden md:flex items-center justify-end md:flex-1 lg:w-0">
                        @guest
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="whitespace-nowrap text-base font-medium text-gray-500 hover:text-gray-900"> Sign in </a>
                            @endif
                        @else
                            <p class="whitespace-nowrap text-base font-medium text-gray-500 mx-2 font-light">
                                Hello, {{ Auth::user()->name }}!
                            </p>

                            <div class="text-base font-medium text-gray-500 hover:text-gray-900">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>

            <!--
              Mobile menu, show/hide based on mobile menu state.

              Entering: "duration-200 ease-out"
                From: "opacity-0 scale-95"
                To: "opacity-100 scale-100"
              Leaving: "duration-100 ease-in"
                From: "opacity-100 scale-100"
                To: "opacity-0 scale-95"
            -->
            <div class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden">
                <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
                    <div class="pt-5 pb-6 px-5">
                        @guest
                            @if (Route::has('login'))
                                <p class="mt-6 text-center text-base font-medium text-gray-500">
                                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500"> Sign in </a>
                                </p>
                            @endif
                        @else
                            <p class="whitespace-nowrap text-base font-medium text-gray-500 hover:text-gray-900">
                                {{ Auth::user()->name }}
                            </p>

                            <div class="text-base font-medium text-gray-500 hover:text-gray-900">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>

        <main class="py-4">
            @yield('content')
        </main>
    </div>


</body>
</html>

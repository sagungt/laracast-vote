<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        {{-- <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Livewire -->
        <livewire:styles />
        <livewire:scripts />
    </head>
    <body class="font-sans bg-gray-background text-gray-900 text-sm">
        <header class="flex flex-col md:flex-row items-center justify-between px-8 py-4">
            <a href="#"><img src="{{ asset('img/logo.svg') }}" alt="Logo"></a>
            <div class="flex items-center mt-2 md:mt-0">
                @if (Route::has('login'))
                    <div class="p-6">
                        @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
                <a href="#">
                    <img src="https://www.gravatar.com/avatar/0000000000000000000000000000000000?d=mp" alt="avatar" class="w-10 h-10 rounded-full">
                </a>
            </div>
        </header>
    </body>

    <main class="container mx-auto max-w-custom flex flex-col md:flex-row">
        <div class="mx-auto md:mx-0 w-70 md:mr-5">
            <div
                class="bg-white md:sticky md:top-8 border-2 border-blue rounded-xl mt-16"
                style="
                    border-image-source: linear-gradient(to bottom, rgba(50, 138, 241, 0.22), rgba(99, 123, 255, 0));
                    border-image-slice: 1;
                    background-image: linear-gradient(to bottom, #ffffff, #ffffff), linear-gradient(to bottom, rgba(50, 138, 241, 0.22), rgba(99, 123, 255, 0));
                    background-origin: border-box;
                    background-clip: content-box, border-box;
                "
            >
                <div class="text-center px-6 py-2 pt-6">
                    <h3 class="font-semibold text-base">Add an idea</h3>
                    <p class="text-xs mt-4">
                        @auth
                            Let us know what you would like and we'll take a look over!
                        @else
                            Please login to create an idea.
                        @endauth
                    </p>
                </div>

                @auth
                    <livewire:create-idea />
                @else
                    <div class="my-6 text-center">
                        <a href="{{ route('login') }}" class="inline-block justify-center w-1/2 h-11 text-xs text-white bg-blue font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="inline-block justify-center w-1/2 h-11 text-xs bg-gray-200 font-semibold rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3 mt-4">
                            Register
                        </a>
                    </div>
                @endauth
            </div>
        </div>
        <div class="w-full px-2 md:px-0 md:w-175">
            <livewire:status-filters />

            <div class="mt-8">
                {{ $slot }}
            </div>
        </div>
    </main>
</html>

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
    <body class="font-sans text-sm text-gray-900 bg-gray-background">
        <header class="flex flex-col items-center justify-between px-8 py-4 md:flex-row">
            <a href="/"><img src="{{ asset('img/logo.svg') }}" alt="Logo"></a>
            <div class="flex items-center mt-2 md:mt-0">
                @if (Route::has('login'))
                    <div class="p-6">
                        @auth
                        <div class="flex items-center space-x-4">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </a>
                            </form>

                            <div
                                class="relative"
                                x-data="{ isOpen: false }"
                            >
                                <button x-on:click="isOpen = !isOpen">
                                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-gray-400">
                                        <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="absolute rounded-full bg-red text-white text-xxs w-6 h-6 flex justify-center items-center -top-1.5 -right-1.5 border-2">1</div>
                                </button>
                                <ul
                                    x-cloak
                                    x-transition.origin.top
                                    x-show="isOpen"
                                    x-on:click.away="isOpen = false"
                                    x-on:keydown.escape.window="isOpen = false"
                                    class="absolute z-10 ml-8 text-left bg-white top-8 w-76 md:w-96 shadow-dialog rounded-xl -right-32 md:-right-12 max-h-128 overflow-y-auto text-gray-700"
                                >
                                    @foreach (range(1, 5) as $item)
                                        <li>
                                            <a
                                                href="#"
                                                class="flex px-5 py-3 transition duration-150 text-xs ease-in hover:bg-gray-100"
                                            >
                                                <img src="https://www.gravatar.com/avatar/0000000000000000000000000000000000?d=mp" alt="avatar" class="w-10 h-10 rounded-full">
                                                <div class="ml-4">
                                                    <div>
                                                        <span class="font-semibold">
                                                            jondo
                                                        </span> commented on 
                                                        <span class="font-semibold">
                                                            My idae
                                                        </span>:
                                                        <span class="line-clamp-3">"Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto voluptates, officia ut dolorum vel sapiente magnam eum saepe, fugit quae inventore reiciendis ab rem temporibus! Ipsa recusandae sed at iste, ab alias et amet voluptatibus laudantium magnam aspernatur veniam illum."</span>
                                                    </div>
                                                    <div class="text-xs text-gray-500 mt-2">1 hour ago</div>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                    <li class="border-t border-gray-300 text-center">
                                        <button class="block font-semibold px-5 py-4 transition duration-150 text-xs ease-in hover:bg-gray-100 w-full">
                                            Mark all as read
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
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
        <main class="container flex flex-col mx-auto max-w-custom md:flex-row">
            <div class="mx-auto md:mx-0 w-70 md:mr-5">
                <div
                    class="mt-16 bg-white border-2 md:sticky md:top-8 border-blue rounded-xl"
                    style="
                        border-image-source: linear-gradient(to bottom, rgba(50, 138, 241, 0.22), rgba(99, 123, 255, 0));
                        border-image-slice: 1;
                        background-image: linear-gradient(to bottom, #ffffff, #ffffff), linear-gradient(to bottom, rgba(50, 138, 241, 0.22), rgba(99, 123, 255, 0));
                        background-origin: border-box;
                        background-clip: content-box, border-box;
                    "
                >
                    <div class="px-6 py-2 pt-6 text-center">
                        <h3 class="text-base font-semibold">Add an idea</h3>
                        <p class="mt-4 text-xs">
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
                            <a href="{{ route('login') }}" class="justify-center inline-block w-1/2 px-6 py-3 text-xs font-semibold text-white transition duration-150 ease-in border h-11 bg-blue rounded-xl border-blue hover:bg-blue-hover">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="justify-center inline-block w-1/2 px-6 py-3 mt-4 text-xs font-semibold transition duration-150 ease-in bg-gray-200 border border-gray-200 h-11 rounded-xl hover:border-gray-400">
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
        @if (session('success_message'))
            <x-notification-success
                :redirect="true"
                message-to-display="{{ (session('success_message')) }}"
            />
        @endif
        @stack('modals')
    </body>

</html>

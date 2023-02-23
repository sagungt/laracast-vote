<x-app-layout>
    <div>
        <a href="{{ $backUrl }}" class="flex items-center font-semibold hover:underline">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            <span class="ml-2">All ideas (or back with chosen category with filters)</span>
        </a>
    </div>

    <livewire:idea-show
        :idea="$idea"
        :votes_count="$votes_count"
    />

    @can('update', $idea)
        <livewire:edit-idea
            :idea="$idea"
        /> 
    @endcan

    @can('delete', $idea)
        <livewire:delete-idea
            :idea="$idea"
        />
    @endcan

    @auth
        <livewire:mark-idea-as-spam
            :idea="$idea"
        />
    @endauth

    @admin
        <livewire:mark-idea-as-not-spam
            :idea="$idea"
        />
    @endadmin

    <div class="relative pt-4 my-8 mt-1 space-y-6 comments-container md:ml-22">
        @foreach (range(1, 3) as $item)
            <div class="relative flex mt-4 bg-white comment-container rounded-xl">
                <div class="flex flex-col flex-1 px-4 py-6 md:flex-row">
                    <div class="flex-none">
                        <a href="#">
                            <img src="https://source.unsplash.com/200x200/?face&crop=face&v=1" alt="avatar" class="w-14 h-14 rounded-xl">
                        </a>
                    </div>
                    <div class="w-full md:mx-4">
                        {{-- <h4 class="text-xl font-semibold">
                            <a href="#" class="hover:underline">Lorem ipsum dolor sit amet.</a>
                        </h4> --}}
                        <div class="mt-3 text-gray-600">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <div class="flex items-center space-x-2 text-xs font-semibold text-gray-400">
                                <div class="font-bold text-gray-900">John Doe</div>
                                <div>&bull;</div>
                                <div>10 hours ago</div>
                            </div>
                            <div
                                x-data="{ isOpen: false }"
                                class="flex items-center space-x-2"
                            >
                                <div class="relative">
                                    <button
                                        x-on:click="isOpen = !isOpen"
                                        class="relative flex items-center px-3 py-2 transition duration-150 ease-in bg-gray-100 border rounded-full hover:bg-gray-200 h-7"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                        </svg>
                                    </button>
                                    <ul
                                        x-cloak
                                        x-transition.origin.top.left
                                        x-show="isOpen"
                                        x-on:click.away="isOpen = false"
                                        x-on:keydown.escape.window="isOpen = false"
                                        class="absolute right-0 z-10 py-3 ml-8 font-semibold text-left bg-white top-8 md:top-6 w-44 shadow-dialog rounded-xl md:ml-8 md:left-0"
                                    >
                                        <li>
                                            <a href="#" class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100">Mark as Spam</a>
                                        </li>
                                        <li>
                                            <a href="#" class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100">Delete Post</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end comment-container --> 
        @endforeach

        <div class="relative flex mt-4 bg-white is-admin comment-container rounded-xl">
            <div class="flex flex-1 px-4 py-6">
                <div class="flex-none">
                    <a href="#">
                        <img src="https://source.unsplash.com/200x200/?face&crop=face&v=1" alt="avatar" class="w-14 h-14 rounded-xl">
                    </a>
                    <div class="mt-1 font-bold text-center uppercase text-blue text-xxs">Admin</div>
                </div>
                <div class="w-full mx-4">
                    <h4 class="text-xl font-semibold">
                        <a href="#" class="hover:underline">Status Changed to "Under Consideration"</a>
                    </h4>
                    <div class="mt-3 text-gray-600">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <div class="flex items-center space-x-2 text-xs font-semibold text-gray-400">
                            <div class="font-bold text-blue">Andrea</div>
                            <div>&bull;</div>
                            <div>10 hours ago</div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="relative flex items-center px-3 py-2 transition duration-150 ease-in bg-gray-100 border rounded-full hover:bg-gray-200 h-7">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                </svg>
                                <ul class="absolute hidden py-3 ml-8 font-semibold text-left bg-white top-6 w-44 shadow-dialog rounded-xl">
                                    <li>
                                        <a href="#" class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100">Mark as Spam</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100">Delete Post</a>
                                    </li>
                                </ul>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end comment-container -->

        <div class="relative flex mt-4 bg-white comment-container rounded-xl">
            <div class="flex flex-1 px-4 py-6">
                <div class="flex-none">
                    <a href="#">
                        <img src="https://source.unsplash.com/200x200/?face&crop=face&v=1" alt="avatar" class="w-14 h-14 rounded-xl">
                    </a>
                </div>
                <div class="w-full mx-4">
                    {{-- <h4 class="text-xl font-semibold">
                        <a href="#" class="hover:underline">Lorem ipsum dolor sit amet.</a>
                    </h4> --}}
                    <div class="mt-3 text-gray-600">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <div class="flex items-center space-x-2 text-xs font-semibold text-gray-400">
                            <div class="font-bold text-gray-900">John Doe</div>
                            <div>&bull;</div>
                            <div>10 hours ago</div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="relative flex items-center px-3 py-2 transition duration-150 ease-in bg-gray-100 border rounded-full hover:bg-gray-200 h-7">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                </svg>
                                <ul class="absolute hidden py-3 ml-8 font-semibold text-left bg-white top-6 w-44 shadow-dialog rounded-xl">
                                    <li>
                                        <a href="#" class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100">Mark as Spam</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100">Delete Post</a>
                                    </li>
                                </ul>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end comment-container --> 
    </div> <!-- end comments-container -->
</x-app-layout>
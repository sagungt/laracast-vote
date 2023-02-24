<div class="relative flex mt-4 bg-white comment-container rounded-xl">
    <div class="flex flex-col flex-1 px-4 py-6 md:flex-row">
        <div class="flex-none">
            <a href="#">
                <img src="{{ $comment->user->avatar }}" alt="avatar" class="w-14 h-14 rounded-xl">
            </a>
        </div>
        <div class="w-full md:mx-4">
            <div class="text-gray-600">
                {{ $comment->body }}
            </div>

            <div class="flex items-center justify-between mt-6">
                <div class="flex items-center space-x-2 text-xs font-semibold text-gray-400">
                    <div class="font-bold text-gray-900">{{ $comment->user->name }}</div>
                    <div>&bull;</div>
                    @if ($comment->user->id === $ideaUserId)
                        <div class="rounded-full border bg-gray-100 px-3 py-1">OP</div>
                        <div>&bull;</div>
                    @endif
                    <div>{{ $comment->created_at->diffForHumans() }}</div>
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
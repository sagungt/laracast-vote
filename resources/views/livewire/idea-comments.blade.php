<div>
    @if (!$comments->isNotEmpty())
        <div class="mx-auto mt-12 w-70">
            <img src="{{ asset('img/no-idea.svg') }}" alt="No ideas" class="mx-auto" style="mix-blend-mode: luminosity">
            <div class="mt-6 font-bold text-center text-gray-400">
                No comments yet ...
            </div>
        </div>
    @else
        <div class="relative pt-4 my-8 mt-1 space-y-6 comments-container md:ml-22">
            @foreach ($comments as $comment)
                <livewire:idea-comment
                    :key="$comment->id"
                    :comment="$comment"
                >
            @endforeach
        
            {{-- <div class="relative flex mt-4 bg-white is-admin comment-container rounded-xl">
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
            </div> <!-- end comment-container --> --}}
        </div> <!-- end comments-container -->
    @endif
</div>
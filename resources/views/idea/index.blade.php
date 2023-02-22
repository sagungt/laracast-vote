<x-app-layout>
    <div class="filters flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-6">
        <div class="w-full md:w-1/3">
            <select name="category" id="category" class="w-full border-none rounded-xl px-4 py-2">
                <option value="Category One">Category One</option>
                <option value="Category Two">Category Three</option>
                <option value="Category Four">Category Four</option>
                <option value="Category Five">Category Five</option>
            </select>
        </div>
        <div class="w-full md:w-1/3">
            <select name="filter" id="filter" class="w-full border-none rounded-xl px-4 py-2">
                <option value="filter One">filter One</option>
                <option value="filter Two">filter Three</option>
                <option value="filter Four">filter Four</option>
                <option value="filter Five">filter Five</option>
            </select>
        </div>
        <div class="w-full md:w-2/3 relative">
            <input type="search" name="search" id="search" placeholder="Find an idea" class="w-full rounded-xl bg-white px-4 py-2 pl-8 border-none placeholder:text-gray-900">
            <div class="absolute top-0 flex items-center h-full ml-2">
                <svg class="w-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </div>
        </div>
    </div> <!-- end filters -->

    <div class="ideas-container space-y-6 my-6">
        @foreach ($ideas as $idea)
            <livewire:idea-index
                :idea="$idea"
                :votes_count="$idea->votes_count"
            />
        @endforeach
    </div> <!-- end ideas-container -->

    <div class="my-8">
        {{ $ideas->links() }}
    </div>
</x-app-layout>
<div>
    <div class="flex flex-col space-y-3 filters md:flex-row md:space-y-0 md:space-x-6">
        <div class="w-full md:w-1/3">
            <select name="category" id="category" class="w-full px-4 py-2 border-none rounded-xl">
                <option value="Category One">Category One</option>
                <option value="Category Two">Category Three</option>
                <option value="Category Four">Category Four</option>
                <option value="Category Five">Category Five</option>
            </select>
        </div>
        <div class="w-full md:w-1/3">
            <select name="filter" id="filter" class="w-full px-4 py-2 border-none rounded-xl">
                <option value="filter One">filter One</option>
                <option value="filter Two">filter Three</option>
                <option value="filter Four">filter Four</option>
                <option value="filter Five">filter Five</option>
            </select>
        </div>
        <div class="relative w-full md:w-2/3">
            <input type="search" name="search" id="search" placeholder="Find an idea" class="w-full px-4 py-2 pl-8 bg-white border-none rounded-xl placeholder:text-gray-900">
            <div class="absolute top-0 flex items-center h-full ml-2">
                <svg class="w-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </div>
        </div>
    </div> <!-- end filters -->
    
    <div class="my-6 space-y-6 ideas-container">
        @foreach ($ideas as $idea)
            <livewire:idea-index
                :key="$idea->id"
                :idea="$idea"
                :votes_count="$idea->votes_count"
            />
        @endforeach
    </div> <!-- end ideas-container -->
    
    <div class="my-8">
        {{-- {{ $ideas->links() }} --}}
        {{ $ideas->appends(request()->query())->links() }}
    </div>
</div>
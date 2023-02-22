<nav class="items-center justify-between hidden text-xs text-gray-400 md:flex">
    <ul class="flex pb-3 space-x-10 font-semibold uppercase border-b-4">
        <li>
            <a wire:click.prevent="setStatus('All')" href="#" class="pb-3 border-b-4 hover:border-blue @if ($status === 'All') border-blue text-gray-900 @endif">All Ideas ({{ $statusCount['all_statuses'] }})</a>
        </li>
        <li>
            <a wire:click.prevent="setStatus('Considering')" href="#" class="pb-3 transition duration-150 ease-in border-b-4 hover:border-blue @if ($status === 'Considering') border-blue text-gray-900 @endif">Considering ({{ $statusCount['considering'] }})</a>
        </li>
        <li>
            <a wire:click.prevent="setStatus('In Progress')" href="#" class="pb-3 transition duration-150 ease-in border-b-4 hover:border-blue @if ($status === 'In Progress') border-blue text-gray-900 @endif">In Progress ({{ $statusCount['in_progress'] }})</a>
        </li>
    </ul>
    <ul class="flex pb-3 space-x-10 font-semibold uppercase border-b-4">
        <li>
            <a wire:click.prevent="setStatus('Implemented')" href="#" class="pb-3 transition duration-150 ease-in border-b-4 hover:border-blue @if ($status === 'Implemented') border-blue text-gray-900 @endif">Implemented ({{ $statusCount['implemented'] }})</a>
        </li>
        <li>
            <a wire:click.prevent="setStatus('Closed')" href="#" class="pb-3 transition duration-150 ease-in border-b-4 hover:border-blue @if ($status === 'Closed') border-blue text-gray-900 @endif">Closed ({{ $statusCount['closed'] }})</a>
        </li>
    </ul>
</nav>
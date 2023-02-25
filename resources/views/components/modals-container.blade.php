<div>
    @can('update', $idea)
        @push('modals')
            <livewire:edit-idea
                :idea="$idea"
            />
        @endpush
    @endcan
    
    @can('delete', $idea)
        @push('modals')
            <livewire:delete-idea
                :idea="$idea"
            />
        @endpush
    @endcan
    
    @auth
        @push('modals')
            <livewire:mark-idea-as-spam
                :idea="$idea"
            />
        @endpush
    @endauth
    
    @admin
        @push('modals')
            <livewire:mark-idea-as-not-spam
                :idea="$idea"
            />
        @endpush
    @endadmin

    @auth
        @push('modals')
            <livewire:edit-comment />
        @endpush
    @endauth
</div>
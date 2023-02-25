<x-mail::message>
# A comment was posted on your idea

{{ $comment->user->name }} commented on your idea:

**{{ $comment->idea->title }}**

Comment: {{ $comment->body }}

<x-mail::button :url="route('idea.show', [
    'idea' => $comment->idea,
])">
Go to idea
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

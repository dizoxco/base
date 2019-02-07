<ol>
    @forelse($chats as $chat)
        {{ dd($chat) }}
    @empty
                You have no conversation with anyone.
    @endforelse
</ol>
<ol>
        @forelse($tickets as $ticket)
        <label > {{ $ticket->title }}</label>
        <ol>
                @forelse($ticket->comments as $comment)

                        <li>
                                <p>
                                    <span style="color: darkred;">
                                        {{ optional($comment->user)->name ?? 'مدیریت'}}
                                    </span>
                                    ::
                                    {{ $comment->body }}
                                </p>
                        </li>
                @empty
                        There is no reply to this conversation
                @endforelse
        </ol>
        @empty
                You have no conversation with anyone.
        @endforelse
</ol>
<div class="card">
    <h3 class="font-bold">
        {{ __('comments.header') }}
    </h3>

    <div class="px-2">
        @foreach($comments as $comment)
            <div class="my-1">
                <div>
                    <a href="{{ $comment->user->viewUrl }}">
                        <span class="hover:underline text-gray-900 hover:text-black">
                            {{ $comment->user->name }}

                            <span class="text-gray-700">
                                ({{ $comment->user->email }})
                            </span>
                        </span>
                    </a>
                    &middot;
                    {{ $comment->created_at->toDateTimeString() }}
                </div>

                @if($comment->comment_type->isComment())
                    <div class="whitespace-pre-line ml-2">{{ $comment->data->text }}</div>
                @elseif($comment->comment_type->isChange())
                    <div>
                        {{ json_encode($comment->data) }}
                    </div>
                @else
                    {{ $comment->comment_type }}
                @endif
                <div></div>
            </div>
        @endforeach
    </div>
</div>

<div class="card">
    <h3 class="font-bold">
        {{ __('comments.header') }}
    </h3>

    <div class="px-2">
        @foreach($commentable->comments as $comment)
            <div class="my-2">
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
                    <div class="ml-2">
                        <table>
                            <tr>
                                <th class="pr-2">
                                    {{ __('comments.field') }}
                                </th>

                                <th class="pr-2">
                                    {{ __('comments.original') }}
                                </th>

                                <th>
                                    {{ __('comments.new') }}
                                </th>
                            </tr>

                            @foreach($comment->data->diff as $key => $diff)
                                <tr>
                                    <td class="pr-2">
                                        {{ $commentable->getFieldName($key) }}
                                    </td>

                                    <td class="pr-2">
                                        @component('components.value', ['typeModels' => $commentable->getFieldToModelTypes(), 'name' => $key, 'value' => $diff->original])
                                        @endcomponent
                                    </td>

                                    <td>
                                        @component('components.value', ['typeModels' => $commentable->getFieldToModelTypes(), 'name' => $key, 'value' => $diff->new])
                                        @endcomponent
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @else
                    {{ $comment->comment_type }}
                @endif
                <div></div>
            </div>
        @endforeach
    </div>
</div>

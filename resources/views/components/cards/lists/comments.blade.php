<div class="card">
    <h3 class="font-bold">
        {{ __('comments.header') }}
    </h3>

    <div class="px-2">
        @foreach($commentable->comments as $comment)
            <div class="my-2">
                <div>
                    @if($comment->user)
                        <a href="{{ $comment->user->viewUrl }}">
                            <span class="hover:underline text-gray-900 hover:text-black">
                                {{ $comment->user->name }}

                                <span class="text-gray-700">
                                    ({{ $comment->user->email }})
                                </span>
                            </span>
                        </a>
                    @elseif($comment->user_id === 0)
                        <span>{{ __('comments.system') }}</span>
                    @else
                        <span>{{ __('comments.deleted_user', ['id' => $comment->user_id]) }}</span>
                    @endif
                    &middot;
                    {{ \Rulla\Utils\Date::format($comment->created_at) }}
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
                                        @if(is_array($diff->original))
                                            @foreach($diff->original as $value)
                                                @component('components.value', ['typeModels' => $commentable->getFieldToModelTypes(), 'name' => $key, 'value' => $value])
                                                @endcomponent
                                                @if(!$loop->last)
                                                    <br/>
                                                @endif
                                            @endforeach
                                        @else
                                            @component('components.value', ['typeModels' => $commentable->getFieldToModelTypes(), 'name' => $key, 'value' => $diff->original])
                                            @endcomponent
                                        @endif
                                    </td>

                                    <td>
                                        @if(is_array($diff->new))
                                            @foreach($diff->new as $value)
                                                @component('components.value', ['typeModels' => $commentable->getFieldToModelTypes(), 'name' => $key, 'value' => $value])
                                                @endcomponent
                                                @if(!$loop->last)
                                                    <br/>
                                                @endif
                                            @endforeach
                                        @else
                                            @component('components.value', ['typeModels' => $commentable->getFieldToModelTypes(), 'name' => $key, 'value' => $diff->new])
                                            @endcomponent
                                        @endif
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

        <form class="mt-4" action="{{ route('comment.store') }}" method="POST">
            @csrf
            <input type="hidden" name="commentable_type" value="{{ get_class($commentable) }}">
            <input type="hidden" name="commentable_id" value="{{ $commentable->id }}">
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="comment_type" value="{{ \Rulla\Comments\CommentType::comment() }}">
            <label class="block">
                <span class="text-gray-700">
                    Post comment
                </span>

                <textarea name="text" class="form-textarea block w-full">{{ old('data.text') }}</textarea>
            </label>

            <button class="button button-blue mt-2">
                {{ __('general.submit') }}
            </button>
        </form>
    </div>
</div>

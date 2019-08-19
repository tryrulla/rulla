@extends('layouts.app')

@section('title', __('items.fields.index.title'))

@section('content')
    <div class="card">
        <h1 class="title text-2xl">
            {{ __('items.fields.index.title') }}
        </h1>

        <table>
            @foreach($fields as $field)
                <tr>
                    <td>
                        <a href="{{ $field->viewUrl }}" class="font-bold inline-block mr-4 hover:underline">
                            {{ $field->identifier }}
                        </a>
                    </td>

                    <td class="pr-2">
                        {{ $field->name }}
                    </td>

                    <td class="pr-2">
                        {{ __('items.fields.types.' . $field->type) }}
                    </td>

                    <td class="pl-1 text-gray-700">
                        @if($field->system)
                            {{ __('items.fields.index.system') }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>

        {{ $fields->links() }}
    </div>

@endsection

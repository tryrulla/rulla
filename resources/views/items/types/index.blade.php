@extends('layouts.app')

@section('title', __('items.types.index.title'))

@section('content')
    <div class="card">
        <h1 class="title text-2xl">
            {{ __('items.types.index.title') }}
        </h1>

        <div class="my-2">
            <div class="inline-block bg-gray-300 text-gray-700 p-2 shadow rounded">
                <a href="{{ route('items.types.add') }}" class="group">
                    <i class="fas fa-plus"></i> <span class="group-hover:underline">{{ __('items.types.index.add') }}</span>
                </a>
            </div>
        </div>

        <table>
            @foreach($types as $type)
                <tr>
                    <td>
                        <a href="{{ $type->viewUrl }}" class="font-bold inline-block mr-2 hover:underline">
                            {{ $type->identifier }}
                        </a>
                    </td>

                    <td class="pr-2">
                        {{ $type->name }}
                    </td>

                    <td class="pl-1 text-gray-700">
                        @if($type->system)
                            {{ __('items.types.index.system') }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>

        {{ $types->links() }}
    </div>

@endsection

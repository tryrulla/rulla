@extends('layouts.app')

@section('title', __('items.types.index.title'))

@section('content')
    @if($errors->any())
        <div class="card">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card">
        <h1 class="title text-2xl">
            {{ __('items.types.index.title') }}
        </h1>

        <table>
            @foreach($types as $type)
                <tr>
                    <td>
                        <a href="{{ $type->viewUrl }}" class="font-bold inline-block mr-2 pb-1">
                            {{ $type->identifier }}
                        </a>
                    </td>

                    <td>
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

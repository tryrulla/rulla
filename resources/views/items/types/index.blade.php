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
        <h2 class="title text-xl">
            {{ __('items.types.index.title') }}
        </h2>

        @foreach($types as $type)
            {{ json_encode($type) }}
        @endforeach

        {{ $types->links() }}
    </div>

@endsection

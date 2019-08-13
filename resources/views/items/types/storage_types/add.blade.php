@extends('layouts.app')

@section('title', __('items.types.storage.title'))

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
            {{ __('items.types.storage.title') }}
        </h2>

        <form action="{{ route('items.type-storage.store') }}" method="POST">
            @csrf

            <label class="block mt-4">
                <span class="text-gray-700">{{ __('auth.form.email') }}</span>

                <select class="form-select mt-1 block w-full" name="location">
                    @foreach($locations as $location)
                        <option name="{{ $location->id }}">
                            {{ $location->name }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="block mt-4">
                <span class="text-gray-700">{{ __('auth.form.email') }}</span>

                <select class="form-select mt-1 block w-full" name="type">
                    @foreach($itemTypes as $type)
                        <option name="{{ $type->id }}">
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </label>

            <div class="mt-4">
                <button class="button button-blue">
                    {{ __('auth.form.submit') }}
                </button>
            </div>
        </form>
    </div>

@endsection

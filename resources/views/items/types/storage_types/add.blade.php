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
                <span class="text-gray-700">{{ __('items.types.storage.location') }}</span>

                <select-input
                    :options="{{ json_encode($locations) }}"
                    initial-value="{{ old('storage_type_id', Request::get('storage_type_id')) }}"
                    name="storage_type_id"
                ></select-input>
            </label>

            <label class="block mt-4">
                <span class="text-gray-700">{{ __('items.types.storage.type') }}</span>

                <select-input
                    :options="{{ json_encode($itemTypes) }}"
                    initial-value="{{ old('stored_type_id', Request::get('stored_type_id')) }}"
                    name="stored_type_id"
                ></select-input>
            </label>

            <div class="mt-4">
                <button class="button button-blue">
                    {{ __('auth.form.submit') }}
                </button>
            </div>
        </form>
    </div>
@endsection

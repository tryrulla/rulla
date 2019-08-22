@extends('layouts.app')

@section('title', __('items.types.create.title'))

@section('content')
    <div class="card">
        <h2 class="title text-xl">
            {{ __('items.types.create.title') }}
        </h2>

        <form action="{{ route('items.types.store') }}" method="POST">
            @csrf

            <label class="block mt-4">
                <span class="text-gray-700">{{ __('items.types.create.fields.name') }}</span>
                <input class="form-input mt-1 block w-full" type="text" name="name" value="{{ old('name') }}"
                    {{ empty(old('name', '')) ? 'autofocus' : '' }}>
            </label>

            <div class="mt-4">
                <span class="text-gray-700">{{ __('items.types.create.fields.parent') }}</span>

                <select-input
                    name="parent_id"
                    :options="{{ $parents }}"
                    initial-value="{{ old('parent_id', Request::get('parent_id')) }}"
                ></select-input>
            </div>

            <div class="mt-4">
                <button class="button button-blue">
                    {{ __('items.types.create.submit') }}
                </button>
            </div>
        </form>
    </div>
@endsection

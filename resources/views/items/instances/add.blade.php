@extends('layouts.app')

@section('title', __('items.instances.create.title'))

@section('content')
    <div class="mt-4">
        <h2 class="title text-xl">
            {{ __('items.instances.create.title') }}
        </h2>

        <form action="{{ route('items.instances.store') }}" method="POST">
            @csrf

            <div class="card">
                <label class="block">
                    <span class="text-gray-700">{{ __('items.instances.create.form.tag') }}</span>
                    <input class="form-input mt-1 block w-full" type="text" name="tag" value="{{ old('tag') }}">
                </label>

                <div class="mt-4">
                    <span class="text-gray-700">{{ __('items.types.create.form.type') }}</span>

                    <select-input
                        name="type_id"
                        :options="{{ $types }}"
                        initial-value="{{ old('type_id', Request::get('type_id')) }}"
                    ></select-input>
                </div>

                <div class="mt-4">
                    <span class="text-gray-700">{{ __('items.types.create.form.location') }}</span>

                    <select-input
                        name="location_identifier"
                        :options="{{ $locations }}"
                        initial-value="{{ old('location_identifier', Request::get('location_identifier')) }}"
                    ></select-input>
                </div>
            </div>

            <div class="card">
                <button class="button button-blue">
                    {{ __('items.instances.create.submit') }}
                </button>
            </div>
        </form>
    </div>
@endsection

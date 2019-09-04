@extends('layouts.app')

@section('title', __('items.fields.apply_to.create.title'))

@section('content')
    <div class="card">
        <h2 class="title text-xl">
            {{ __('items.fields.apply_to.create.title') }}
        </h2>

        <form action="{{ route('items.field-apply.store') }}" method="POST">
            @csrf

            <label class="block mt-4">
                <span class="text-gray-700">{{ __('items.fields.apply_to.create.field') }}</span>

                <select-input
                    :options="{{ json_encode($fields) }}"
                    initial-value="{{ old('field_id', Request::get('field_id')) }}"
                    name="field_id"
                ></select-input>
            </label>

            <label class="block mt-4">
                <span class="text-gray-700">{{ __('items.fields.apply_to.create.type') }}</span>

                <select-input
                    :options="{{ json_encode($types) }}"
                    initial-value="{{ old('type_id', Request::get('type_id')) }}"
                    name="type_id"
                ></select-input>
            </label>

            <div class="block mt-4">
                <span class="text-gray-700">{{ __('items.fields.apply_to.create.apply_to') }}</span>

                <div class="mt-2">
                    <div>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="sr-only" name="apply_to_type"/>
                            <span class="form-checkbox text-blue-400" aria-hidden="true"></span>
                            <span class="ml-2">{{ __('items.fields.modes.type') }}</span>
                        </label>
                    </div>
                    <div>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="sr-only" name="apply_to_item"/>
                            <span class="form-checkbox text-blue-400" aria-hidden="true"></span>
                            <span class="ml-2">{{ __('items.fields.modes.item') }}</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button class="button button-blue">
                    {{ __('items.fields.apply_to.create.submit') }}
                </button>
            </div>
        </form>
    </div>
@endsection

@extends('layouts.app')

@section('title', __('items.types.storage.title'))

@section('content')
    <div class="card">
        <h2 class="title text-xl">
            {{ __('items.types.storage.title') }}
        </h2>

        <form action="{{ route('items.type-storage.store') }}" method="POST">
            @csrf

            <label class="block mt-4">
                <span class="text-gray-700">{{ __('items.types.storage.location') }}</span>

                <search-input
                    initial-value="{{ old('storage_type_id', Request::get('storage_type_id')) }}"
                    :filter="{{ json_encode(['type' => \Rulla\Items\Types\ItemType::class]) }}"
                    id="storage_type"
                ></search-input>
            </label>

            <label class="block mt-4">
                <span class="text-gray-700">{{ __('items.types.storage.type') }}</span>

                <search-input
                    initial-value="{{ old('stored_type_id', Request::get('stored_type_id')) }}"
                    :filter="{{ json_encode(['type' => \Rulla\Items\Types\ItemType::class, 'type-has-parent' => 1]) }}"
                    id="stored_type"
                ></search-input>
            </label>

            <div class="block mt-4">
                <span class="text-gray-700">{{ __('items.types.storage.apply_to') }}</span>

                <div class="mt-2">
                    <div>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="sr-only" name="storage"/>
                            <span class="form-checkbox text-blue-400" aria-hidden="true"></span>
                            <span class="ml-2">{{ __('items.types.storage.mode.storage') }}</span>
                        </label>
                    </div>
                    <div>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="sr-only" name="checkout"/>
                            <span class="form-checkbox text-blue-400" aria-hidden="true"></span>
                            <span class="ml-2">{{ __('items.types.storage.mode.checkout') }}</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button class="button button-blue">
                    {{ __('items.types.storage.submit') }}
                </button>
            </div>
        </form>
    </div>
@endsection

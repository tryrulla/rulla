@extends('layouts.app')

@section('title', __('items.fields.create.title'))

@section('content')
    <div class="mt-4">
        <h2 class="title text-xl">
            {{ __('items.fields.create.title') }}
        </h2>

        <form action="{{ route('items.fields.store') }}" method="POST">
            @csrf

            <div class="card">
                <label class="block">
                    <span class="text-gray-700">{{ __('items.fields.create.form.name') }}</span>
                    <input class="form-input mt-1 block w-full" type="text" name="name" value="{{ old('name') }}"
                        {{ empty(old('name', '')) ? 'autofocus' : '' }}>
                </label>

                <div class="mt-4">
                    <span class="text-gray-700">{{ __('items.fields.create.form.type') }}</span>

                    <select-input
                        name="type"
                        :options="{{ json_encode(\Rulla\Items\Fields\FieldType::getValues()) }}"
                        initial-value="{{ old('type', Request::get('type')) }}"
                    ></select-input>
                </div>
            </div>

            <div class="card">
                <button class="button button-blue">
                    {{ __('items.fields.create.submit') }}
                </button>
            </div>
        </form>
    </div>
@endsection

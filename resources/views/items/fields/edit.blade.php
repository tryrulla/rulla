@extends('layouts.app')

@section('title', __('items.fields.edit.title'))

@section('content')
    <div class="mt-4">
        <h2 class="title text-xl">
            {{ __('items.fields.edit.title') }}
        </h2>

        <form action="{{ route('items.fields.update', $field->id) }}" method="POST">
            @csrf

            <div class="card">
                <label class="block">
                    <span class="text-gray-700">{{ __('items.fields.edit.form.name') }} <span class="text-gray-600">({{ __('languages.in.en') }})</span></span>
                    <input class="form-input mt-1 block w-full" type="text" name="name" value="{{ old('name', $field->name) }}"
                        {{ empty(old('name', '')) ? 'autofocus' : '' }}>
                </label>

                <label class="block mt-4">
                    <span class="text-gray-700">{{ __('items.fields.edit.form.description') }} <span class="text-gray-600">({{ __('languages.in.en') }})</span></span>
                    <textarea class="form-textarea mt-1 block w-full" rows="3" name="description">{{ old('description', $field->description) }}</textarea>
                </label>

                <div class="mt-4">
                    <span class="text-gray-700">{{ __('items.fields.edit.form.type') }}</span>

                    <select-input
                        name="type"
                        :options="{{ json_encode(\Rulla\Items\Fields\FieldType::getValues()) }}"
                        :names="{{ json_encode(__('items.fields.types')) }}"
                        initial-value="{{ old('type', $field->type) }}"
                    ></select-input>
                </div>
            </div>

            <field-custom-options
                type-selector="type"
                old-values="{{ json_encode(old('extra_options', $field->getOptions())) }}"
                :translations="{{ json_encode(__('items.fields.extra_options')) }}"
            ></field-custom-options>

            <div class="card">
                <button class="button button-blue">
                    {{ __('items.fields.edit.submit') }}
                </button>
            </div>
        </form>
    </div>
@endsection

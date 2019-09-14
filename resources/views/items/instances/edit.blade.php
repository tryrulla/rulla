@extends('layouts.app')

@section('title', __('items.instances.edit.title'))

@section('content')
    <div class="mt-4">
        <h2 class="title text-xl">
            {{ __('items.instances.edit.title') }}
        </h2>

        <form action="{{ route('items.instances.update', $item->id) }}" method="POST">
            @csrf

            <div class="card">
                <label class="block">
                    <span class="text-gray-700">{{ __('items.instances.edit.form.tag') }}</span>
                    <input class="form-input mt-1 block w-full" type="text" name="tag" value="{{ old('tag', $item->tag) }}">
                </label>

                <div class="mt-4">
                    <span class="text-gray-700">{{ __('items.instances.edit.form.type') }}</span>

                    <select-input
                        name="type_id"
                        :options="{{ $types }}"
                        initial-value="{{ old('type_id', $item->type_id) }}"
                    ></select-input>
                </div>

                <div class="mt-4">
                    <span class="text-gray-700">{{ __('items.instances.edit.form.location') }}</span>

                    <select-input
                        name="location_id"
                        typed
                        :options="{{ $locations }}"
                        initial-value="{{ old('location_id', $item->location_id) }}"
                        initial-type="{{ old('location_type', $item->location_type) }}"
                        process-extra-values-field="type_id"
                        process-extra-values-url="/app/item/instances/api/type-locations/{id}"
                    ></select-input>
                </div>
            </div>

            <div class="card">
                <h3 class="title text-lg">
                    {{ __('items.instances.create.fields.title') }}
                </h3>

                <div>
                    <field-editor
                        id-selector="type_id"
                        msg-none-available="{{ __('items.instances.create.fields.none') }}"
                        field-url="/app/item/instances/api/fields/{id}"
                        :default-fields="{{ $fields }}"
                        :original-values="{{ old('field-values', $item->fields) }}"
                    ></field-editor>
                </div>
            </div>

            <div class="card">
                <button class="button button-blue">
                    {{ __('items.instances.edit.submit') }}
                </button>
            </div>
        </form>
    </div>
@endsection

@extends('layouts.app')

@section('title', __('items.types.edit.title'))

@section('content')
    <div class="mt-4">
        <h2 class="title text-xl">
            {{ __('items.types.edit.title') }}
        </h2>

        <form action="{{ route('items.types.update', $type->id) }}" method="POST">
            @csrf

            <div class="card">
                <label class="block">
                    <span class="text-gray-700">
                        {{ __('items.types.edit.form.name') }}
                    </span>

                    <input class="form-input mt-1 block w-full" name="name" type="text" value="{{ old('name', $type->name) }}">
                </label>

                <label class="block mt-4">
                    <span class="text-gray-700">
                        {{ __('items.types.edit.form.parent_id') }}
                    </span>

                    <select-input
                        :options="{{ $parentChoices }}"
                        initial-value="{{ old('parent_id', $type->parent_id) }}"
                        name="parent_id"
                    ></select-input>
                </label>
            </div>

            <div class="card">
                <h3 class="title text-lg">
                    {{ __('items.types.edit.fields.title') }}
                </h3>

                <div>
                    <field-editor
                        id-selector="parent_id"
                        msg-none-available="{{ __('items.types.edit.fields.none') }}"
                        field-url="/app/item/types/{id}/api/fields"
                        :default-fields="{{ $fields }}"
                        :original-values="{{ old('field-values', $type->fields) }}"
                    ></field-editor>
                </div>
            </div>

            <div class="card">
                <button class="button button-blue">
                    {{ __('auth.form.submit') }}
                </button>
            </div>
        </form>
    </div>
@endsection

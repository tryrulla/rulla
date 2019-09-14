@extends('layouts.app')

@section('title', __('items.types.create.title'))

@section('content')
    <div class="mt-4">
        <h2 class="title text-xl">
            {{ __('items.types.create.title') }}
        </h2>

        <form action="{{ route('items.types.store') }}" method="POST">
            @csrf

            <div class="card">
                <label class="block">
                    <span class="text-gray-700">{{ __('items.types.create.form.name') }}</span>
                    <input class="form-input mt-1 block w-full" type="text" name="name" value="{{ old('name') }}"
                        {{ empty(old('name', '')) ? 'autofocus' : '' }}>
                </label>

                <div class="mt-4">
                    <span class="text-gray-700">{{ __('items.types.create.form.parent') }}</span>

                    <select-input
                        name="parent_id"
                        :options="{{ $parents }}"
                        initial-value="{{ old('parent_id', Request::get('parent_id')) }}"
                    ></select-input>
                </div>
            </div>

            <div class="card">
                <h3 class="title text-lg">
                    {{ __('items.types.create.fields.title') }}
                </h3>

                <div>
                    <field-editor
                        id-selector="parent_id"
                        msg-none-available="{{ __('items.types.create.fields.none') }}"
                        field-url="/app/item/types/{id}/api/fields"
                        :default-fields="[]"
                        :original-values="[]"
                    ></field-editor>
                </div>
            </div>

            <div class="card">
                <button class="button button-blue">
                    {{ __('items.types.create.submit') }}
                </button>
            </div>
        </form>
    </div>
@endsection

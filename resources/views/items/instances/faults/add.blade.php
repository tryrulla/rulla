@extends('layouts.app')

@section('title', __('items.faults.create'))

@section('content')
    <div class="mt-4">
        <h2 class="title text-xl">
            {{ __('items.faults.create') }}
        </h2>

        <form action="{{ route('items.faults.store') }}" method="POST">
            @csrf

            <div class="card">
                <label class="block">
                    <span class="text-gray-700">{{ __('items.faults.fields.title') }}</span>
                    <input class="form-input mt-1 block w-full" type="text" name="title" value="{{ old('title', Request::get('title')) }}">
                </label>

                <label class="block mt-4">
                    <span class="text-gray-700">{{ __('items.faults.fields.description') }}</span>
                    <textarea class="form-textarea mt-1 block w-full" name="description">{{ old('description', Request::get('description')) }}</textarea>
                </label>
            </div>

            <div class="card">
                <div>
                    <span class="text-gray-700">{{ __('items.faults.fields.item') }}</span>
                    <search-input
                        :filter="{{ json_encode(['type' => \Rulla\Items\Instances\Item::class]) }}"
                        initial-value="{{ old('item_id') }}"
                        id="item"
                    ></search-input>
                </div>

                <div class="mt-4">
                    <span class="text-gray-700">{{ __('items.faults.fields.assignee') }}</span>
                    <search-input
                        :filter="{{ json_encode(['type' => \Rulla\Authentication\Models\User::class]) }}"
                        initial-value="{{ old('assignee_id') }}"
                        id="assignee"
                    ></search-input>
                </div>
            </div>

            <div class="card">
                <button class="button button-blue">
                    {{ __('general.submit') }}
                </button>
            </div>
        </form>
    </div>
@endsection

@extends('layouts.app')

@section('title', __('items.faults.edit'))

@section('content')
    <div class="mt-4">
        <h1 class="title text-2xl">
            {{ __('items.faults.edit') }}
        </h1>

        <form action="{{ route('items.faults.update', $fault->id) }}" method="POST">
            @csrf

            <div class="card">
                <label class="block">
                    <span class="text-gray-700">{{ __('items.faults.fields.title') }}</span>
                    <input class="form-input mt-1 block w-full" type="text" name="title" value="{{ old('title', $fault->title) }}">
                </label>

                <label class="block mt-4">
                    <span class="text-gray-700">{{ __('items.faults.fields.description') }}</span>
                    <textarea class="form-textarea mt-1 block w-full" name="description">{{ old('description', $fault->description) }}</textarea>
                </label>
            </div>

            <div class="card">
                <div>
                    <span class="text-gray-700">{{ __('items.faults.fields.assignee') }}</span>
                    <search-input
                        :filter="{{ json_encode(['type' => \Rulla\Authentication\Models\User::class]) }}"
                        initial-value="U1"
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

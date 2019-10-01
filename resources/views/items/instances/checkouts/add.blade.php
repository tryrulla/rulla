@extends('layouts.app')

@section('title', __('items.faults.create'))

@section('content')
    <div class="mt-4">
        <h2 class="title text-xl">
            {{ __('items.checkouts.create') }}
        </h2>

        <form action="{{ route('items.checkout.store') }}" method="POST">
            @csrf

            <div class="card">
                <div>
                    <span class="text-gray-700">{{ __('items.checkouts.fields.item') }}</span>
                    <search-input
                        :filter="{{ json_encode(['type' => \Rulla\Items\Instances\Item::class]) }}"
                        initial-value="{{ old('item_id', Request::input('item_id')) }}"
                        id="item"
                    ></search-input>
                </div>
            </div>

            <div class="card">
                <div>
                    <span class="text-gray-700">{{ __('items.checkouts.fields.user') }}</span>
                    <search-input
                        :filter="{{ json_encode(['type' => \Rulla\Authentication\Models\User::class]) }}"
                        initial-value="{{ old('user_id', Request::input('user_id')) }}"
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

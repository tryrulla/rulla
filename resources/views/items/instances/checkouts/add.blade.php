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
                    <h2 class="title">
                        {{ __('items.checkouts.checkout-to.title') }}
                    </h2>

                    <div class="text-gray-700 text-sm">
                        {{ __('items.checkouts.checkout-to.help') }}
                    </div>
                </div>

                <div class="mt-4">
                    <span class="text-gray-700">{{ __('items.checkouts.fields.user') }}</span>
                    <search-input
                        :filter="{{ json_encode(['type' => \Rulla\Authentication\Models\User::class]) }}"
                        initial-value="{{ old('user_id', Request::input('user_id')) }}"
                        id="user"
                    ></search-input>
                </div>

                <div class="mt-4">
                    <span class="text-gray-700">{{ __('items.checkouts.fields.location') }}</span>
                    <search-input
                        :filter="{{ json_encode(['type' => \Rulla\Items\Types\ItemType::class]) }}"
                        initial-value="{{ old('location_id', Request::input('location_id')) }}"
                        id="location"
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

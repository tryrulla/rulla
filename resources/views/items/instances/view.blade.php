@extends('layouts.app')

@section('title', $item->identifier)

@section('content')
    <div class="mt-4">
        @if($item->tag)
            <h3 class="font-bold">
                {{ $item->identifier }}
            </h3>
        @endif

        <h1 class="title text-2xl">
            {{ $item->tag ?? $item->identifier }}
        </h1>

        @if($item->system)
            <div class="bg-white flex items-center leading-none text-blue-700 rounded-full p-2 shadow-lg mb-4">
                <span class="inline-flex bg-blue-600 text-white rounded-full h-6 px-3 justify-center items-center">
                    {{ __('items.instances.view.system.title') }}
                </span>
                <span class="px-2">
                    {{ __('items.instances.view.system.text') }}
                </span>
            </div>
        @else
            <div class="mt-2">
                <div class="inline-block bg-gray-100 text-gray-700 p-2 shadow rounded">
                    <a href="{{ route('items.instances.edit', $item->id) }}" class="group">
                        <i class="fas fa-pen"></i> <span
                            class="group-hover:underline">{{ __('items.instances.view.edit') }}</span>
                    </a>
                </div>

                @if($item->isCheckedOut())
                    <form action="{{ route('items.checkout.delete', $item->getActiveCheckout()) }}" method="POST" class="inline-block">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="bg-gray-100 text-gray-700 p-2 shadow rounded hover:underline">
                            {{ __('items.instances.view.return') }}
                        </button>
                    </form>
                @else
                    <div class="inline-block bg-gray-100 text-gray-700 p-2 shadow rounded">
                        <a href="{{ route('items.checkout.add', ['item_id' => $item->id]) }}" class="hover:underline">
                            {{ __('items.instances.view.checkout') }}
                        </a>
                    </div>
                @endif

                <div class="inline-block bg-gray-100 text-gray-700 p-2 shadow rounded">
                    <a href="{{ route('items.faults.add', ['item_id' => $item->identifier]) }}" class="group">
                        <span class="group-hover:underline">{{ __('items.instances.view.add-fault') }}</span>
                    </a>
                </div>
            </div>
        @endif

        <div class="card">
            <h3 class="font-bold">
                {{ __('items.instances.view.details.title') }}
            </h3>

            <div class="px-2">
                <table>
                    @if($item->tag)
                        <tr>
                            <th class="pr-4">
                                {{ __('items.instances.view.details.tag') }}
                            </th>

                            <td>
                                {{ $item->tag }}
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <th class="pr-4">
                            {{ __('items.instances.view.details.type') }}
                        </th>

                        <td>
                            <a href="{{ $item->type->viewUrl }}">
                                <span class="hover:underline text-gray-900 hover:text-black group">
                                    <span class="text-gray-700 group-hover:text-gray-900">
                                        {{ $item->type->identifier }}
                                    </span>

                                    {{ $item->type->name }}
                                </span>

                                @if($item->type->system)
                                    <span class="pl-1 text-gray-600">
                                        {{ __('items.types.index.system') }}
                                    </span>
                                @endif
                            </a>
                        </td>
                    </tr>

                    @if($item->location)
                        <tr>
                            <th class="pr-4">
                                {{ __('items.instances.view.details.location') }}
                            </th>

                            <td>
                                <a href="{{ $item->location->viewUrl }}">
                                    <span class="hover:underline text-gray-900 hover:text-black group">
                                        <span class="text-gray-700 group-hover:text-gray-900">
                                            {{ $item->location->identifier }}
                                        </span>

                                        {{ $item->location->name ?? $item->location->tag }}</span>

                                    @if($item->location->system)
                                        <span class="pl-1 text-gray-600">
                                            {{ __('items.types.index.system') }}
                                        </span>
                                    @endif
                                </a>
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>

        @if($item->lastCheckouts->isNotEmpty())
                @component('components.cards.lists.checkouts', ['checkouts' => $item->lastCheckouts, 'title' => __('items.checkouts.latest-checkouts')])
                @endcomponent
            @endif

        @if($item->lastFaults->isNotEmpty())
            @component('components.cards.lists.faults', ['faults' => $item->lastFaults, 'title' => __('items.faults.latest-faults'), 'showAssignee' => true])
            @endcomponent
        @endif

        @if($item->locatedHere->isNotEmpty())
            @component('components.cards.lists.instances', ['items' => $item->locatedHere, 'title' => __('items.types.view.locatedHere.title'), 'doNotShowLocation' => true])
            @endcomponent
        @endif

        @if($item->fields->isNotEmpty())
            @component('components.cards.lists.field-values', ['title' => __('items.instances.view.fields.title'), 'fields' => $item->fields])
            @endcomponent
        @endif

    </div>

@endsection

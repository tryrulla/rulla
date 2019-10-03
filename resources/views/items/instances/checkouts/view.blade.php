@extends('layouts.app')

@section('title', $checkout->identifier)

@section('content')
    <div class="mt-4">
        <h1 class="title text-2xl">
            {{ $checkout->identifier }}
        </h1>

        @if($checkout->returned_at === null)
            <div class="mt-2">
                <form action="{{ route('items.checkout.delete', $checkout) }}" method="POST" class="inline-block">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="bg-gray-100 text-gray-700 p-2 shadow rounded hover:underline">
                        {{ __('items.instances.view.return') }}
                    </button>
                </form>
            </div>
        @endif

        <div class="card">
            <h3 class="font-bold">
                {{ __('general.cards.details') }}
            </h3>

            <div class="px-2">
                <table>
                    <tr>
                        <th class="pr-4">
                            {{ __('items.checkouts.fields.id') }}
                        </th>

                        <td>
                            {{ $checkout->identifier }}
                        </td>
                    </tr>

                    <tr>
                        <th class="pr-4">
                            {{ __('items.checkouts.fields.item') }}
                        </th>

                        <td>
                            <a href="{{ $checkout->item->view_url }}" class="hover:underline">
                                <span class="text-gray-700">
                                    {{ $checkout->item->identifier }}
                                </span>

                                {{ $checkout->item->tag }}
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <th class="pr-4">
                            {{ __('items.checkouts.fields.type') }}
                        </th>

                        <td>
                            <a href="{{ $checkout->item->type->view_url }}" class="hover:underline">
                                <span class="text-gray-700">
                                    {{ $checkout->item->type->identifier }}
                                </span>

                                {{ $checkout->item->type->name }}
                            </a>
                        </td>
                    </tr>

                    @if($checkout->due_date)
                        <tr>
                            <th class="pr-4">
                                {{ __('items.checkouts.fields.due_date') }}
                            </th>

                            <td>
                                {{ \Rulla\Utils\Date::format($checkout->due_date) }}
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <th class="pr-4">
                            {{ __('items.checkouts.fields.returned_at') }}
                        </th>

                        <td>
                            @if($checkout->returned_at)
                                {{ \Rulla\Utils\Date::format($checkout->returned_at) }}
                            @else
                                <span class="text-gray-700">
                                    @if($checkout->due_date && ($checkout->due_date->isPast()))
                                        {{ __('items.checkouts.missing') }}
                                    @else
                                        {{ __('items.checkouts.out') }}
                                    @endif
                                </span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card">
            <h3 class="font-bold">
                {{ __('general.cards.target') }}
            </h3>

            <div class="px-2">
                <table>
                    @if($checkout->user)
                        <tr>
                            <th class="pr-4">
                                {{ __('items.checkouts.fields.user') }}
                            </th>

                            <td>
                                <a href="{{ $checkout->user->viewUrl }}">
                                    <span class="hover:underline text-gray-900 hover:text-black">
                                        <span class="text-gray-700">
                                            {{ $checkout->user->identifier }}
                                        </span>

                                        {{ $checkout->user->name }}
                                    </span>
                                </a>
                            </td>
                        </tr>
                    @endif

                    @if($checkout->location)
                        <tr>
                            <th class="pr-4">
                                {{ __('items.checkouts.fields.location') }}
                            </th>

                            <td>
                                <a href="{{ $checkout->location->viewUrl }}">
                                    <span class="hover:underline text-gray-900 hover:text-black">
                                        <span class="text-gray-700">
                                            {{ $checkout->location->identifier }}
                                        </span>

                                        {{ $checkout->location->name }}
                                    </span>
                                </a>
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>

    @component('components.cards.lists.comments', ['commentable' => $checkout])
        @endcomponent
    </div>

@endsection

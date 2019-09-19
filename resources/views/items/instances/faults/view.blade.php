@extends('layouts.app')

@section('title', $fault->identifier)

@section('content')
    <div class="mt-4">
        <h3 class="font-bold">
            {{ $fault->identifier }}
        </h3>

        <h1 class="title text-2xl">
            {{ $fault->title }}
        </h1>

        <div class="mt-2">
            <div class="inline-block bg-gray-100 text-gray-700 p-2 shadow rounded">
                <a href="{{ route('items.faults.edit', $fault->id) }}" class="group">
                    <i class="fas fa-pen"></i> <span
                        class="group-hover:underline">{{ __('general.edit') }}</span>
                </a>
            </div>
        </div>

        <div class="card">
            <h3 class="font-bold">
                {{ __('general.cards.details') }}
            </h3>

            <div class="px-2">
                <table>
                    <tr>
                        <th class="pr-4">
                            {{ __('items.faults.fields.id') }}
                        </th>

                        <td>
                            {{ $fault->identifier }}
                        </td>
                    </tr>

                    <tr>
                        <th class="pr-4">
                            {{ __('items.faults.fields.item') }}
                        </th>

                        <td>
                            <a href="{{ route('items.instances.view', $fault->item->id) }}" class="hover:underline">
                                <span class="text-gray-700">
                                    {{ $fault->item->identifier }}
                                </span>

                                {{ $fault->item->tag }}
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <th class="pr-4">
                            {{ __('items.faults.fields.type') }}
                        </th>

                        <td>
                            <a href="{{ route('items.types.view', $fault->item->type->id) }}" class="hover:underline">
                                <span class="text-gray-700">
                                    {{ $fault->item->type->identifier }}
                                </span>

                                {{ $fault->item->type->name }}
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <th class="pr-4">
                            {{ __('items.faults.fields.status') }}
                        </th>

                        <td>
                            {{ $fault->closed ? __('items.faults.fields.closed') : __('items.faults.fields.open') }}
                        </td>
                    </tr>

                    <tr>
                        <th class="pr-4">
                            {{ __('items.faults.fields.assignee') }}
                        </th>

                        <td>
                            @if($fault->assignee)
                                <a href="{{ $fault->assignee->viewUrl }}">
                                    <span class="hover:underline text-gray-900 hover:text-black">
                                        {{ $fault->assignee->name }}

                                        <span class="text-gray-700">
                                            ({{ $fault->assignee->email }})
                                        </span>
                                    </span>
                                </a>
                            @else
                                <span class="text-gray-700">
                                    &ndash;
                                </span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="pr-4">
                            {{ __('items.faults.fields.title') }}
                        </th>

                        <td>
                            {{ $fault->title }}
                        </td>
                    </tr>

                    <tr>
                        <th class="pr-4">
                            {{ __('items.faults.fields.description') }}
                        </th>

                        <td class="whitespace-pre-line">{{ $fault->description }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

@endsection

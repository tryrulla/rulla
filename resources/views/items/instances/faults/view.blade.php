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
                        class="group-hover:underline">{{ __('items.faults.view.edit') }}</span>
                </a>
            </div>
        </div>

        <div class="card">
            <h3 class="font-bold">
                {{ __('items.faults.view.details.title') }}
            </h3>

            <div class="px-2">
                <table>
                    <tr>
                        <th class="pr-4">
                            {{ __('items.faults.view.details.id') }}
                        </th>

                        <td>
                            {{ $fault->identifier }}
                        </td>
                    </tr>

                    <tr>
                        <th class="pr-4">
                            {{ __('items.faults.view.details.item') }}
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
                            {{ __('items.faults.view.details.type') }}
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
                            {{ __('items.faults.view.details.field-title') }}
                        </th>

                        <td>
                            {{ $fault->title }}
                        </td>
                    </tr>

                    <tr>
                        <th class="pr-4">
                            {{ __('items.faults.view.details.description') }}
                        </th>

                        <td class="whitespace-pre-line">{{ $fault->description }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

@endsection

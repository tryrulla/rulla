@extends('layouts.app')

@section('title', $type->identifier)

@section('content')
    <div class="mt-4">
        <h3 class="font-bold">
            {{ $type->identifier }}
        </h3>

        <h1 class="title text-2xl">
            {{ $type->name }}
        </h1>

        @if($type->system)
            <div class="bg-white flex items-center leading-none text-blue-700 rounded-full p-2 shadow-lg mb-4">
                <span class="inline-flex bg-blue-600 text-white rounded-full h-6 px-3 justify-center items-center">
                    {{ __('items.types.view.system.title') }}
                </span>
                <span class="px-2">
                    {{ __('items.types.view.system.text') }}
                </span>
            </div>
        @endif

        @if(!$type->system)
            <div class="mt-2">
                <div class="inline-block bg-gray-100 text-gray-700 p-2 shadow rounded">
                    <a href="{{ route('items.types.edit', $type->id) }}" class="group">
                        <i class="fas fa-pen"></i> <span
                            class="group-hover:underline">{{ __('items.types.view.edit') }}</span>
                    </a>
                </div>
            </div>

            <div class="card">
                <h3 class="font-bold">
                    {{ __('items.types.view.details.title') }}
                </h3>

                <div class="px-2">
                    <table>
                        <tr>
                            <th class="pr-4">
                                {{ __('items.types.view.details.parent') }}
                            </th>

                            <td>
                                <a href="{{ $type->parent->viewUrl }}">
                                    <span class="hover:underline text-gray-900 hover:text-black">
                                        {{ $type->parent->name }}</span>

                                    @if($type->parent->system)
                                        <span class="pl-1 text-gray-600">
                                            {{ __('items.types.index.system') }}
                                        </span>
                                    @endif
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        @endif

        @component('components.cards.lists.types', ['types' => $type->children, 'title' => __('items.types.view.children.title'), 'link' => ['target' => route('items.types.add', ['parent_id' => $type->id]), 'icon' => 'fas fa-pen', 'text' => __('items.types.view.children.add')]])
        @endcomponent

        @if($type->hasParent(1))
            @component('components.cards.lists.instances', ['items' => $type->instances, 'title' => __('items.types.view.instances.title'), 'link' => ['target' => route('items.instances.add', ['type_id' => $type->id]), 'icon' => 'fas fa-pen', 'text' => __('items.types.view.instances.add')]])
            @endcomponent
        @elseif($type->hasParent(2))
            @component('components.cards.lists.instances', ['items' => $type->locatedHere, 'title' => __('items.types.view.locatedHere.title'), 'link' => ['target' => route('items.instances.add', ['location_id' => $type->identifier]), 'icon' => 'fas fa-pen', 'text' => __('items.types.view.instances.add')]])
            @endcomponent
        @endif

        @if($type->fields->isNotEmpty())
            @component('components.cards.lists.field-values', ['title' => __('items.types.view.fields.title'), 'fields' => $type->fields])
            @endcomponent
        @endif

        @if($storedAt->isNotEmpty())
            <div class="card">
                <h3 class="font-bold">
                    {{ __('items.types.view.stored.at') }}
                </h3>

                <div class="px-2">
                    <table>
                        @foreach($storedAt as $row)
                            <?php /** @var $row \Rulla\Items\Types\TypeStoredAt */ ?>
                            <tr>
                                <td class="pr-4">
                                    <a href="{{ route('items.types.view', $row->storageType) }}"
                                       class="text-gray-700 hover:underline">
                                        {{ $row->storageType->identifier }}</a>
                                </td>

                                <td class="pr-4">
                                    <a href="{{ route('items.types.view', $row->storageType) }}">
                                        <span class="hover:underline text-gray-900 hover:text-black">
                                        {{ $row->storageType->name }}</span>

                                        @if($row->storageType->system)
                                            <span class="pl-1 text-gray-600">
                                                {{ __('items.types.view.stored.system') }}
                                            </span>
                                        @endif
                                    </a>
                                </td>

                                <td class="pr-4">
                                    {{ $row->mode->map(function ($mode) { return __('items.types.storage.mode.' . $mode); })->join(', ') }}
                                </td>

                                <td class="text-gray-700 pr-4">
                                    @if($row->stored_type_id !== $type->id)
                                        ({{ __('items.types.view.stored.via') }}
                                        <a href="{{ route('items.types.view', $row->storedType) }}"
                                           class="text-gray-700 hover:underline">
                                            {{ $row->storedType->identifier }}
                                            {{ $row->storedType->name }}</a>)
                                    @endif
                                </td>

                                <td>
                                    <form action="{{ route('items.type-storage.destroy', $row) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-900 hover:underline">
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    @if(!$type->system)
                        <div class="mt-2 text-gray-600 text-xs">
                            <a href="{{ route('items.type-storage.add', ['stored_type_id' => $type->id]) }}"
                               class="hover:underline">
                                <i class="fas fa-pen"></i> {{ __('items.types.view.stored.add') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if($storedHere->isNotEmpty())
            <div class="card">
                <h3 class="font-bold">
                    {{ __('items.types.view.stored.here') }}
                </h3>

                <div class="px-2">
                    <table>
                        @foreach($storedHere as $row)
                            <?php /** @var $row \Rulla\Items\Types\TypeStoredAt */ ?>
                            <tr>
                                <td class="pr-4">
                                    <a href="{{ route('items.types.view', $row->storedType) }}"
                                       class="text-gray-700 hover:underline">
                                        {{ $row->storedType->identifier }}</a>
                                </td>

                                <td>
                                    <a href="{{ route('items.types.view', $row->storedType) }}">
                                        <span class="hover:underline text-gray-900 hover:text-black">
                                        {{ $row->storedType->name }}</span>

                                        @if($row->storedType->system)
                                            <span class="pl-1 text-gray-600">
                                                {{ __('items.types.view.stored.system') }}
                                            </span>
                                        @endif
                                    </a>
                                </td>

                                @if($row->storage_type_id !== $type->id)
                                    <td class="text-gray-700">
                                        ({{ __('items.types.view.stored.via') }}
                                        <a href="{{ route('items.types.view', $row->storage_type_id) }}"
                                           class="text-gray-700 hover:underline">
                                            {{ $row->storageType->identifier }}
                                            {{ $row->storageType->name }}</a>)
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </table>

                    @if(!$type->system)
                        <div class="mt-2 text-gray-600 text-xs">
                            <a href="{{ route('items.type-storage.add', ['storage_type_id' => $type->id]) }}"
                               class="hover:underline">
                                <i class="fas fa-pen"></i> {{ __('items.types.view.stored.add') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

@endsection

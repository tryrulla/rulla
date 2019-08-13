@extends('layouts.app')

@section('title', $type->identifier)

@section('content')
    @if($errors->any())
        <div class="card">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

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
            <div class="card">
                <h3 class="font-bold">
                    {{ __('items.types.view.properties.title') }}
                </h3>

                <div class="px-2">
                    <table>
                        @if($type->parent)
                            <tr>
                                <th class="pr-4">
                                    {{ __('items.types.view.properties.parent') }}
                                </th>

                                <td>
                                    <a href="{{ route('items.types.view', $type->parent) }}">
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
                        @endif
                    </table>

                    <div class="mt-2 text-gray-600 text-xs">
                        <i class="fas fa-pen"></i> {{ __('items.types.view.properties.edit') }}
                    </div>
                </div>
            </div>
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
                                    <a href="{{ route('items.types.view', $row->storageType) }}" class="text-gray-700 hover:underline">
                                        {{ $row->storageType->identifier }}</a>
                                </td>

                                <td>
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

                                @if($row->stored_type_id !== $type->id)
                                    <td class="text-gray-700">
                                        ({{ __('items.types.view.stored.via') }}
                                        <a href="{{ route('items.types.view', $row->storedType) }}" class="text-gray-700 hover:underline">
                                            {{ $row->storedType->identifier }}
                                         {{ $row->storedType->name }}</a>)
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </table>

                    @if(!$type->system)
                        <div class="mt-2 text-gray-600 text-xs">
                            <a href="{{ route('items.type-storage.add') }}" class="hover:underline">
                                <i class="fas fa-pen"></i> {{ __('items.types.view.properties.edit') }}
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
                                    <a href="{{ route('items.types.view', $row->storedType) }}" class="text-gray-700 hover:underline">
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
                                        <a href="{{ route('items.types.view', $row->storage_type_id) }}" class="text-gray-700 hover:underline">
                                            {{ $row->storageType->identifier }}
                                            {{ $row->storageType->name }}</a>)
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        @endif

        {{ json_encode($type) }}
    </div>

@endsection

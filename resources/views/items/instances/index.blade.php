@extends('layouts.app')

@section('title', __('items.instances.index.title'))

@section('content')
    <div class="card">
        <h1 class="title text-2xl">
            {{ __('items.instances.index.title') }}
        </h1>

        <div class="my-2">
            <div class="inline-block bg-gray-300 text-gray-700 p-2 shadow rounded">
                <a href="{{ route('items.instances.add') }}" class="group">
                    <i class="fas fa-plus"></i> <span class="group-hover:underline">{{ __('items.instances.index.add') }}</span>
                </a>
            </div>
        </div>

        <table>
            @foreach($items as $item)
                <?php /** @var \Rulla\Items\Instances\Item $item */ ?>
                <tr>
                    <td>
                        <a href="{{ $item->viewUrl }}" class="font-bold inline-block mr-2 hover:underline">
                            {{ $item->identifier }}
                        </a>
                    </td>

                    <td class="pr-2">
                        <a href="{{ $item->type->viewUrl }}" class="hover:underline">
                            <span class="text-blue-900">{{ $item->type->identifier }}</span> {{ $item->type->name }}
                        </a>
                    </td>

                    <td class="pr-2 text-gray-700">
                        {{ $item->tag }}
                    </td>

                    @if($item->location)
                        <td class="pl-1 text-gray-700">
                            <a href="{{ $item->location->viewUrl }}" class="hover:underline">
                                <span class="text-blue-900">{{ $item->location->identifier }}</span> {{ $item->location->name ?? $item->location->tag }}
                            </a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>

        {{ $items->links() }}
    </div>

@endsection

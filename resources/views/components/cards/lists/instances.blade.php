<div class="card">
    <h3 class="font-bold">
        {{ $title }}
    </h3>

    <div class="px-2">
        <table>
            @foreach($items as $item)
                <?php /** @var \Rulla\Items\Instances\Item $item */ ?>
                <tr>
                    <td class="pr-4">
                        <a href="{{ $item->viewUrl }}" class="text-gray-700 hover:underline">
                            {{ $item->identifier }}</a>
                    </td>

                    <td class="pr-2">
                        <a href="{{ $item->viewUrl }}">
                                        <span class="hover:underline text-gray-900 hover:text-black">
                                            {{ $item->tag }}</span>
                        </a>
                    </td>

                    @if($item->location)
                        <td class="pl-1 text-gray-700">
                            <a href="{{ $item->location->viewUrl }}" class="hover:underline">
                                <span class="text-blue-900">{{ $item->location->identifier }}</span> {{ $item->location->name }}
                            </a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>

        @if($link)
            <div class="mt-2 text-gray-600 text-xs">
                <a href="{{ $link['target'] }}" class="hover:underline">
                    <i class="{{ $link['icon'] }}"></i> {{ $link['text'] }}
                </a>
            </div>
        @endif
    </div>
</div>

<div class="card">
    <h3 class="font-bold">
        {{ $title }}
    </h3>

    <div class="px-2">
        <table>
            @foreach($types as $type)
                <?php /** @var \Rulla\Items\Types\ItemType $type */ ?>
                <tr>
                    <td class="pr-4">
                        <a href="{{ $type->viewUrl }}" class="text-gray-700 hover:underline">
                            {{ $type->identifier }}</a>
                    </td>

                    <td class="pr-2">
                        <a href="{{ $type->viewUrl }}">
                            <span class="hover:underline text-gray-900 hover:text-black">
                                {{ $type->name }}</span>
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>

        @if(isset($link))
            <div class="mt-2 text-gray-600 text-xs">
                <a href="{{ $link['target'] }}" class="hover:underline">
                    <i class="{{ $link['icon'] }}"></i> {{ $link['text'] }}
                </a>
            </div>
        @endif
    </div>
</div>

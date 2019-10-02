<div class="card">
    <h3 class="font-bold">
        {{ $title }}
    </h3>

    <div class="px-2">
        <table>
            <tr>
                <th class="pr-2">
                    {{ __('items.checkouts.fields.id') }}
                </th>

                <th class="pr-2">
                    {{ __('items.checkouts.fields.created_at') }}
                </th>

                <th class="pr-2">
                    {{ __('items.checkouts.fields.returned_at') }}
                </th>

                <th class="pr-2">
                    {{ __('items.checkouts.fields.due_date') }}
                </th>

                @if(isset($showItem) && $showItem)
                    <th>
                        {{ __('items.checkouts.fields.item') }}
                    </th>
                @endif
            </tr>

            @foreach($checkouts as $checkout)
                <?php /** @var Rulla\Items\Instances\ItemCheckout $checkout */ ?>
                <tr>
                    <td class="pr-4 text-gray-700">
                        <a href="{{ $checkout->viewUrl }}" class="hover:underline">
                            {{ $checkout->identifier }}
                        </a>
                    </td>

                    <td class="pr-2">
                        {{ \Rulla\Utils\Date::format($checkout->created_at) }}
                    </td>

                    <td class="pr-2">
                        {{ \Rulla\Utils\Date::format($checkout->returned_at) }}
                    </td>

                    <td class="pr-2">
                        {{ \Rulla\Utils\Date::format($checkout->due_date) }}
                    </td>

                    @if(isset($showItem) && $showItem)
                        <td class="pr-2">
                            <a href="{{ route('items.instances.view', $checkout->item->id) }}" class="hover:underline">
                                <span class="text-gray-700">
                                    {{ $checkout->item->identifier }}
                                </span>

                                {{ $checkout->item->tag }}
                            </a>
                        </td>

                        <td class="pr-2">
                            <a href="{{ route('items.types.view', $checkout->item->type->id) }}" class="hover:underline">
                                <span class="text-gray-700">
                                    {{ $checkout->item->type->identifier }}
                                </span>

                                {{ $checkout->item->type->name }}
                            </a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
</div>

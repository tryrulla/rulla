<div class="card">
    <h3 class="font-bold">
        {{ $title }}
    </h3>

    <div class="px-2">
        <table>
            @foreach($users as $user)
                <?php /** @var \Rulla\Authentication\Models\User $user */ ?>
                <tr>
                    <td class="pr-4">
                        <a href="{{ $user->viewUrl }}" class="text-gray-700 hover:underline">
                            {{ $user->identifier }}</a>
                    </td>

                    <td class="pr-2">
                        <a href="{{ $user->viewUrl }}">
                            <span class="hover:underline text-gray-900 hover:text-black">
                                {{ $user->name }}

                                <span class="text-gray-700">
                                    ({{ $user->email }})
                                </span>
                            </span>
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

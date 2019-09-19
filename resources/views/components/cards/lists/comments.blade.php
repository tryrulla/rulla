<div class="card">
    <h3 class="font-bold">
        {{ __('comments.header') }}
    </h3>

    <div class="px-2">
        {{ json_encode($comments) }}
    </div>
</div>

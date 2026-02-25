<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-outline border-base-300 text-base-content hover:bg-base-200 hover:text-base-content']) }}>
    {{ $slot }}
</button>

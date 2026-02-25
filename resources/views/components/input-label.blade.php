@props(['value'])

<label {{ $attributes->merge(['class' => 'label font-medium text-sm text-base-content']) }}>
    <span class="label-text">{{ $value ?? $slot }}</span>
</label>

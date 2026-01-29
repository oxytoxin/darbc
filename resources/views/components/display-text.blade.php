@props([
    'value' => '',
    'class' => '',
])

<p class="text-xs italic {{ $class }} {{ empty($value) ? 'opacity-0' : '' }}">
    {{ $value ?: 'Placeholder' }}
</p>

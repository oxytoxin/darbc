@props([
    'button_label' => 'Open',
    'button_size' => 'md',
    'outlined' => false,
    'dismissible' => true,
    'modal_size' => 'lg',
])

<div class="flex" x-data="{ show: false }" x-cloak x-init="$wire.on('openModal', () => show = true);
$wire.on('closeModal', () => show = false);">
    @if (isset($button))
        {{ $button }}
    @else
        <x-filament-support::button class="flex-1" :outlined="$outlined" :size="$button_size" @click="show = true">
            <span>{{ $button_label }}</span>
        </x-filament-support::button>
    @endif

    <div x-show="show" class="fixed inset-0 z-50 grid py-8 bg-gray-700 bg-opacity-75 place-items-center">
        <div x-ref="modal" x-show="show" x-transition.duration.300ms @if ($dismissible) @click.away="show = false" @endif {{ $attributes->merge()->class(['inset-0 max-h-full w-screen max-w-lg overflow-y-auto rounded bg-white p-4']) }}>
            {{ $slot }}
        </div>
    </div>
</div>

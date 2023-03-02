@php
    $state = $getFormattedState();
    
    $stateColor = match ($getStateColor()) {
        'active' => \Illuminate\Support\Arr::toCssClasses(['text-green-700 bg-green-500/10', 'dark:text-green-500' => config('tables.dark_mode')]),
        'sold' => \Illuminate\Support\Arr::toCssClasses(['text-yellow-700 bg-yellow-500/10', 'dark:text-yellow-500' => config('tables.dark_mode')]),
        'relocated' => \Illuminate\Support\Arr::toCssClasses(['text-blue-700 bg-blue-500/10', 'dark:text-blue-500' => config('tables.dark_mode')]),
        'swapped' => \Illuminate\Support\Arr::toCssClasses(['text-purple-700 bg-purple-500/10', 'dark:text-purple-500' => config('tables.dark_mode')]),
        null, 'secondary' => \Illuminate\Support\Arr::toCssClasses(['text-gray-700 bg-gray-500/10', 'dark:text-gray-300 dark:bg-gray-500/20' => config('tables.dark_mode')]),
        default => $getStateColor(),
    };
    
    $stateIcon = $getStateIcon();
    $iconPosition = $getIconPosition();
    $iconClasses = 'w-4 h-4';
@endphp

<div
     {{ $attributes->merge($getExtraAttributes())->class([
         'filament-tables-badge-column flex',
         'px-4 py-3' => !$isInline(),
         match ($getAlignment()) {
             'start' => 'justify-start',
             'center' => 'justify-center',
             'end' => 'justify-end',
             'left' => 'justify-start rtl:flex-row-reverse',
             'center' => 'justify-center',
             'right' => 'justify-end rtl:flex-row-reverse',
             default => null,
         },
     ]) }}>
    @if (filled($state))
        <div @class([
            'inline-flex items-center justify-center space-x-1 rtl:space-x-reverse min-h-6 px-2 py-0.5 text-sm font-medium tracking-tight rounded-xl whitespace-nowrap',
            $stateColor => $stateColor,
        ])>
            @if ($stateIcon && $iconPosition === 'before')
                <x-dynamic-component :component="$stateIcon" :class="$iconClasses" />
            @endif

            <span>
                {{ $state }}
            </span>

            @if ($stateIcon && $iconPosition === 'after')
                <x-dynamic-component :component="$stateIcon" :class="$iconClasses" />
            @endif
        </div>
    @endif
</div>

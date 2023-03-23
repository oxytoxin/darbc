<x-dynamic-component :component="$getFieldWrapperView()" :id="$getId()" :label="$getLabel()" :label-sr-only="$isLabelHidden()" :helper-text="$getHelperText()" :hint="$getHint()" :hint-action="$getHintAction()" :hint-color="$getHintColor()" :hint-icon="$getHintIcon()" :required="$isRequired()" :state-path="$getStatePath()">
    <div x-data="objectArrayFormComponent({
        state: $wire.{{ $applyStateBindingModifiers('entangle(\'' . $getStatePath() . '\')') }},
    })" {{ $attributes->merge($getExtraAttributes())->class(['filament-forms-object-array-component']) }} {{ $getExtraAlpineAttributeBag() }}>
        <div @class([
            'border border-gray-300 divide-y shadow-sm bg-white rounded-xl overflow-hidden',
            'dark:bg-gray-700 dark:border-gray-600 dark:divide-gray-600' => config(
                'forms.dark_mode'),
        ])>
            <table @class([
                'w-full text-start divide-y table-auto',
                'dark:divide-gray-700' => config('forms.dark_mode'),
            ])>
                <thead>
                    <tr @class([
                        'bg-gray-50',
                        'dark:bg-gray-800/60' => config('forms.dark_mode'),
                    ])>
                        @php
                            if (empty($getState()) || !is_array($getState()[0])) {
                                throw new \Exception('ObjectArrayInput must have at least one array entry.');
                            }
                            $columns = array_keys(collect($getState())->first() ?? []);
                        @endphp
                        @foreach ($columns as $column)
                            <th @class([
                                'px-4 py-2 whitespace-nowrap capitalize font-medium text-start text-sm text-gray-600',
                                'dark:text-gray-300' => config('forms.dark_mode'),
                            ]) scope="col">
                                {{ $column }}
                            </th>
                        @endforeach
                        @if (($canDeleteRows() || $isReorderable()) && $isEnabled())
                            <th class="{{ $canDeleteRows() && $isReorderable() ? 'w-16' : 'w-12' }}" scope="col" x-show="rows.length > 1">
                                <span class="sr-only"></span>
                            </th>
                        @endif
                    </tr>


                </thead>

                <tbody @if ($isReorderable()) x-sortable
                        x-on:end="reorderRows($event)" @endif x-ref="tableBody" @class([
                    'divide-y whitespace-nowrap',
                    'dark:divide-gray-600' => config('forms.dark_mode'),
                ])>
                    <template x-for="(row, index) in rows" x-bind:key="index" x-ref="rowTemplate">
                        <tr @if ($isReorderable()) x-bind:x-sortable-item="row.index" @endif @class([
                            'divide-x rtl:divide-x-reverse',
                            'dark:divide-gray-600' => config('forms.dark_mode'),
                        ])>
                            <template x-for="(column, key) in row" x-bind:key="key" x-ref="columnTemplate">
                                <td>
                                    <input class="w-full px-4 py-3 font-mono text-sm bg-transparent border-0 focus:ring-0" type="number" x-model="rows[index][key]" x-on:input.debounce.{{ $getDebounce() ?? '500ms' }}="updateState" @if (!$canEditKeys() || $isDisabled()) disabled @endif>
                                </td>
                            </template>
                            @if (($canDeleteRows() || $isReorderable()) && $isEnabled())
                                <td class="whitespace-nowrap" x-show="rows.length > 1">
                                    <div class="flex items-center justify-center gap-2">
                                        @if ($isReorderable())
                                            <button class="text-gray-600 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" type="button" x-sortable-handle>
                                                <x-heroicon-o-switch-vertical class="w-4 h-4" />

                                                <span class="sr-only">
                                                    {{ $getReorderButtonLabel() }}
                                                </span>
                                            </button>
                                        @endif

                                        @if ($canDeleteRows())
                                            <button class="text-danger-600 hover:text-danger-700" type="button" x-on:click="deleteRow(index)">
                                                <x-heroicon-o-trash class="w-4 h-4" />

                                                <span class="sr-only">
                                                    {{ $getDeleteButtonLabel() }}
                                                </span>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            @endif
                        </tr>
                    </template>
                </tbody>
            </table>

            @if ($canAddRows() && $isEnabled())
                <button type="button" x-on:click="addRow" @class([
                    'w-full px-4 py-2 flex items-center space-x-1 rtl:space-x-reverse text-sm font-medium text-gray-800 hover:bg-gray-50 focus:bg-gray-50',
                    'dark:text-white dark:bg-gray-800/60 dark:hover:bg-gray-800/30' => config(
                        'forms.dark_mode'),
                ])>
                    <x-heroicon-s-plus class="w-4 h-4" />

                    <span>
                        {{ $getAddButtonLabel() }}
                    </span>
                </button>
            @endif
        </div>
    </div>
</x-dynamic-component>

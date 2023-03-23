import Alpine from 'alpinejs'
import Focus from '@alpinejs/focus'
import FormsAlpinePlugin from '../../vendor/filament/forms/dist/module.esm'
import NotificationsAlpinePlugin from '../../vendor/filament/notifications/dist/module.esm'
import collapse from '@alpinejs/collapse'
import flatpickr from "flatpickr";
import ObjectArrayPlugin from './object-array-input'

Alpine.plugin(collapse)
Alpine.plugin(Focus)
Alpine.plugin(FormsAlpinePlugin)
Alpine.plugin(NotificationsAlpinePlugin)
Alpine.plugin(ObjectArrayPlugin)

window.Alpine = Alpine

Alpine.start()

flatpickr("#datepicker", {
    // clickOpens: true,
    dateFormat: "F d, Y",
    minDate: "today"
});

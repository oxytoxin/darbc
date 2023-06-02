import Alpine from 'alpinejs'
import Focus from '@alpinejs/focus'
import FormsAlpinePlugin from '../../vendor/filament/forms/dist/module.esm'
import NotificationsAlpinePlugin from '../../vendor/filament/notifications/dist/module.esm'
import collapse from '@alpinejs/collapse'
import flatpickr from "flatpickr";
import ObjectArrayPlugin from './object-array-input'
import '../../vendor/alperenersoy/filament-export/resources/js/filament-export.js';
import 'tippy.js/dist/tippy.css';
import tippy from 'tippy.js'
import Tooltip from "@ryangjchandler/alpine-tooltip";


Alpine.plugin(Tooltip);
Alpine.plugin(collapse)
Alpine.plugin(Focus)
Alpine.plugin(FormsAlpinePlugin)
Alpine.plugin(NotificationsAlpinePlugin)
Alpine.plugin(ObjectArrayPlugin)

window.tippy = tippy;
window.Alpine = Alpine

flatpickr("#datepicker", {
    // clickOpens: true,
    dateFormat: "F d, Y",
    minDate: "today"
});

Alpine.start()



const colors = require('tailwindcss/colors')

module.exports = {
    darkMode: 'class',
    content: ['./resources/**/*.blade.php', './vendor/filament/**/*.blade.php', './app/Http/Livewire/**/*.php'],
    theme: {
        extend: {
            colors: {
                danger: colors.rose,
                primary: {
                    "50": "#E4D6FF",
                    "100": "#C9ADFF",
                    "200": "#925CFF",
                    "300": "#5C0AFF",
                    "400": "#3D00B8",
                    "500": "#220068",
                    "600": "#1B0052",
                    "700": "#14003D",
                    "800": "#0E0029",
                    "900": "#070014"
                },
                success: colors.green,
                warning: colors.yellow,
                'custom-blue': '#220068',
                'custom-green': '#00BC13',
                'green-hover': '#0aad1b',
                'custom-orange': '#EF9A47'
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}

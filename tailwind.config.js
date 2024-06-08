const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Roboto"', 'sans-serif'],
            },
            colors: {
                'primary-100': '#FFFBF4',
                'primary-200': '#FFF7E8',
                'primary-300': '#FFEECF',
                'primary-400': '#FEE6B2',
                'primary-500': '#FEDD8F',
                'primary-600': '#FED361',
                'primary-700': '#E3BD57',
                'primary-800': '#C5A34B',
                'primary-900': '#A1853D',

                'danger': '#FE6161',

                'black': '#1e1e1e',
                'white': '#fffefe',
            },

        },
    },

    plugins: [require('@tailwindcss/forms')],
};

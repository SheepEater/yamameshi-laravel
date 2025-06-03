const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './src/resources/views/**/*.blade.php',
        './src/resources/js/**/*.js',
        
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    safelist: [
        'bg-orange-500',
        'bg-orange-600',
        'bg-orange-700',
        'hover:bg-orange-500',
        'hover:bg-orange-600',
        'hover:bg-orange-700',
        'text-white'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};

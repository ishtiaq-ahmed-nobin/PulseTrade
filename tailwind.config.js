import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                display: ['"Space Grotesk"', ...defaultTheme.fontFamily.sans],
                body: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                navy: {
                    950: '#05081A',
                    900: '#0A0F2C',
                    800: '#111938',
                    700: '#1A2550',
                    600: '#263668',
                },
                pulse: {
                    500: '#3D63FF',
                    400: '#5C7DFF',
                    300: '#8FA4FF',
                    100: '#E7ECFF',
                },
                ivory: '#F5F7FB',
            },
        },
    },

    plugins: [forms],
};

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: ['./index.html', './src/**/*.{js,jsx}'],
    theme: {
        extend: {
            colors: {
                brand: {
                    50: '#f0f4ff',
                    100: '#dbe4f5',
                    200: '#b9c9ea',
                    300: '#8ea6da',
                    400: '#5c7cc4',
                    500: '#3a5aab',
                    600: '#2b468d',
                    700: '#243a72',
                    800: '#1b2b57',
                    900: '#0f1c3f',
                    950: '#0a1128',
                },
            },
            fontFamily: {
                sans: ['Inter', 'Outfit', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
        },
    },
    plugins: [],
}

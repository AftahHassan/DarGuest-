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
                sans: ['Poppins', 'Inter', 'Segoe UI', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                navy: {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                    800: '#1e40af',
                    900: '#1e3a8a',
                    950: '#172554',
                },
                surface: {
                    50: '#f5f8fb',
                    100: '#ecf1f7',
                    200: '#dfe7ef',
                    300: '#c6d2e0',
                    400: '#94a5b8',
                    500: '#62768c',
                    600: '#495e74',
                    700: '#3a4c5f',
                    800: '#263341',
                    900: '#1a2430',
                    950: '#0b1118',
                },
                gold: {
                    50: '#faf6ec',
                    100: '#f3e9d1',
                    200: '#e9d7a6',
                    300: '#ddc184',
                    400: '#d3b375',
                    500: '#C8A96A',
                    600: '#a98a4d',
                    700: '#856b3c',
                    800: '#68542f',
                    900: '#4c3e24',
                },
            },
            boxShadow: {
                'card': '0 1px 3px 0 rgba(0,0,0,0.06), 0 1px 2px -1px rgba(0,0,0,0.04)',
                'card-hover': '0 4px 12px 0 rgba(0,0,0,0.08)',
                'elevated': '0 10px 25px -5px rgba(0,0,0,0.08), 0 4px 10px -6px rgba(0,0,0,0.04)',
            },
        },
    },

    plugins: [forms],
};

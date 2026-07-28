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
                sans: ['Outfit', 'Segoe UI', 'Tahoma', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                navy: {
                    50: '#f0f3f9',
                    100: '#d9e0ef',
                    200: '#b3c1df',
                    300: '#849bc9',
                    400: '#5a76af',
                    500: '#3e5a96',
                    600: '#2e457a',
                    700: '#1e3056',
                    800: '#152343',
                    900: '#0e1a33',
                    950: '#080f1f',
                },
                surface: {
                    50: '#f9fafb',
                    100: '#f0f2f5',
                    200: '#e5e7eb',
                    300: '#d1d5db',
                    400: '#9ca3af',
                    500: '#6b7280',
                    600: '#4b5563',
                    700: '#374151',
                    800: '#1f2937',
                    900: '#111827',
                    950: '#030712',
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

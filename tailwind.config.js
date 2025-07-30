import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/views/components/**/*.blade.php',
        './resources/js/**/*.js',
        './resources/**/*.js',
        './resources/**/*.vue', // jika pakai Vue
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'gray': {
                    50: '#F8FAFC',
                    100: '#F1F5F9',
                    200: '#E2E8F0',
                    300: '#CBD5E1',
                    400: '#94A3B8',
                    500: '#64748B',
                    600: '#475569',
                    700: '#334155',
                    800: '#1E293B',
                    900: '#0F172A',
                },
                'blue': {
                    700: '#1642FC',
                },
                'orange': {
                    700: '#FB4505',
                },
                'red': {
                    700: '#D41F1F',
                },
                'green': {
                    700: '#41C641',
                },
            },
            boxShadow: {
                '3xl': '0px 4px 16px 0px rgba(51,65,85,0.15)',
            }
        },
    },

    plugins: [forms],
    //darkMode: 'class', // aktifkan dark mode kalau ada class "dark" di elemen atas (biasanya <html>) darkMode: 'media',
    darkMode: 'media',
};

import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    darkMode: 'class',
    theme: {
        borderRadius: {
            'card-border-radius': '2rem',
            'border-radius-1': '0.4rem',
            'border-radius-2': '0.8rem',
            'border-radius-3': '1.2rem',
            'border-radius-4': '1.6rem',
            'border-radius-5': '2rem',
            'border-radius-6': '2.4rem',
        },
        extend: {
            fontFamily: {
                // sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                sans: ['Lato', ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: {
                'gradient-to-r-from-black-to-brown': "linear-gradient(to right, #00093c, #2d0b00)",
            },
            colors: {
                'custom-gray': 'rgba(56, 56, 56, 0.9)',
                'color-primary': '#7380ec',
                'color-danger': '#ff7782',
                'color-success': '#00c853',
                'color-warning': '#ffbb55',
                'color-white': '#fff',
                'color-info-dark': '#7d8da1',
                'color-info-white': '#17a2b8',
                'color-dark': '#343a40',
                'color-light': 'rgba(132, 139, 200, 0.18)',
                'color-primary-variant': '#111e88',
                'color-dark-variant': '#677483',
                'color-background': '#f6f6f9',
            },
            padding: {
                'card-padding': '1.8rem',
                'padding': '1.2rem',
            },
            boxShadow: {
                'box-shadow': '0 2rem 3rem rgba(132, 139, 200, 0.18)',
            }
        },
    },

    plugins: [forms],
};

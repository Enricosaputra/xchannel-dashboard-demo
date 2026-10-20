/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                ink: { 50: '#f6f6f7', 100: '#ecedef', 200: '#d9dbdf', 300: '#bec1c8', 400: '#9396a0', 500: '#6e7280', 600: '#535763', 700: '#3e414b', 800: '#26282f', 900: '#1b1c21', 950: '#111114' },
                accent: { 50: '#fef1f2', 100: '#fde0e2', 200: '#fbc5c9', 300: '#f69aa1', 400: '#ef6670', 500: '#e0313e', 600: '#c8222f', 700: '#a71a26', 800: '#891a24', 900: '#721b23', 950: '#3f0b10' },
            },
            fontFamily: {
                display: ['"Archivo"', 'ui-serif', 'Georgia', 'serif'],
            },
        },
    },
    plugins: [],
};

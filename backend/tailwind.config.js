/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.{blade.php,js,vue}',
    './app/**/*.php',
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#f0f9ff',
          500: '#2180a8',
          600: '#1d6e80',
          700: '#1a6873',
        },
        secondary: {
          50: '#faf5f0',
          500: '#a85247',
          600: '#984d3f',
        },
      },
    },
  },
  plugins: [],
}

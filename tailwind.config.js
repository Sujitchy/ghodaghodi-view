/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    '*.php',
    'inc/**/*.php',
    'template-parts/**/*.php',
    'src/**/*.js',
  ],
  theme: {
    extend: {
      fontFamily: {
        mukta: ['Mukta', 'sans-serif'],
      },
      colors: {
        emerald: {
          950: '#022c22',
        },
      },
    },
  },
  plugins: [],
};

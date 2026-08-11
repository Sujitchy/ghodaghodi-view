/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    '*.php',
    'inc/**/*.php',
    'template-parts/**/*.php',
    'src/**/*.js',
  ],
  safelist: [
    'font-kameron',
    'font-notosans',
  ],
  theme: {
    extend: {
      fontFamily: {
        mukta: ['Mukta', 'sans-serif'],
        kameron: ['Kameron', 'serif'],
        notosans: ['Noto Sans', 'sans-serif'],
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

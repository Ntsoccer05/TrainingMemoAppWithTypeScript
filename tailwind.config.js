/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.ts',
    './resources/**/*.vue',
      ],
  theme: {
    extend: {
      width:{
        '2full': '200.7%'
      },
      height:{
        '50vh': '50vh'
      },
    },
  },
    plugins: [],
  };

const plugin = require('tailwindcss-dir');

module.exports = {
  content: [
    './templates/**/*.twig',
    './assets/**/*.{js,jsx,ts,tsx}',
  ],
  theme: {
    extend: {},
  },
  plugins: [
    plugin(), // Active les variantes dir:ltr et dir:rtl
  ],
  variants: {
    extend: {
      textAlign: ['dir'],
      margin: ['dir'],
      padding: ['dir'],
      float: ['dir'],
      space: ['dir'],
      inset: ['dir'], // Pour left/right
      borderRadius: ['dir'],
      borderWidth: ['dir'],
      divideWidth: ['dir'],
      divideColor: ['dir'],
    },
  },
}

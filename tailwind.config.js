module.exports = {
  theme: {
    extend: {}
  },
  variants: {
      textDecoration: ['responsive', 'hover', 'focus', 'group-hover'],
  },
  plugins: [
    require('tailwind-forms')(),
    require('tailwindcss-plugins/pagination'),
  ]
};

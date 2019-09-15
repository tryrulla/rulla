module.exports = {
    theme: {
        extend: {
            screens: {
                'max-md': {max: '768px'}
            },
        },
    },
    variants: {
        textDecoration: ['responsive', 'hover', 'focus', 'group-hover'],
        textColor: ['responsive', 'hover', 'focus', 'group-hover'],
    },
    plugins: [
        require('tailwind-forms')(),
        require('tailwindcss-plugins/pagination'),
    ]
};

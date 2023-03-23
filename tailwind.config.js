const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

delete colors['lightBlue'];
delete colors['warmGray'];
delete colors['trueGray'];
delete colors['coolGray'];
delete colors['blueGray'];

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/tw-elements/dist/js/**/*.js',
      	'./resources/js/**/*.vue',
        './src/**/*.{html,js}',
  ],

    theme: {
      	colors,
  		extend: {
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms'),require('tw-elements/dist/plugin')],
};

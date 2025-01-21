const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/build/js')
   .postCss('resources/css/app.css', 'public/build/css', [
      // إضافة أي إضافات CSS هنا
   ])
   .version();

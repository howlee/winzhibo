var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.browserify('js/app.js');

    //mix.browserify('libs/jquery-validate.js','./public/js/libs/jquery-validate.js');
});
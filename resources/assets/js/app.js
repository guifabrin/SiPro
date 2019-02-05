import $ from 'jquery';

window.$ = window.jQuery = $;

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('bootstrap/js/dist/dropdown');

var siPro = {
    renderImage: function (input, imageId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#' + imageId).attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
};
window.siPro = siPro;
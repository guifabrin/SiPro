import $ from 'jquery';

window.$ = window.jQuery = $;
window.Popper = require('popper.js').default;
require('bootstrap');

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
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

$(function () {
    function resizeIframe() {
        $('iframe').each(function(index, el){
           $(el).height($(el).contents().find('html').height() + 'px')
        });
    }
    setInterval(resizeIframe, 100);
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });
    $(window).on('load resize', function(){
        window.innerWidth > 992 ? $('#siproNavbarSidebar').collapse('show') : $('#siproNavbarSidebar').collapse('hide');
    });
});
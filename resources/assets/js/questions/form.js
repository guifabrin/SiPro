import $ from 'jquery';
window.$ = window.jQuery = $;

$(function (){
    let typeSelect = $('#typeSelect');
    let linesNumber = $('#linesNumber');
    let options = $('#options');
    typeSelect.change(function(){
        switch (typeSelect.val()*1){
            case 0:
                linesNumber.show();
                options.hide();
                break;
            case 1:
                linesNumber.hide();
                options.show();
                options.find('input[type=checkbox]').attr('type','radio');
                break;
            case 2:
                linesNumber.hide();
                options.show();
                options.find('input[type=radio]').attr('type','checkbox');
                break;
        }
    });
    typeSelect.change();
});
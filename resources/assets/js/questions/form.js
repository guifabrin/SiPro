import $ from 'jquery';

window.$ = window.jQuery = $;

$(function () {
    let typeSelect = $('#typeSelect');
    let linesNumber = $('#linesNumber');
    let options = $('#options');
    typeSelect.change(function () {
        switch (typeSelect.val() * 1) {
            case 0:
                $('#linesNumber').attr('required', true);
                options.find('[name*=option-description]').each(function(_index, el){
                    $(el).removeAttr('required');
                });
                linesNumber.show();
                options.hide();
                break;
            case 1:
                $('#linesNumber').removeAttr('required');
                options.find('[name*=option-description]').each(function(_index, el){
                    $(el).attr('required', true);
                });
                linesNumber.hide();
                options.show();
                options.find('input[type=checkbox]').attr('type', 'radio');
                break;
            case 2:
                $('#linesNumber').removeAttr('required');
                options.find('[name*=option-description]').each(function(_index, el){
                    $(el).attr('required', true);
                });
                linesNumber.hide();
                options.show();
                options.find('input[type=radio]').attr('type', 'checkbox');
                break;
        }
    });
    typeSelect.change();
});
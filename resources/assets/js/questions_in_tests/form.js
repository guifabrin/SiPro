import $ from 'jquery';

window.$ = window.jQuery = $;

$(function () {
    $('input[type=radio][name=categorie_id]').change(function() {
        if (eval($(this).val())!=null){
            window.location = (baseUrl+$(this).val());
        } else {
            window.location = baseUrl;
        }
    });
    $('a.testControl').each(function(index, el){
        $(el).click(function(e) {
            $.get($(el).attr('href'), function(data, status){
                if (status==="success"){
                    var other = $(el).parent().children(".hide");
                    $(el).addClass('hide');
                    $(other).removeClass('hide');
                }
            });
            e.stopPropagation();
            e.preventDefault();
            return false;
        });
    });
});
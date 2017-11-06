/**
 * jQuery Live CSS Editor (LCE) - property editors
 * 
 * @author Milan Rukavina 2012
 */
(function(){
    function defaultEditorCallback(options){
        var input = $('<input type="text" value="" class="form-control" style="display: inline;width: 100%; "/>');
        input.val(options.value);
        input.on("change", function(){
            options.setValue(input.val());
            return false; 
        });
        options.container.html(input);
    }    
    //default
    $.fn.livecsseditor.setPropertyEditor('default',defaultEditorCallback); 

    //color
    $.fn.livecsseditor.setPropertyEditor(['color','background-color'],function colorEditorCallback(options){
        var input = $('<input type="text" class="form-control" style="display: inline;width: 100%; "/>');

        input.css('backgroundColor', options.value);
        input.css('color', options.value);

        input.ColorPicker({
            color: options.value,
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
               input.css('backgroundColor', '#' + hex);
               options.setValue(hex);
            }
        });     
        options.container.html(input); 
    });

    function getIFDoc(options){
        var iframe = document.getElementById(options.previewId);
        var doc = iframe.contentWindow || iframe.contentDocument;
        if (doc.document) {
            doc = doc.document;
        }
        return doc;
    }

    $.fn.livecsseditor.setPropertyEditor(['width'],function positionEditorCallback(options){
        var input = $('<input type="text" value="" class="form-control" style="display: inline; width:100%; "/>');

        input.val(options.value);
        input.on("change",function(){
            options.setValue(input.val());
            return false; 
        });       
        options.container.html(input);
    });

    $.fn.livecsseditor.setPropertyEditor(['font-family'],function positionEditorCallback(options){
        var select = $('<select class="form-control" style="display: inline; width: 100%; ">'+
                '<option>Georgia, serif</option>'+
                '<option>Book Antiqua</option>'+
                '<option>Times New Roman</option>'+
                '<option>Arial</option>'+
                '<option>Arial Black</option>'+
                '<option>Comic Sans MS</option>'+
                '<option>Impact</option>'+
                '<option>Lucida Sans Unicode</option>'+
                '<option>Tahoma</option>'+
                '<option>Trebuchet MS</option>'+
                '<option>Verdana</option>'+
                '<option>Courier New</option>'+
                '<option>Lucida Console</option>'+
                '<option>Lato</option>'+
                '<option>"Helvetica Neue", Helvetica, Arial, sans-serif</option>'+
            '</select>');

        select.val(options.value);
        select.on("change",function () {
            $(this).children('option:selected').each(function() {
               options.setValue($(this).text());
            });
         }).change();
        options.container.html(select);
    });

    $.fn.livecsseditor.setPropertyEditor(['display'],function positionEditorCallback(options){
        var select = $('<select class="form-control" style="display: inline; width: 100%; ">'+
                '<option value="inline">Linha</option>'+
                '<option value="block">Bloco</option>'+
            '</select>');

        select.val(options.value);
        select.on("change",function () {
            $(this).children('option:selected').each(function() {
               options.setValue($(this).val());
            });
         }).change();
        options.container.html(select);
    });


    $.fn.livecsseditor.setPropertyEditor(['font-size'],function positionEditorCallback(options){
        var pt = 0;
        try {
            pt = options.value.replace("px","")*0.75;
        }
        catch(err) {
            pt = 12;
        }
        var select = $('<select class="form-control" style="display: inline; width: 100%; ">'+
                '<option value="8">8pt</option>'+
                '<option value="9">9pt</option>'+
                '<option value="10">10pt</option>'+
                '<option value="11">11pt</option>'+
                '<option value="12">12pt</option>'+
                '<option value="14">14pt</option>'+
                '<option value="18">18pt</option>'+
                '<option value="20">20pt</option>'+
                '<option value="22">22pt</option>'+
                '<option value="24">24pt</option>'+
                '<option value="28">28pt</option>'+
                '<option value="36">36pt</option>'+
                '<option value="48">48pt</option>'+
                '<option value="72">72pt</option>'+
            '</select>');

        select.val(pt);
        select.on("change",function () {
            $(this).children('option:selected').each(function() {
               options.setValue($(this).text());
            });
         }).change();
        options.container.html(select);
    });

    $.fn.livecsseditor.setPropertyEditor(['width','max-width'],function positionEditorCallback(options){
        var select_string ='<select class="form-control" style="display: inline; width: 100%; ">';
        for (i=100; i>1; i--){
            select_string+='<option value="'+i+'">'+i+'%</option>';
        }
        select_string+='</select>';
        var select = $(select_string);
        if (options.value=="none"){
            select.val(100);
        } else {
            select.val(options.value);
        }
        select.on("change",function () {
            $(this).children('option:selected').each(function() {
               options.setValue($(this).text());
            });
         }).change();
        options.container.html(select);
    });



    $.fn.livecsseditor.setPropertyEditor(['text-align'],function positionEditorCallback(options){
        var btn_group = $('<div class="btn-group"  data-toggle="buttons">'+
                       '  <label class="btn btn-sm btn-primary active">'+
                       '    <input value="left" type="radio" name="options" checked autocomplete="off"> <i class="fa fa-align-left"></i>'+
                       '  </label>'+
                       '  <label class="btn btn-sm btn-primary">'+
                       '    <input value="center" type="radio" name="options" autocomplete="off"> <i class="fa fa-align-center"></i>'+
                       '  </label>'+
                       '  <label class="btn btn-sm btn-primary">'+
                       '    <input value="right" type="radio" name="options" autocomplete="off"> <i class="fa fa-align-right"></i>'+
                       '  </label>'+
                       '  <label class="btn btn-sm btn-primary">'+
                       '    <input value="justify" type="radio" name="options" autocomplete="off"> <i class="fa fa-align-justify"></i>'+
                       '  </label>'+
                       '</div>');

        btn_group.val(options.value);
        btn_group.find('.btn').on("click",function () {
           options.setValue($(this).children('input').val());
         });
        options.container.html(btn_group);
    });

    $.fn.livecsseditor.setPropertyEditor(['margin-bottom','margin-top'],function positionEditorCallback(options){
        var cm = 0;
        try {
            cm = options.value.replace("px","")*0.026458;
        }
        catch(err) {
            cm = 0;
        }
        var input = $('<input type="number" value="'+cm+'" min="0" step="0.01" class="form-control" style="display: inline; width:calc(100% - 4px); "/><small>cm</small>');

        input.val(cm);
        input.on("change",function () {
           options.setValue($(this).val()*37.795276+"px");
         }).change();
        options.container.html(input);
    });

})();

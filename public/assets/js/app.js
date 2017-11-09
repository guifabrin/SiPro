$(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
    var reader  = new FileReader();

    var preview = $("#"+input.attr('rendererOn'));
  	reader.onloadend = function () {
    	preview.attr('src', reader.result);
    	preview.css('display', '');
  	}

  	if (input.get(0).files[0]) {
	    reader.readAsDataURL(input.get(0).files[0]);
  	} else {
	    preview.src = "";
  	}
});
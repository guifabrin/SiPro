@extends('home')

@section('questions_active') active @endsection
@section('headerbtnl')
<a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">
<i class="fa fa-btn fa-arrow-circle-left"></i> Voltar
</a>
@endsection

@section('header')
{{ $title }} Questão
@endsection

@section('body')
{!! Form::open(['method' => 'post' , 'id' => 'answer_form']) !!}
<div class="form-group">
	{{ Form::label('id','Código:', ['class' => 'control-label']) }}
	{{ Form::text('id', (isset($question))?$question->id:null, ['class' => 'form-control', 'readonly' => 'true']) }}
</div>
<div class="form-group">
	{{ Form::label('categorie_id','Categoria:', ['class' => 'control-label']) }}
	<div id="tree"></div>
	<input type="hidden" id="categorie_id" name="categorie_id">
</div>
<div class="form-group">
	{{ Form::label('description','Descrição:', ['class' => 'control-label']) }}
	<textarea class='form-control' id="description"></textarea>
</div>
<div class="form-group">
	<div class="col-md-3 col-xs-12 columns">
		<img class="question_image image" id="question_image" src="{{ url('/assets/images/no_image.png') }}" osrc="no_image.png" onclick="show_view_image_modal(this);">
	</div>
	<div class="col-md-9 col-xs-12 columns">
		<label>Imagem da questão:</label>
		<span class="btn btn-primary-outline btn-sm btn-file">
			<i class="fa fa-upload"></i> Escolher arquivo
			<input type="file" imgid="question_image" onchange="read_image(this, false);">
		</span>
	</div>
</div>
<div class="form-group">
	{{ Form::label('answer_type','Tipo de Resposta:', ['class' => 'control-label']) }}
	{{ Form::select('answer_type', [
	'txt' => 'Dissertativa',
	'opt' => 'Optativa',
	'vof' => 'Verdadeiras ou Falsas'], null, ['class' => 'form-control', 'onchange' => 'alter_answer_type(true)']) }}
</div>
<div class="form-group">
	{{ Form::label('answer_type_title','JSON:', ['class' => 'control-label']) }}
	<div id="answer_content"></div>
</div>

<input type="hidden" name="json" id="json">

<div class="form-group">
	<button type="button" class="btn btn-sm btn-success" onclick="make_json();">
		<i class="fa fa-floppy-o"></i> Salvar
	</button>
</div>

<div id="saving_modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Salvando questão.<button style="display:hidden;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h4>
			</div>
			<div class="modal-body">
				<p>Some text in the modal.</p>
				<progress class="progress"></progress>
			</div>
		</div>
	</div>
</div>
<div id="view_image_modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Ver imagem. 
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</h4>
			</div>
			<div class="modal-body">
				<img src="{{ url('/assets/images/no_image.png') }}" style="max-width:100%">
			</div>
		</div>
	</div>
</div>
{!! Form::close() !!}

<script src="{{ url('/assets/js/bootstrap-treeview.min.js') }}"></script>
<script src="{{ url('/assets/js/categories.js') }}"></script>
<script>
	var continue_childs = true;
	function alter_answer_type(add){
		var opcao = $('#answer_type').val();
		var button = $.parseHTML('<button type="button" class="btn btn-sm btn-success-outline">'+
			'<i class="fa fa-plus"></i> Adicionar'+
			'</button>');
		if (opcao=='txt'){
			$('label[for=answer_type_title]').text("Linhas para resposta:");
			var field = '{{ Form::number("lines_number", "1", ["id" => "lines_number", "class" => "form-control", "required" => "true", "min" => "1"]) }}';
			$('#answer_content').empty().append(field);
		} else if (opcao=="vof"){
			$('label[for=answer_type_title]').text("Respostas:");
			var onclick = "add_answer({'type':'checkbox'});";
			if ($('.input_answer').length>0){
				$('.input_answer').attr('type','checkbox');
				$('#answer_content').find('button').attr('onclick', onclick);
			} else {
				$(button).attr('onclick',onclick);
				$('#answer_content').empty().append(button);
				if (add)
					add_answer({'type':'checkbox'});
			}
		} else {
			$('label[for=answer_type_title]').text("Respostas:");
			var onclick = "add_answer({'type':'radio'});";
			if ($('.input_answer').length>0){
				$('.input_answer').attr('type','radio');
				$('#answer_content').find('button').attr('onclick', onclick);
			} else {
				$(button).attr('onclick',onclick);
				$('#answer_content').empty().append(button);
				if (add)
					add_answer({'type':'radio'});
			}
		}
	}

	var answer_id = 1;
	var counter_answer = 0;
	function add_answer(params){
		var div_answer = $.parseHTML("<div class='answer' id='answer_"+answer_id+"'></div>");
		var div_column_input = $.parseHTML("<div class='col-md-2 col-xs-12 columns'></div>");
		var div_column_input_label = $.parseHTML("<label>Correta?</label>");
		var div_column_input_field = $.parseHTML("<input type='"+params.type+"' class='input_answer' value='true' name='input_answer[]'/>");
		if (params.right){
			$(div_column_input_field).attr("checked","true");
		}
		$(div_column_input).append(div_column_input_label).append(div_column_input_field);
		var div_column_image = $.parseHTML("<div class='col-md-3 col-xs-12 columns'></div>");

		var image_name = "";
		var thumb_image_name_src = "";

		if (params.image_name == undefined){
			image_name = "no_image.png";
			thumb_image_name_src = "{{ url('assets/images/') }}/no_image.png";
		} else {
			image_name = params.image_name;
			thumb_image_name_src = "{{ url('assets/images/uploads/thumbnail/') }}/"+image_name;
		}

		var div_column_image_link_field;
		if (image_name.indexOf('svg')>-1){
			div_column_image_link_field = $.parseHTML("<img onclick='show_view_image_modal(this);' class='answer_image image' id='answer_image_"+answer_id+"' src='"+thumb_image_name_src+"' osrc='"+image_name+"'/>");
		} else {
			div_column_image_link_field = $.parseHTML("<img onclick='show_view_image_modal(this);' class='answer_image image' id='answer_image_"+answer_id+"' src='"+thumb_image_name_src+"' osrc='"+image_name+"'/>");
		}

		$(div_column_image).append(div_column_image_link_field);

		var div_column_file_and_text = $.parseHTML("<div class='col-md-7 col-xs-12 columns'></div>");

		var div_column_file = $.parseHTML("<div></div>");
		var div_column_file_label = $.parseHTML("<label>Imagem da resposta:</label>");
			var div_column_file_field = $.parseHTML("<span class=\"btn btn-primary-outline btn-sm btn-file\"><i class=\"fa fa-upload\"></i> Escolher arquivo<input type=\"file\" imgid=\"answer_image_"+answer_id+"\" onchange=\"read_image(this,false)\"/></span>");

			$(div_column_file).append(div_column_file_label).append(div_column_file_field);

			var div_column_text = $.parseHTML("<div></div>");
			var div_column_text_label = $.parseHTML("<label>Texto da resposta:</label>");
			var value_text = (params.description!=undefined)?params.description:"";
			var div_column_text_field = $.parseHTML("<input type='text' class='form-control answer_text' value='"+value_text+"'/>");
			$(div_column_text).append(div_column_text_label).append(div_column_text_field);

			$(div_column_file_and_text).append(div_column_file).append("<hr>").append(div_column_text);

			$(div_answer).append(div_column_input);
			$(div_answer).append(div_column_image);
			$(div_answer).append(div_column_file_and_text);

			if (counter_answer!=0){
				var div_button_remove = $.parseHTML("<div class='col-md-12 col-xs-12 columns'></div>");
				var button_remove = $.parseHTML("<button type='button' class='btn btn-sm btn-danger-outline pull-right' onclick='remove_answer("+answer_id+")'><i class='fa fa-times'></i> Excluir</button>");

				$(div_button_remove).append(button_remove);
				$(div_answer).append(div_button_remove);
			}
			$(div_answer).insertBefore(('#answer_content>button'));

			answer_id++;
			counter_answer++;
			$('input[type=text]').keydown(function (e) {
				if (e.ctrlKey && e.keyCode == 32) {
					var txtarea = this;
					var start = txtarea.selectionStart;
					var finish = txtarea.selectionEnd;
					var sel = txtarea.value.substring(start, finish);
					txtarea.value = txtarea.value.substring(0,start)+processEnemPaste(sel)+txtarea.value.substring(finish,txtarea.value.length);
				}
			});
		}

		function remove_answer(id){
			$("#answer_"+id).remove();
			counter_answer--;
		}

		var reading_images = 0;
		function read_image(input, upload){
			var imgid = $(input).attr('imgid');
			var img = $("#"+imgid);
			if (upload){
				if (input.files && input.files[0]) {
					reading_images--;
					$(input).attr('disabled','true');
					/*img.parent().append("<div class=\"progress\">"+
						"<div class=\"progress-bar progress-bar-success\" role=\"progressbar\" id=\"l"+imgid+"\" aria-valuenow=\"70\" aria-valuemin=\"0\" aria-valuemax=\"100\">"+
						"<span>70% Complete</span>"+
						"</div>"+
						"</div>");*/
						img.parent().append('<progress class="progress" value="0" max="100" id="l'+imgid+'">0%</progress>');
						var form = new FormData();
						form.append('image',input.files[0]);
						form.append('_token','{{ csrf_token() }}');

						$.ajax({
							url: '{{ url("/home/upload/image/") }}',
							data: form,
							processData: false,
							contentType: false,
							type: 'POST',
							cache: false,
							success: function (data) {
							//{"errors":[],"image_name":"cd9c75e0b8289f5853b3854e782dce0c.png","image_exist":true,"thumb_exist":true}
							json = $.parseJSON(data);
							if (json.errors.length==0){
								if (json.image_exist){
									if (json.thumb_exist){
										reading_images++;
										img.attr('osrc',json.image_name);
									} else {
										$("#saving_modal").find(".modal-body p").text("Erro ao criar thumbnail.");
										$("#saving_modal").find(".modal-title button").css("display","initial");
										clearInterval(interval);
									}
								} else {
									$("#saving_modal").find(".modal-body p").text("Erro ao enviar imagem.");
									$("#saving_modal").find(".modal-title button").css("display","initial");
									clearInterval(interval);
								}
							} else {
								var errors = "";
								for (var error in json.errors){
									errors += json.errors[error]+"<br>";
								}
								$("#saving_modal").find(".modal-body p").html(errors);
								$("#saving_modal").find(".modal-title button").css("display","initial");
								clearInterval(interval);
							}
						},
						error: function (xhr, ajaxOptions, thrownError) {
							$('html').html(xhr.responseText);
						},
						xhr: function() {
							var xhr = new window.XMLHttpRequest();
							xhr.upload.addEventListener("progress", function(evt) {
								if (evt.lengthComputable) {
									var percentComplete = evt.loaded / evt.total;
									percentComplete = parseInt(percentComplete * 100);
									img.css('opacity',percentComplete/100);
									$("#l"+imgid).val(percentComplete).text(percentComplete+"% Completo");
								}
							}, false);

							return xhr;
						},
					});
					}
				} else {
					if (FileReader && input.files && input.files[0]) {
						var fr = new FileReader();
						fr.onload = function () {
							img.attr('src',fr.result).attr('osrc', fr.result);
						}
						fr.readAsDataURL(input.files[0]);
					}
				}
			}

			JSON.stringify = JSON.stringify || function (obj) {
				var t = typeof (obj);
				if (t != "object" || obj === null) {
					if (t == "string") obj = '"'+obj+'"';
					return String(obj);
				}
				else {
					var n, v, json = [], arr = (obj && obj.constructor == Array);
					for (n in obj) {
						v = obj[n]; t = typeof(v);
						if (t == "string") v = '"'+v+'"';
						else if (t == "object" && v !== null) v = JSON.stringify(v);
						json.push((arr ? "" : '"' + n + '":') + String(v));
					}
					return (arr ? "[" : "{") + String(json) + (arr ? "]" : "}");
				}
			};

			var interval;
			function make_json(){
				$("#saving_modal").modal({
					backdrop: 'static',
					keyboard: false
				});
				$("#saving_modal").modal("show");
				$("#saving_modal").find(".modal-body p").text("Enviando imagens...");
				$('input[type=file]').each(function(m,n){
					read_image(n,true);
				});

				interval = setInterval(function(){
					if (reading_images>=0){
						clearInterval(interval);

						$("#saving_modal").find(".modal-body p").text("Criando estrutura de questão...");
						var question = {};
						question.description = $('#description').val();
						var question_image = $('#question_image');
						var question_osrc = question_image.attr('osrc');
						if (question_osrc != "no_image.png"){
							question.image_name = question_osrc;
						}
						var answer_type = $('#answer_type').val();
						question.answer_type = answer_type;
						if (answer_type=='txt'){
							question.lines_number = $('#lines_number').val();
						} else if (answer_type=='opt' || answer_type=='vof' ) {
							question.answers = [];
							var answers = $('.answer');
							for(var i=0; i< answers.length; i++){
								var answer_item = $(answers[i]);
								var answer = {};
								answer.description = answer_item.find('.answer_text').val();
								var answer_osrc = answer_item.find('.answer_image').attr('osrc');
								if (answer_osrc != "no_image.png"){
									answer.image_name = answer_osrc;
								}
								answer.right = answer_item.find('.input_answer').prop('checked');

								question.answers.push(answer);
							}
						}

						$("#json").val(JSON.stringify(question));
						$("#saving_modal").find(".modal-body p").text("Salvando questão...");

						$("#answer_form").submit();
					}
				}, 100);
			}

			function show_view_image_modal(thumbnail){
				if ($(thumbnail).attr('osrc')=="no_image.png")
					return;
				if ($(thumbnail).attr('src').indexOf('data:image')<-1){
					$('#view_image_modal').find('.modal-body img').attr('src',$(thumbnail).attr('src'));
				} else {
					$('#view_image_modal').find('.modal-body img').attr('src',"{{ url('/assets/images/uploads/') }}/"+ $(thumbnail).attr('osrc'));
				}
				$('#view_image_modal').modal();
			}

			$(function(){
				var json_string = "{{(isset($question))?$question->json:null}}";
				if (json_string!=""){
					var json_obj = $.parseJSON(jsonEscape(json_string));
					$('#description').val(HTMLDecode(json_obj.description));

					if (json_obj.image_name!=undefined){
						if (json_obj.image_name.indexOf('svg')>-1){
							$('#question_image').attr('osrc', json_obj.image_name).attr('src', "{{ url('assets/images/uploads/') }}/"+json_obj.image_name);
						} else {
							$('#question_image').attr('osrc', json_obj.image_name).attr('src', "{{ url('assets/images/uploads/thumbnail/') }}/"+json_obj.image_name);
						}
					} else {
						$('#question_image').attr('osrc', 'no_image.png').attr('src', "{{ url('assets/images/no_image.png') }}");
					}

					$('#answer_type').val(json_obj.answer_type);

					alter_answer_type(false);
					if (json_obj.answer_type=="opt" || json_obj.answer_type=="vof"){
						for (var i = 0; i<json_obj.answers.length;i++){
							var params = {};
							if (json_obj.answer_type=='opt')
								params.type = 'radio';
							if (json_obj.answer_type=='vof')
								params.type = 'checkbox';
							params.right = json_obj.answers[i].right;
							params.description = HTMLDecode(json_obj.answers[i].description);
							params.image_name = json_obj.answers[i].image_name;
							add_answer(params);
						}
					} else {
						$('#lines_number').val(json_obj.lines_number);
					}
				} else {
					alter_answer_type(true);
				}
				<?php
				$selectedId = 0;
				if (isset($question)){
					$selectedId = $question->categorie_id;
				} else {
					if (isset($selectedCategorie)){
						$selectedId = $selectedCategorie;
					}
				}
				?>
				create_tree_categories({
					"show_actions": false,
					"input_result": $("#categorie_id"),
					"continue_childs": true,
					"selected_id": {{$selectedId}},
					"values": $.parseJSON(jsonEscape('{!! json_encode($questionCategories) !!}'))
				});

				$('textarea').keydown(function (e) {
					if (e.ctrlKey && e.keyCode == 32) {
						var txtarea = this;
						var start = txtarea.selectionStart;
						var finish = txtarea.selectionEnd;
						var sel = txtarea.value.substring(start, finish);
						txtarea.value = txtarea.value.substring(0,start)+processEnemPaste(sel)+txtarea.value.substring(finish,txtarea.value.length);
					}
				});
				$('input[type=text]').keydown(function (e) {
					if (e.ctrlKey && e.keyCode == 32) {
						var txtarea = this;
						var start = txtarea.selectionStart;
						var finish = txtarea.selectionEnd;
						var sel = txtarea.value.substring(start, finish);
						txtarea.value = txtarea.value.substring(0,start)+processEnemPaste(sel)+txtarea.value.substring(finish,txtarea.value.length);
					}
				});
			});

			function processEnemPaste(data){
				var lines = data.split('\n');

				for(var k =0; k<lines.length; k++){
					var line = lines[k];
					var newLine = "";
					var words = line.split(' ');

					for(var j =0; j<words.length; j++){
						var word = words[j];
						if (word.indexOf("")>-1){
							for (var i = 0; i<word.length; i++){
								if (word[i]!=''){
									var result = word.charCodeAt(i);
									if (result<=93){
										result += 29;
										if (result>=255){
											result = result-255;
										}
										var c = String.fromCharCode(result);
										newLine += c;
									} else if(result>93) {
										result += 120;
										if (result>=255){
											result = result-255;
										}
										var c = String.fromCharCode(result);
										newLine += c;
									}
								} else {
									newLine += " ";
								}
							}
						} else {
							newLine += word;
						}
						newLine+=" ";
					}
				}

				newLine = newLine.replace("Ü","fi").replace("Ð","\"").replace("Ñ","\"");
				return newLine;
			}

			function jsonEscape(str)  {
				return str.replace(/\n/g, "\\n").replace(/\r/g, "\\r").replace(/\t/g, "\\\\t").replace(/&quot;/g, '\"').replace(//g, '').replace(//g, '');
			}

			function HTMLDecode(str){
				return $("<div/>").html(str).text(); 
			}
		</script>
		@endsection

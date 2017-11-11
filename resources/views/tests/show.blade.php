@extends('home')

@section('tests_active') active @endsection

@section('headerbtnl')
<a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">
<i class="fa fa-btn fa-arrow-circle-left"></i> Voltar
</a> 
@endsection

@section('header')
Prova Código {{$test->id}}
@endsection

@section('headerbtnr')
<button class="btn btn-sm btn-primary" onclick="$('iframe')[0].contentWindow.print();"><i class="fa fa-print"></i> Imprimir</button>
<button class="btn btn-sm btn-primary" onclick="print_gabarito()"><i class="fa fa-print"></i> Imprimir Gabarito</button>
@endsection

@section('body')

<link rel="stylesheet" media="screen" type="text/css" href="{{url('assets/colorpicker/css/')}}/colorpicker.css" />
<link rel="stylesheet" type="text/css" href="{{url('assets/live-css-editor-master/')}}/css/livecsseditor.css">

<script type="text/javascript" src="{{url('assets/colorpicker/js/')}}/colorpicker.js"></script>
<script src="{{url('assets/live-css-editor-master/')}}/js/microtpl.js"></script>
<script src="{{url('assets/live-css-editor-master/')}}/js/jquery.livecsseditor.js"></script>
<script src="{{url('assets/live-css-editor-master/')}}/js/lce.editors.js"></script>

<script src="{{url('assets/live-css-editor-master/')}}/plugins/jquery-ui-1.9.1/js/jquery-ui-1.9.1.custom.min.js"></script>
<p class="bootstrapSwitch">
    <b>Mostrar Respostas<br>na prova</b>
	<input type="checkbox" name="manage_answer" checked>
</p>
<p class="bootstrapSwitch">
    <b>Gerar Folha de<br>Gabarito do Aluno</b>
	<input type="checkbox" name="manage_template" checked>
</p>

<div id="lce">
</div>

<style>
	.accordion-group{
		display:inline;
	}
	.form-control{
		padding:5px;
	}
</style>

<script>
	function print_gabarito(){
		w=window.open();
		w.document.write("<link href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css\" rel='stylesheet' type='text/css'><link href=\"https://fonts.googleapis.com/css?family=Lato:100,300,400,700\" rel='stylesheet' type='text/css'><link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css\" integrity=\"sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd\" crossorigin=\"anonymous\"><link rel=\"stylesheet\" href=\"{{url('/assets/bootstrap-switch-master/dist/css/bootstrap3/bootstrap-switch.min.css')}}\">");
		w.document.write(""+$('iframe').contents().find("#gabarito_professor").html());
	}

	function generateDoc(){
		var form = new FormData();
		form.append('_token','{{ csrf_token() }}');
		form.append('html',$('iframe').contents().find('html').html());
		form.append('css',$('#lce').livecsseditor('getCss'));
		$.ajax({
			url: '{{ url("/home/upload/html") }}',
			data: form,
			processData: false,
			contentType: false,
			type: 'POST',
			cache: false,
			success: function (data) {
				console.log(data);
			}
		});
	}

	$(function(){
		$("[name='manage_answer']").bootstrapSwitch({size: 'mini', onSwitchChange:function(){
			if (this.checked){
				$('*[checkedtrue=true]', $('iframe').contents()).prop('checked', true);
			} else {
				$('*[checkedtrue=true]', $('iframe').contents()).prop('checked', false);
			}
		}});
		$("[name='manage_template']").bootstrapSwitch({size: 'mini', onSwitchChange:function(){
			if (this.checked){
				$('#gabarito_aluno', $('iframe').contents()).css('display','block');
			} else {
				$('#gabarito_aluno', $('iframe').contents()).css('display','none');
			}
		}});
		$('#lce').livecsseditor({
			pages: {
				'{{Request::url()}}/data': {
					name: 'Prova Código {{$test->id}}',
					def: {
						'p.description':{
							name: 'Texto das Questões',
							props:['font-size','color', 'font-family', 'display', 'margin-bottom','margin-top', 'text-align']
						},
						'div.answer':{
							name: 'Respostas das Questões',
							props:['font-size','color','font-family', 'display', 'margin-bottom','margin-top']
						},
						'img':{
							name: 'Imagens',
							props:['width','display']
						},
						'p.img':{
							name: 'Alinhamento das Imagens',
							props:['text-align']
						},
						'div.question':{
							name: 'Quadro das Questões',
							props:['margin-bottom','margin-top']
						},
						'hr':{
							name: 'Distância das Linhas',
							props:['margin-bottom','margin-top']
						}
					}
				}
			}
		});
	});
</script>
@endsection
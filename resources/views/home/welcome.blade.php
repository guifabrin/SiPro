@extends('home')

@section('activeItem') active @endsection

@section('header')
	SiPRO - Sistema de Provas
@endsection

@section('body')
<div class="row welcome">
	<div class="col-xs-12 col-sm-12 col-md-6 notebook">
		<div>
			<center>
				<h3>Bem vindo!</h3>
				<img src="{{ asset('/assets/images/logo.png') }}">
			</center>
			<hr>
			<p>
				No princípio, havia apenas o lápis e o papel, então foi dito: "que haja o mimeógrafo" então o mimeógrafo se fez!
			</p>	
			<p>
				Esqueça as 172 horas editando um arquivo do Microsoft Word ou Libre Office.
			</p>
			<p>
				Cadastre questões e gere provas em menos tempo!
			</p>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-6">
		<div class="fb-page" data-href="https://www.facebook.com/sistemadeprovas" data-tabs="timeline" data-width="500" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/sistemadeprovas" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/sistemadeprovas">SiPro - Sistema de Provas</a></blockquote></div>
		<div id="fb-root"></div>
		<script>
		(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.7&appId=268860216798505";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		</script>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12">
		<p>
			O sistema é parte constituinte do Trabalho de Conclusão de Curso (TCC) de Ciência da Computação do aluno Guilherme Fabrin Franco (RG 715656), orientado pelo professor Mestre Romário Lopes Alcântara ambos constituintes da Universidade Regional do Noroeste do Estado do Rio Grande do Sul (UNIJUI).
		
		</p>
		<p>
			Por conseguinte, objetiva melhorar o uso do tempo de um professor na criação, execução e correção de provas.
		</p>
		<p>
			<center>
				<a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/"><img alt="Licença Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png" /></a><br />O trabalho <span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">SiPRO</span> de <a xmlns:cc="http://creativecommons.org/ns#" href="http://sipro.ijuhy.com.br/" property="cc:attributionName" rel="cc:attributionURL">Sistema de Provas</a> está licenciado com uma Licença <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/">Creative Commons - Atribuição-NãoComercial-SemDerivações 4.0 Internacional</a>.
			</center>
		</p>
		<p>
			<font color="orange">PS. O sistema está em desenvolvimento contínuo. Logo é possível que haja erros dentro do mesmo. Você pode contribuir para que a correção seja feita enviando uma foto ou um <i>printscreen</i> da tela para o e-mail <a href="mailto:guilherme.fabrin@gmail.com">guilherme.fabrin@gmail.com</a>.</font>
		</p>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12">
		<hr>
		<p>
			Com gratidão pelo conhecimento,<br>
			Guilherme Fabrin Franco
		</p>
	</div>
</div>
@endsection
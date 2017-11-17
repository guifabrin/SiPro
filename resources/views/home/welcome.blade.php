@extends('home')

@section('header')
@endsection

@section('body')
<div class="row welcome">
	<div class="col-xs-12 col-sm-12 col-md-6 notebook">
		<div>
			<center>
				<h3>{{ __('lang.welcome') }}</h3>
				<img src="{{ asset('/assets/images/logo.png') }}">
			</center>
			<hr>
			<p>
				{!! __('lang.welcome_message') !!}
			</p>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-6">
		<div class="fb-page" data-href="{{ __('lang.facebook') }}" data-tabs="timeline" data-width="500" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/sistemadeprovas" class="fb-xfbml-parse-ignore"><a href="{{ __('lang.facebook') }}">{{ __('lang.title') }}</a></blockquote></div>
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
			{!! __('lang.system_description') !!}
		</p>
		<p>
			<center>
				<a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/"><img alt="Licença Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png" /></a></br><a xmlns:cc="http://creativecommons.org/ns#" href="{{ url('/') }}" property="cc:attributionName" rel="cc:attributionURL"> {{ __('lang.title') }}</a> {!! __('lang.license') !!} </a>.
			</center>
		</p>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12">
		<hr>
		<p>
			{{ __('lang.thanks') }}<br>
			Guilherme Fabrin Franco
		</p>
	</div>
</div>
@endsection
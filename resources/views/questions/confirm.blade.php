@extends('home')

@section('btn-left')
	<a class="btn btn-primary" href="{{ url('questions') }}">
		<i class="fa fa-btn fa-arrow-circle-left"></i> {{ __('lang.back') }}
	</a>
@endsection

@section('header')
	{{ __('lang.confirm_remove') }} {{ __('lang.question') }}
@endsection

@section('body')
	{!! Form::open( array('url' => '/questions/'.$question->id, 'method' => 'DELETE' ) ) !!}
		<div class="alert alert-warning">
			{{ __('lang.remove_question_message') }} '{{$question->description}}'?
		</div>

		<p class="yes-no-buttons">
			<button type="submit" class="btn btn-info">
			    <i class="fa fa-thumbs-up"></i> {{ __('lang.yes') }}
			</button>
			<a class="btn   btn-info" href="{{ url('questions') }}">
			    <i class="fa fa-thumbs-down"></i> {{ __('lang.no') }}
			</a>
		</p>
	{!! Form::close() !!}
@endsection
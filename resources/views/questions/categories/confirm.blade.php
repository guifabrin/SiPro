@extends('home')

@section('btn-left')
	<a class="btn   btn-primary" href="{{ url('/questions/categories/') }}">
		<i class="fa fa-arrow-circle-left"></i> {{ __('lang.back') }}
	</a>
@endsection

@section('header')
	{{ __('lang.confirm_remove') }} {{ __('lang.question_categorie') }} 
@endsection

@section('body')
	{!! Form::open( array('url' => '/questions/categories/'.$categorie->id, 'method' => 'DELETE' )) !!}

		<div class="alert alert-warning">
			{{ __('lang.remove_categorie_question_message') }} '{{$categorie->description}}'?
		</div>

		<p class="yes-no-buttons">
			<button type="submit" class="btn btn-info">
			    <i class="fa fa-thumbs-up"></i> {{ __('lang.yes') }}
			</button>
			<a class="btn   btn-info" href="{{ url('/question/categories') }}">
			    <i class="fa fa-thumbs-down"></i> {{ __('lang.no') }}
			</a>
		</p>

	{!! Form::close() !!}
@endsection
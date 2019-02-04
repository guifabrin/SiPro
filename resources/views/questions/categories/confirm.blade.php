@extends('home')

@section('btn-left')
	<a class="btn   btn-primary" href="{{ url('/questions/categories/') }}">
		<i class="fa fa-arrow-circle-left"></i> {{ _v('back') }}
	</a>
@endsection

@section('header')
	{{ _v('confirm_remove') }} {{ _v('question_categorie') }}
@endsection

@section('body')
	<form action="{{url('/questions/categories/'.$categorie->id) }}" method="DELETE">
		<div class="alert alert-warning">
			{{ _v('remove_categorie_question_message') }} '{{$categorie->description}}'?
		</div>

		<p class="yes-no-buttons">
			<button type="submit" class="btn btn-info">
			    <i class="fa fa-thumbs-up"></i> {{ _v('yes') }}
			</button>
			<a class="btn   btn-info" href="{{ url('/question/categories') }}">
			    <i class="fa fa-thumbs-down"></i> {{ _v('no') }}
			</a>
		</p>

	</form>
@endsection
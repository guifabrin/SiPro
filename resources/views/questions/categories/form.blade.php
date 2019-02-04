@extends('home')

@section('btn-left')
	<a class="btn btn-primary" href="{{ url('/questions/categories') }}">
		<i class="fa fa-arrow-circle-left"></i> {{ _v('back') }}
	</a>
@endsection

@section('header')
	{{ $title }} {{ _v('question_categorie') }}
@endsection

@section('body')
	<form action="{{url('/questions/categories'. (isset($categorie) ? '/'.$categorie->id : ''))}}"
		  method="<?php echo (isset($categorie)) ? 'PATCH' : 'POST'; ?>">
		{{ csrf_field() }}
		@php(Field::build("id", "text", (isset($categorie)) ? $categorie->id : null, false, true))
		<ul class="tree">
			<li>
				<input type="radio" name="father_id" style="margin-top: 11pt;" value="null"
					@if (!isset($categorie) || $categorie->father_id == null)
						checked
					@endif
				/> {{ _v('categorie.none') }}
			</li>
			@include('questions.categories.partials.view', [
				'select' => true,
				'radioKey' => 'father_id',
				'categories' => $categories,
				'selected' => isset($categorie) ? $categorie->father() : null
			])
		</ul>
		@php(Field::build("description", "text", (isset($categorie)) ? $categorie->description : null))
		@php(Submit::build("fa fa-floppy-o"))
	</form>
@endsection
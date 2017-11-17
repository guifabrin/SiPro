@extends('home')

@section('btn-left')
	<a class="btn btn-primary" href="{{ url('/') }}">
		<i class="fa fa-btn fa-arrow-circle-left"></i> {{ __('lang.back') }}
	</a>
@endsection

@section('header')
	{{ __('lang.my_account') }}
@endsection

@section('body')
	<ul class="list-group">
	    <li class="list-group-item">
	    	<a href="{{ url('/user/password') }}">
	    		<i class="fa fa-key fa-btn"></i> {{ __('lang.edit_password') }}
	    	</a>
		</li>
	</ul>
@endsection
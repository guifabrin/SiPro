<div class="avatar">
@if (Auth::user()->avatar!=null)
	<img src="{{ Auth::user()->avatar }}" alt="{{Auth::user()->name}}">
@else
	<img src="{{ url('/assets/images/no_image.png') }}" alt="{{Auth::user()->name}}">
@endif
</div>

<div class="name">
	{{ Auth::user()->name }}
</div>
    <?php
$rtUrl = Request::url();
?>
<ul class="menu">
	<li class="{{ $rtUrl == url('/') ? 'active' : '' }}">
		<a href="{{ url('/') }}">
			<i class="fa fa-home"></i>
			{{ __('lang.home') }}
		</a>
	</li>
	<?php
$url = "/questions/categories/";
?>
	<li class="{{ $rtUrl == url($url) ? 'active' : '' }}">
		<a href="{{ url($url) }}">
			<i class="fa fa-list"></i>
			{{ __('lang.question_categories') }}
		</a>
	</li>
	<?php
$url = "/questions/";
?>
	<li class="{{ $rtUrl == url($url) ? 'active' : '' }}">
		<a href="{{ url($url) }}">
			<i class="fa fa-question"></i>
			{{ __('lang.questions') }}
		</a>
	</li>
	<?php
$url = "/tests/categories/";
?>
	<li class="{{ $rtUrl == url($url) ? 'active' : '' }}">
		<a href="{{ url($url) }}">
			<i class="fa fa-list"></i>
			{{ __('lang.test_categories') }}
		</a>
	</li>
	<?php
$url = "/tests/";
?>
	<li class="{{ $rtUrl == url($url) ? 'active' : '' }}">
		<a href="{{ url($url) }}">
			<i class="fa fa-file-text"></i>
			{{ __('lang.tests') }}
		</a>
	</li>
	<?php
$url = "/user/";
?>
	<li class="{{ $rtUrl == url($url) ? 'active' : '' }}">
		<a href="{{ url($url) }}">
			<i class="fa fa-user"></i>
			{{ __('lang.my_account') }}
		</a>
	</li>
</ul>
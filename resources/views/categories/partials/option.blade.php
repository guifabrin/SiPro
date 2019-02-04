@foreach ($categories as $c)
	@if ($c->id!=$id)
		<option value="{{ $c->id }}" {{ (isset($fatherId) && $fatherId == $c->id)? 'selected': '' }}>
			{{ str_repeat('&nbsp;&nbsp;', $nivel) }}
			{{ $c->id }} - {{ $c->description }}
		</option>
		@if(count($c->childrens) != 0)
			@include('categories.partials.option', ['categories' => $c->childrens]);
		@endif
	@endif
@endforeach
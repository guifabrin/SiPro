@foreach ($categories as $c)
	<option value="{{ $c->id }}" {{ (isset($id) && $id == $c->id) ? 'selected' : '' }}>
		{{ str_repeat('&nbsp;&nbsp;', $nivel) }}
		{{ $c->id }} - {{ $c->description }}
	</option>
	@if(count($c->childrens) != 0)
		@include('tests.categories.partials.option', ['categories' => $c->childrens, 'nivel' => $nivel+1, 'id' => $id, 'fatherId' => $c->id])
	@endif
@endforeach
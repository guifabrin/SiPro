@foreach ($categories as $categorie)
	<li class="list-group-item" style="padding-left:{{ $nivel*20 }}px;">
		{{ $categorie->id }} - {{ $categorie->description }}
		<a class="btn btn-danger" href="{{ url('/questions/categories/confirm/'.$categorie->id) }}"> <i class='fa fa-times'></i> Excluir</a>
		<a class="btn btn-warning" href="{{ url('/questions/categories/'.$categorie->id) }}"> <i class='fa fa-pencil'></i> Alterar</a>
	</li>
	@if(count($categorie->childrens) != 0)
		@include('questions.categories.partials.view', ['categories' => $categorie->childrens, 'nivel' => $nivel+1])
	@endif
@endforeach
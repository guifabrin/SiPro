@foreach ($categories as $categorie)
	<li class="list-group-item" style="padding-left:{{ $nivel*20 }}px;">
		{{ $categorie->id }} - {{ $categorie->description }}
		@if ($categorieManage)
			<a class="btn btn-danger" href="{{ url('/tests/categories/confirm/'.$categorie->id) }}"> <i class='fa fa-times'></i> Excluir</a>
			<a class="btn btn-warning" href="{{ url('/tests/categories/'.$categorie->id) }}"> <i class='fa fa-pencil'></i> Alterar</a>
		@else
			<a class="btn btn-success" href="{{ url('/tests/categorie/'.$categorie->id) }}"> <i class='fa fa-eye'></i> Ver questões</a>
			<a class="btn btn-success-outline" href="{{ url('/tests/categorie/'.$categorie->id.'/create') }}"> <i class='fa fa-plus'></i> Adicionar teste</a>
		@endif
	</li>
	@if(count($categorie->childrens) != 0)
		@include('tests.categories.partials.view', ['categories' => $categorie->childrens, 'nivel' => $nivel+1, 'categorieManage' => $categorieManage])
	@endif
@endforeach
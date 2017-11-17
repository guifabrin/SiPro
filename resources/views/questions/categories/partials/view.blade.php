@foreach ($categories as $categorie)
	<li class="list-group-item" style="padding-left:{{ $nivel*20 }}px;">
		<div class="col-8">
			{{ $categorie->id }} - {{ $categorie->description }}
		</div>
		<div class="col-4">
			@if ($categorieManage)
				<a class="btn btn-danger" href="{{ url('/questions/categories/confirm/'.$categorie->id) }}">
					<i class='fa fa-times'></i> {{ __('lang.remove') }}
				</a>
				<a class="btn btn-warning" href="{{ url('/questions/categories/'.$categorie->id) }}">
					<i class='fa fa-pencil'></i> {{ __('lang.edit') }}
				</a>
			@else
				<a class="btn btn-info" href="{{ url('/questions/categorie/'.$categorie->id) }}">
					<i class='fa fa-eye'></i> {{ __('lang.see') }}
				</a>
				<a class="btn btn-success" href="{{ url('/questions/categorie/'.$categorie->id.'/create') }}">
					<i class='fa fa-plus'></i> {{ __('lang.add') }}
				</a>
			@endif
		</div>
	</li>
	@if(count($categorie->childrens) != 0)
		@include('questions.categories.partials.view', ['categories' => $categorie->childrens, 'nivel' => $nivel+1, 'categorieManage' => $categorieManage])
	@endif
@endforeach
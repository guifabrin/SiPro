@php($select = isset($select) ? $select : false)
@php($selected = isset($selected) ? $selected : null)
@php($manage = isset($manage) ? $manage : false)

@foreach ($categories as $categorie)
    @if ($select && isset($selected) && $categorie->father_id==$selected->id)
        @continue
    @endif
	<li>
        @if ($select)
            <input type="radio" name="{{$radioKey}}" style="margin-top: 11pt" value="{{$categorie->id}}"
                @if (isset($selected) && $categorie->id == $selected->id)
                    checked
                @endif
            />
            {{ $categorie->description }}
        @else
            <button class="btn btn-sm {{ isset($selected) && $selected->id == $categorie->id ? 'btn-primary' : 'btn-secondary' }} dropdown-toggle" id="siproDrodownMenu{{$categorie->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-folder-open"></i>
                {{ $categorie->description }}
                <span class="badge badge-light">{{ $categorie->tests()->count() }}</span>
            </button>
            <div class="dropdown-menu" aria-labelledby="siproDrodownMenu{{$categorie->id}}">
                <a class="dropdown-item" href="{{ url('/tests/categorie/'.$categorie->id) }}">
                    <i class='fa fa-eye'></i> {{ _v('see') }}
                </a>
                <a class="dropdown-item" href="{{ url('/tests/categorie/'.$categorie->id.'/create') }}">
                    <i class='fa fa-plus'></i> {{ _v('add') }}
                </a>
                @if ($manage)
                    <a class="dropdown-item" href="{{ url('/tests/categories/confirm/'.$categorie->id) }}">
                        <i class='fa fa-times'></i> {{ _v('remove') }}
                    </a>
                    <a class="dropdown-item" href="{{ url('/tests/categories/'.$categorie->id) }}">
                        <i class='fa fa-pencil'></i> {{ _v('edit') }}
                    </a>
                @endif
            </div>
        @endif
        @if(count($categorie->childrens) != 0)
            <ul>
                @include('tests.categories.partials.view', ['selected' => $selected, 'select' => $select, 'categories' => $categorie->childrens,
                 'manage' => $manage])
            </ul>
        @endif
	</li>
@endforeach
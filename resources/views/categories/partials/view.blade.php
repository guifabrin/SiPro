@php($select = isset($select) ? $select : false)
@php($category = isset($category) ? $category : null)
@php($manage = isset($manage) ? $manage : false)
@foreach ($categories as $categoryL)
    @if ($select && isset($category) && $categoryL->id==$category->id)
        @continue
    @endif
	<li>
        @if ($select)
            <input type="radio" name="{{$radioKey}}" style="margin-top: 11pt" value="{{$categoryL->id}}"
                @if (isset($category) && $categoryL->id == $category->father_id)
                    checked
                @endif
            />
            {{ $categoryL->description }}
        @else
            <button class="btn btn-sm {{ isset($category) && $category->id == $categoryL->id ? "btn-primary" : "btn-secondary" }} dropdown-toggle" id="siproDrodownMenu{{$categoryL->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-folder-open"></i>
                {{ $categoryL->description }}
                <span class="badge badge-light">{{ $categoryL->itens()->count() }}</span>
            </button>
            <div class="dropdown-menu" aria-labelledby="siproDrodownMenu{{$categoryL->id}}">
                <a class="dropdown-item" href="{{ url("/".$type."s/itens/".$categoryL->id) }}">
                    <i class="fa fa-eye"></i> {{ _v("see") }}
                </a>
                <a class="dropdown-item" href="{{ url("/".$type."s/itens/".$categoryL->id."/create") }}">
                    <i class="fa fa-plus"></i> {{ _v("add") }}
                </a>
                @if ($manage)
                    <a class="dropdown-item" href="{{ url("/".$type."Category/".$categoryL->id) }}">
                        <i class="fa fa-times"></i> {{ _v("remove") }}
                    </a>
                    <a class="dropdown-item" href="{{ url("/".$type."Category/".$categoryL->id."/edit") }}">
                        <i class="fa fa-pencil"></i> {{ _v("edit") }}
                    </a>
                @endif
            </div>
        @endif
        @if($categoryL->children()->count()>0)
            <ul>
                @include("categories.partials.view", [
                "selected" => $category,
                "select" => $select,
                 "categories" => $categoryL->children()->notRemoved()->get(),
                 "manage" => $manage
                 ])
            </ul>
        @endif
	</li>
@endforeach
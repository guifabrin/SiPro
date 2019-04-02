<button class="btn btn-sm {{ isset($category) && $category->id == $actual->id ? "btn-primary" : "btn-secondary" }} dropdown-toggle"
        id="siproDrodownMenu{{$actual->id}}" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
    <i class="fa fa-folder-open"></i>
    {{ $actual->description }}
    <span class="badge badge-light">{{ $actual->itens()->notRemoved()->count() }}</span>
</button>
<div class="dropdown-menu" aria-labelledby="siproDrodownMenu{{$actual->id}}">
    <a class="dropdown-item" href="{{ url("/".$type."s/itens/".$actual->id) }}">
        <i class="fa fa-eye"></i> {{ _v("see") }}
    </a>
    <a class="dropdown-item" href="{{ url("/".$type."s/itens/".$actual->id."/create") }}">
        <i class="fa fa-plus"></i> {{ _v("add") }}
    </a>
    @if ($manage)
        <a class="dropdown-item" href="{{ url("/".$type."Category/".$actual->id) }}">
            <i class="fa fa-times"></i> {{ _v("remove") }}
        </a>
        <a class="dropdown-item" href="{{ url("/".$type."Category/".$actual->id."/edit") }}">
            <i class="fa fa-pencil-alt"></i> {{ _v("edit") }}
        </a>
    @endif
</div>
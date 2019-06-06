<button class="btn btn-sm {{ isset($category) && $category->id == $actual->id ? "btn-primary" : "btn-secondary" }} dropdown-toggle"
        id="siproDrodownMenu{{$actual->id}}" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
    <i class="fa fa-folder-open"></i>
    {{ $actual->description }}
    <span class="badge badge-light">{{ $actual->itens()->notRemoved()->count() }}</span>
</button>
<div class="dropdown-menu" aria-labelledby="siproDrodownMenu{{$actual->id}}">
    <a class="dropdown-item" href="{{ url("/".$type."s/itens/".$actual->id) }}">
        <i class="fa fa-eye"></i> {{ __("lang.see") }}
    </a>
    <a class="dropdown-item" href="{{ url("/".$type."s/itens/".$actual->id."/create") }}">
        <i class="fa fa-plus"></i> {{ __("lang.add") }}
    </a>
    @if ($manage)
        <a class="dropdown-item" href="{{ url("/".$type."Category/".$actual->id) }}">
            <i class="fa fa-times"></i> {{ __("lang.remove") }}
        </a>
        <a class="dropdown-item" href="{{ url("/".$type."Category/".$actual->id."/edit") }}">
            <i class="fa fa-pencil-alt"></i> {{ __("lang.edit") }}
        </a>
    @endif
</div>
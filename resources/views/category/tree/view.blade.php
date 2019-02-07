@php($category = isset($category) ? $category : null)
@php($manage = isset($manage) ? $manage : true)
@php($first = $categories->count()>0 && $categories[0]->father_id == null)
@if ($first)
    <ul class="tree">
        <li>
            @php($selected = !isset($category) ? "btn-primary" : "btn-secondary")
            <button class="btn btn-sm {{ $selected }} dropdown-toggle"
                    id="siproDrodownMenuNull" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                <i class="fa fa-folder-open"></i>
                {{ _v('none') }}
                <span class="badge badge-light">
                    @php($userCategories = Auth::user()->categoryOf($type)->notRemoved())
                    {{ (isset($category) ? $categories->fromCategory($category) : $userCategories->withoutCategory())->count() }}
                </span>
            </button>
            <div class="dropdown-menu" aria-labelledby="siproDrodownMenuNull">
                <a class="dropdown-item" href="{{ url("/".$type."s/itensWithoutCategory") }}">
                    <i class="fa fa-eye"></i> {{ _v("see") }}
                </a>
                <a class="dropdown-item" href="{{ url("/".$type."/create") }}">
                    <i class="fa fa-plus"></i> {{ _v("add") }}
                </a>
            </div>
        </li>
        @endif
        @foreach ($categories as $actual)
            <li>
                @include('category.tree.partials.button', [
                'type' => $type,
                'manage' => $manage,
                'actual' => $actual,
                'category' => $category,
                ])
                @php($childrens = $actual->children()->notRemoved())
                @if($childrens->count()>0)
                    <ul>
                        @include("category.tree.view", [
                        "type" => $type,
                        "manage" => $manage,
                        "category" => $category,
                        "categories" => $childrens->get()
                        ])
                    </ul>
                @endif
            </li>
        @endforeach
        @if ($first) </ul> @endif
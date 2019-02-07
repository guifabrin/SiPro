@php($first = $categories->count()==0 || $categories[0]->father_id == null)
@if ($first)
    <ul class="tree">
        <li>
            <input type="radio" name="{{$key}}" style="margin-top: 11pt" value="null"
                   @if (isset($category))
                   @if ($father && $category->father_id == null) checked @endif
                   @if (!$father && $category->id == null) checked @endif
                   @else checked
                    @endif
            />
            {{ _v('none') }}
        </li>
        @endif
        @foreach ($categories as $actual)
            <li>
                @include('category.tree.partials.radio', [
                'key' => $key,
                'type' => $type,
                'actual' => $actual,
                'father' => $father,
                'category' => $category
                ])
                @php($childrens = $actual->children()->notRemoved())
                @if($childrens->count()>0)
                    <ul>
                        @include("category.tree.select", [
                        "type" => $type,
                        'father' => $father,
                        "category" => $category,
                        "categories" => $childrens->get()
                        ])
                    </ul>
                @endif
            </li>
        @endforeach
        @if ($first) </ul> @endif
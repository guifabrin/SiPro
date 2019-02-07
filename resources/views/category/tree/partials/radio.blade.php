<input type="radio" name="{{$key}}" value="{{$actual->id}}"
       @if (isset($category))
       @if ($father && $actual->id == $category->father_id) checked @endif
       @if (!$father && $actual->id == $category->id) checked @endif
        @endif
/>
{{ $actual->description }}
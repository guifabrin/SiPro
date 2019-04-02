@php
    $action = _v($titleKey);
    if (!isset($questionCategory)) $questionCategory = isset($question) ? $question->category()->first() : null;
    if (isset($questionCategory)) $name = _v('in').' [ '.$questionCategory->description.' ]';
@endphp

@extends('layouts.app')

@section('btn-left')
    <a class="btn btn-primary" href="{{ url('question') }}">
        <i class="fa fa-btn fa-arrow-circle-left"></i> {{ _v('back') }}
    </a>
@endsection

@section('body')
    <form action="{{ url('/question/'.$question->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($question->id))
            @method("PUT")
        @endif
        @php(Field::build('id', 'text', isset($question) ? $question->id : null, false, true))
        <div class="form-group">
            <label for="category_id">{{ _v('category_id') }}:</label>
            @include('category.tree.select', [
                'father' => false,
                'type'=> 'question',
                'key' => 'category_id',
                'category' => $questionCategory,
                'categories' => $questionCategories
            ])
        </div>
        @php(Field::build('description', 'textarea', isset($question) ? $question->description : null))
        @if(isset($question))
            @php(Field::build('image_id', 'hidden', isset($question) && isset($question->image) && isset($question->image->id) ? $question->image->id : null))
        @endif
        @php(Field::build('image', 'image', isset($question) && isset($question->image) && isset($question->image->imageb64_thumb) ? $question->image->imageb64_thumb : null))
        @php(Field::build('type', 'select', isset($question) ? $question->type : 0,  true, false, [
         0 => _v('descriptive'), 1 => _v('optative'), 2 => _v('true_false')	]))
        @php(Field::build('lines', 'number', isset($question) ? $question->lines : -1))

        <div class="form-group" id="options" style="display: none;">
            <label>{{ _v('options') }}:</label>
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th>{{ _v('right') }}</th>
                    <th>{{ _v('image') }}</th>
                    <th>{{ _v('description') }}</th>
                </tr>
                </thead>
                <tbody>
                @php($options = $question->options()->get())
                @for ($i=0; $i<5; $i++)
                    @php
                        $settedOptionImage = isset($options[$i]) &&
                                                isset($options[$i]->image) &&
                                                isset($options[$i]->image->imageb64_thumb);
                    @endphp
                    <tr>
                        <td>
                            @php(Field::build("option-id[".$i."]", "hidden"))
                            @php
                                Field::build("option-correct[]", "checkbox", $i, false, false,
                                    isset($options) && isset($options[$i]) && $options[$i]->correct);
                            @endphp
                        </td>
                        <td>
                            @php
                                Field::build("option-image[". $i ."]", "image",
                                    $settedOptionImage ? $options[$i]->thumbImage() : null)
                            @endphp
                        </td>
                        <td>
                            @php
                                Field::build("option-description[". $i ."]", "textarea",
                                    isset($options) && isset($options[$i]) ? $options[$i]->description : "")
                             @endphp
                        </td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
        @php(Submit::build('fa fa-save'))
        <script type="text/javascript" src="{{ URL::asset('js/questions/form.js') }}"></script>
    </form>
@endsection
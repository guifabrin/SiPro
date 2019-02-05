@extends('layouts.iframe')
@section('content')
    <h3>{{_v('questions')}}</h3>
    <label for="categorie_id">{{ _v('categorie_id') }}:</label>
    @include('categories.tree.select', [
        'father' => false,
        'type'=> 'question',
        'key' => 'categorie_id',
        'category' => isset($questionCategory) ? $questionCategory : null,
        'categories' => $questionCategories
    ])
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
        <tr>
            <th style="width: 100pt;">{{ _v('image') }}</th>
            <th>{{ _v('description') }}</th>
            <th style="width: 100pt;">{{ _v('actions') }}</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $buttonAddHtml = "<i class='fa fa-plus'></i>"._v('add');
        $buttonRemoveHtml = "<i class='fa fa-close'></i>"._v('remove');
        ?>
        @foreach ($questions as $question)
        <tr>
            <td>
                @if (isset($question->image))
                    <img src="{{ $question->image->imageb64_thumb }}" class="sipro-image-file-select"
                         alt="{{ $question->description }}"/>
                @endif
            </td>
            <td>{{ $question->description }}</td>
            <td>
                @php($inTest = $question->inTest($test))
                @php(\App\Helpers\Boostrap\LinkButton::build('remove',
                url('/questions_in_tests/'.$test->id .'/'.$question->id .'/destroy'), 'fa fa-close', 'btn-danger testControl '.($inTest?'':'hide')) )
                @php(\App\Helpers\Boostrap\LinkButton::build('add',
                url('/questions_in_tests/'.$test->id .'/'.$question->id .'/store'), 'fa fa-plus', 'btn-success testControl '.($inTest?'hide':'')) )
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <script>
        var baseUrl = "{{url("/tests/".$test->id."/questions")}}/";
    </script>
    <script type="text/javascript" src="{{ URL::asset('js/questions_in_tests/form.js') }}"></script>
@endsection
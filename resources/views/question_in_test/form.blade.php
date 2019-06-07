@extends('layouts.iframe')
@section('content')
    <h3>{{ __('lang.questions.name') }}</h3>
    <label for="category_id">{{ __('lang.questions.form.category_id') }}:</label>
    @include('category.tree.select', [
        'father' => false,
        'type'=> 'question',
        'key' => 'category_id',
        'category' => isset($questionCategory) ? $questionCategory : null,
        'categories' => $questionCategories
    ])
    <table class="{{config('constants.classes.table')}}">
        <thead class="{{config('constants.classes.thead')}}">
        <tr>
            <th>{{ __('lang.image') }}</th>
            <th>{{ __('lang.description') }}</th>
            <th>{{ __('lang.actions') }}</th>
        </tr>
        </thead>
        <tbody>
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
                <a class="{{config('constants.classes.buttons.add')}} testControl {{$inTest?'hide':''}}"
                    href="{{ url('/questions_in_tests/'.$test->id .'/'.$question->id .'/store') }}">
                    <i class='{{config('constants.classes.icons.add')}}'></i> {{ __('lang.add') }}
                </a>
                <a class="{{config('constants.classes.buttons.remove')}} testControl {{$inTest?'':'hide'}}"
                    href="{{ url('/questions_in_tests/'.$test->id .'/'.$question->id .'/destroy') }}">
                    <i class='{{config('constants.classes.icons.remove')}}'></i> {{ __('lang.remove') }}
                </a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <script>
        var baseUrl = "{{url("/tests/".$test->id."/questions")}}/";
    </script>
    <script type="text/javascript" src="{{ url('js/questions_in_tests/form.js') }}"></script>
@endsection
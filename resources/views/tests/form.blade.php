@extends('home')

@section('tests_active') active @endsection

@section('btn-left')
    <a class="btn   btn-primary" href="{{ url('tests') }}">
        <i class="fa fa-arrow-circle-left"></i> {{ __('lang.back') }}
    </a>
@endsection

@section('header')
    {{ $title }} {{ __('lang.test') }}
@endsection

@section('body')
    {!! Form::open( array('url' => '/tests'. (isset($test) ? '/'.$test->id : '') , 'method' =>  (isset($test)) ? 'PATCH' : 'POST', 'enctype' => 'multipart/form-data') ) !!}

    <fieldset class="form-group">
        <label class="col-md-2 control-label">{{ __('lang.code') }}: {{ __('lang.test') }}</label>
        <div class="col-md-10">
            <input type="text" class="form-control" readonly="true" value="{{ (isset($test)) ? $test->id : null }}">
        </div>
    </fieldset>

    <fieldset class="form-group">
        <label class="col-md-2 control-label">{{ __('lang.test_categorie') }}:</label>
        <div class="col-md-10">
            @if (count($categories) == 0)
                <input type="hidden" name="categorie_id" value="null"/>
                <div class="alert alert-warning">{{ __('lang.no_one_categorie') }}</div>
            @else
                <select class="form-control" name="categorie_id">
                    <option value="null" {{ ($categorie==null)?'checked':'' }}>{{ __('lang.no_one') }}</option>
                    @include('tests.categories.partials.option', ['id' => ($categorie==null) ? null : $categorie->id, 'fatherId' => null, 'categories' => $categories, 'nivel' => 0 ])
                </select>
            @endif
        </div>
    </fieldset>

    <fieldset class="form-group">
        <label class="col-md-2 control-label">{{ __('lang.description') }}:</label>
        <div class="col-md-10">
            <textarea class='form-control' name="description">@if(isset($test)){{$test->description}}@endif</textarea>
        </div>
    </fieldset>

    <fieldset class="form-group">
        <div class="col-md-12">
            <button type="submit" class="btn   btn-success">
                <i class="fa fa-floppy-o"></i> Salvar
            </button>
        </div>
    </fieldset>
    {!! Form::close() !!}
    @if (isset($test))
        <ul class="list-group">
            @include('questions.categories.partials.view', ['categories' => $questionCategories, 'nivel' => 1, 'categorieManage' => false])
        </ul>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>{{ __('lang.code') }}</th>
                <th>Imagem</th>
                <th>{{ __('lang.description') }}</th>
                <th>{{ __('lang.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $buttonAddHtml = "<i class='fa fa-plus'></i> {{ __('lang.add') }}";
            $buttonRemoveHtml = "<i class='fa fa-close'></i> Remover";
            ?>
            @foreach ($questions as $question)
                <tr>
                    <td>{{ $question->id }}</td>
                    <td>
                        @if (isset($question->image))
                            <img src="{{ $question->image->imageb64_thumb }}" class="sipro-image-file-select" alt="{{ $question->description }}"/>
                        @endif
                    </td>
                    <td>{{ $question->description }}</td>
                    <td>
                        @if ($question->inTest)
                            <button type="button" class="btn btn-danger"
                                    onclick="post('{{ url('/questions_in_tests/destroy/') }}', {{ $test->id }}, {{ $question->id }}, this, 0);">
                                {!! $buttonRemoveHtml !!}
                                @else
                                    <button type="button" class="btn btn-success"
                                            onclick="post('{{ url('/questions_in_tests/store/') }}', {{ $test->id }}, {{ $question->id }}, this, 1);">
                                        {!! $buttonAddHtml !!}
                                    </button>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="4">
                    {{ $questions->links() }}
                </td>
            </tr>
            </tfoot>
        </table>
        <script>
            function post(url, idTest, idQuestion, btn, act) {
                $.post(url,
                    {
                        '_token': $('meta[name=csrf-token]').attr('content'),
                        test_id: idTest,
                        question_id: idQuestion
                    })
                    .error(
                        function () {
                            console.log('err');
                        }
                    )
                    .success(
                        function () {
                            var button = $(btn);
                            if (act == 1) {
                                button.removeClass('btn-success');
                                button.addClass('btn-danger');
                                button.attr("onclick", "post('{{ url('/questions_in_tests/destroy/') }}', " + idTest + ", " + idQuestion + ", this, 0);");
                                button.html("{!! $buttonRemoveHtml !!}");
                            } else {
                                button.removeClass('btn-danger');
                                button.addClass('btn-success');
                                button.attr("onclick", "post('{{ url('/questions_in_tests/store/') }}', " + idTest + ", " + idQuestion + ", this, 1);");
                                button.html("{!! $buttonAddHtml !!}");
                            }
                        }
                    );
            }
        </script>
    @endif
@endsection
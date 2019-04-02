@php
    $action = _v('mines_gender_a');
    $name = isset($questionCategory) ? '[ '.$questionCategory->description.' ]' : '';
@endphp

@extends('layouts.app')

@section('btn-left')
    <a class="btn   btn-primary" href="{{ url('question') }}">
        <i class="fa fa-btn fa-arrow-circle-left"></i> {{ _v('back') }}
    </a>
@endsection

@section('btn-right')
    @php( $url = isset($questionCategory) ? '/questions/itens/'.$questionCategory->id.'/create' : '/question/create')
    <a class="btn btn-success"
       href="{{ url($url) }}">
        <i class="fa fa-plus"></i> {{ _v('add') }}
    </a>
@endsection

@section('body')
    @include('category.tree.view', [
        'manage' => false,
        'type'=>'question',
        'category'=> $questionCategory,
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
        @foreach ($questions as $question)
            <tr>
                <td>
                    <img src="{{ $question->thumbImage() }}" class="sipro-image-file-select"
                         onerror="this.style.display='none'" alt="{{ $question->description }}"/>
                </td>
                <td>{{ $question->description }}</td>
                <td>
                    <a class="btn btn-danger w-100" href="{{ url('/question/'.$question->id) }}">
                        <i class='fa fa-times'></i> {{ _v('remove') }}
                    </a>
                    <hr>
                    <a class="btn btn-warning w-100" href="{{ url('/question/'.$question->id."/edit") }}">
                        <i class='fa fa-pencil-alt'></i> {{ _v('edit') }}
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{--    {{ $questions->links() }}--}}
@endsection
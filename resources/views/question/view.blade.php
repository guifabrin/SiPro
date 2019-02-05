@extends('home')

@section('btn-left')
    <a class="btn   btn-primary" href="{{ url('question') }}">
        <i class="fa fa-btn fa-arrow-circle-left"></i> {{ _v('back') }}
    </a>
@endsection

@section('btn-right')
    @php( $url = isset($questionCategory) ? '/questions/itens/'.$questionCategory->id.'/create' : '/question/create')
    <a class="btn btn-success"
       href="{{ $url }}">
        <i class="fa fa-plus"></i> {{ _v('add') }}
    </a>
@endsection

@section('body')
    <h3>{{ _v('mines_gender_a') }} {{ _v('questions') }} {{ isset($categorie) ? '[ '.$categorie->description.' ]' : ''}}</h3>
    @include('categories.tree.view', [
        'manage' => false,
        'type'=>'question',
        'category'=> $questionCategory,
        'categories' => $questionCategories
    ])
    <table class="table">
        <thead>
        <tr>
            <th>{{ _v('code') }}</th>
            <th>{{ _v('image') }}</th>
            <th>{{ _v('description') }}</th>
            <th>{{ _v('actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($questions as $question)
            <tr>
                <td>{{ $question->id }}</td>
                <td>
                    <img src="{{ $question->thumbImage() }}" onerror="this.style.display='none'"
                         style="max-width:100px; max-height:100px;" alt="{{ $question->description }}"/>
                </td>
                <td>{{ $question->description }}</td>
                <td style="width: 250px;">
                    <a class="btn btn-danger" href="{{ url('/question/'.$question->id) }}">
                        <i class='fa fa-times'></i> {{ _v('remove') }}
                    </a>
                    <a class="btn btn-warning" href="{{ url('/question/'.$question->id."/edit") }}">
                        <i class='fa fa-pencil'></i> {{ _v('edit') }}
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{--    {{ $questions->links() }}--}}
@endsection
@extends('home')


@section('btn-left')
    <a class="btn   btn-primary" href="{{ url('test') }}">
        <i class="fa fa-btn fa-arrow-circle-left"></i> {{ _v('back') }}
    </a>
@endsection

@section('btn-right')
    @php( $url = isset($testCategory) ? '/tests/itens/'.$testCategory->id.'/create' : '/test/create')
    <a class="btn btn-success"
       href="{{ $url }}">
        <i class="fa fa-plus"></i> {{ _v('add') }}
    </a>
@endsection

@section('body')
    <h3>{{ _v('mines_gender_b') }} {{ _v('tests') }} {{ isset($testCategory) ? '[ '.$testCategory->description.' ]' : ''}}</h3>
    @include('categories.tree.view', [
        'manage' => false,
        'type'=>'test',
        'category'=> $testCategory,
        'categories' => $testCategories
    ])
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
        <tr>
            <th>{{ _v('description') }}</th>
            <th style="width: 100pt;">{{ _v('actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($tests as $test)
            <tr>
                <td>{{ $test->description }}</td>
                <td>
                    <a class="btn btn-danger w-100" href="{{ url('/test/'.$test->id) }}">
                        <i class='fa fa-times'></i> {{ _v('remove') }}
                    </a>
                    <hr>
                    <a class="btn btn-warning w-100" href="{{ url('/test/'.$test->id."/edit") }}">
                        <i class='fa fa-pencil'></i> {{ _v('edit') }}
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
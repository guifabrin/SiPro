@extends('home')

@section('btn-left')
    <a class="btn btn-primary" href="{{ url('tests') }}">
        <i class="fa fa-btn fa-arrow-circle-left"></i> {{ __('lang.back') }}
    </a>
@endsection

@section('header')
    {{ __('lang.mines_gender_b') }} {{ __('lang.tests') }} {{ isset($categorie) ? '[ '.$categorie->description.' ]' : ''}}
@endsection

@section('btn-right')
    <a class="btn   btn-success"
       href="{{ isset($categorie) ? url('tests/categorie/'.$categorie->id.'/create/') : url('tests/create/')  }}">
        <i class="fa fa-plus"></i> {{ __('lang.add') }}
    </a>
@endsection

@section('body')
    @if (!isset($categorie))
        <ul class="list-group">
            @include('tests.categories.partials.view', ['categories' => $categories, 'nivel' => 1, 'categorieManage' => false])
        </ul>
    @endif
    @if(isset($tests) && count($tests)>0)

        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>{{ __('lang.code') }}</th>
                <th>{{ __('lang.test_categorie') }}</th>
                <th>{{ __('lang.description') }}</th>
                <th>{{ __('lang.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($tests as $test)
                <tr>
                    <td>{{ $test->id }}</td>
                    <td><a href="{{ url('/tests/categorie/'.$test->categorie->id) }}">{{ $test->categorie->id }}
                            /{{ $test->categorie->description }}</a></td>
                    <td>{{ $test->description }}</td>
                    <td style="width: 250px;">
                        <a class="btn btn-danger" href="{{ url('/tests/confirm/'.$test->id) }}">
                            <i class='fa fa-times'></i> {{ __('lang.remove') }}
                        </a>
                        <a class="btn btn-warning" href="{{ url('/tests/'.$test->id) }}">
                            <i class='fa fa-pencil'></i> {{ __('lang.edit') }}
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
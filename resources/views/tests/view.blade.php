@extends('home')

@section('tests_active') active @endsection

@section('headerbtnl')
    <a class="btn btn-sm btn-primary" href="{{ url('tests') }}">
        <i class="fa fa-btn fa-arrow-circle-left"></i> Voltar
    </a>
@endsection

@section('header')
    Minhas Provas
@endsection

@section('headerbtnr')
    <a class="btn btn-sm btn-success-outline" href="{{ url('tests/create/') }}">
        <i class="fa fa-plus"></i> Adicionar
    </a>
@endsection

@section('body')
    @if (!isset($categorie))
        <ul class="list-group">
            @include('tests.categories.partials.view', ['categories' => $categories, 'nivel' => 1, 'categorieManage' => false])
        </ul>
    @endif
    @if(isset($tests) && count($tests)>0)

    <table class="table">
      <thead>
        <tr>
          <th>Código</th>
          <th>Descrição</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($tests as $test)
            <tr>
              <td>{{ $test->id }}</td>
              <td>{{ $test->description }}</td>
              <td>
                <a class="btn btn-danger" href="{{ url('/tests/confirm/'.$test->id) }}">
                    <i class='fa fa-times'></i> Excluir
                </a>
                <a class="btn btn-warning" href="{{ url('/tests/'.$test->id) }}">
                  <i class='fa fa-pencil'></i> Alterar
                </a>
              </td>
            </tr>
        @endforeach
      </tbody>
    </table>
    @endif
@endsection
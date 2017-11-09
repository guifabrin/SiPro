@extends('home')

@section('questions_active') active @endsection

@section('headerbtnl')
    <a class="btn btn-sm btn-primary" href="{{ url('questions') }}">
        <i class="fa fa-btn fa-arrow-circle-left"></i> Voltar
    </a>
@endsection

@section('header')
    Minhas Questões {{ isset($categorie) ? '[ Categoria: '.$categorie->description.' ]' : ''}}
@endsection

@section('headerbtnr')
    @if (isset($categorie))
        <a class="btn btn-sm btn-success-outline" href="{{ url('/questions/categorie/'.$categorie->id.'/create/') }}">
            <i class="fa fa-plus"></i> Adicionar
        </a>
    @else
        <a class="btn btn-sm btn-success-outline" href="{{ url('/questions/create/') }}">
            <i class="fa fa-plus"></i> Adicionar
        </a>
    @endif
@endsection

@section('body')
    @if (!isset($categorie))
        <ul class="list-group">
            @include('questions.categories.partials.view', ['categories' => $categories, 'nivel' => 1, 'categorieManage' => false])
        </ul>
    @endif
    <table class="table">
      <thead>
        <tr>
          <th>Código</th>
          <th>Imagem</th>
          <th>Descrição</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($questions as $question)
            <tr>
              <td>{{ $question->id }}</td>
              <td>
                @if (isset($question->image))
                  <img src="{{ $question->image->imageb64_thumb }}" style="max-width:100px; max-height:100px;"/>
                @endif
              </td>
              <td>{{ $question->description }}</td>
              <td>
                <a class="btn btn-danger" href="{{ url('/questions/confirm/'.$question->id) }}">
                    <i class='fa fa-times'></i> Excluir
                </a>
                <a class="btn btn-warning" href="{{ url('/questions/'.$question->id) }}">
                  <i class='fa fa-pencil'></i> Alterar
                </a>
              </td>
            </tr>
        @endforeach
      </tbody>
    </table>
@endsection
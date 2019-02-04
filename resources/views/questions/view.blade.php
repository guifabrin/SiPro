@extends('home')

@section('btn-left')
    <a class="btn   btn-primary" href="{{ url('questions') }}">
        <i class="fa fa-btn fa-arrow-circle-left"></i> {{ _v('back') }}
    </a>
@endsection

@section('header')
    {{ _v('mines_gender_a') }} {{ _v('questions') }} {{ isset($categorie) ? '[ '.$categorie->description.' ]' : ''}}
@endsection

@section('btn-right')
  <a class="btn btn-success" href="{{ isset($categorie) ? url('/questions/categorie/'.$categorie->id.'/create/'):url('/questions/create/')}}">
      <i class="fa fa-plus"></i> {{ _v('add') }}
  </a>
@endsection

@section('body')
    <ul class="tree">

        <li>
            <div class="dropdown">
                <button class="btn btn-sm btn-secondary dropdown-toggle" id="siproDrodownMenu0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-folder-open"></i>
                    {{ _v('categorie.none') }}
                    <span class="badge badge-light">{{ Auth::user()->questions()->withoutCategorie()->count() }}</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="siproDrodownMenu0">
                    <a class="dropdown-item" href="{{ url('/tests/categorie/null') }}">
                        <i class='fa fa-eye'></i> {{ _v('see') }}
                    </a>
                    <a class="dropdown-item" href="{{ url('/tests/categorie/null/create') }}">
                        <i class='fa fa-plus'></i> {{ _v('add') }}
                    </a>
                </div>
            </div>
        </li>
        @include('questions.categories.partials.view', ['categories' => $categories, 'selected'=>$categorie, 'manage' => false, 'select' => false])
    </ul>
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
                @if (isset($question->image))
                  <img src="{{ $question->image->imageb64_thumb }}" style="max-width:100px; max-height:100px;"/>
                @endif
              </td>
              <td>{{ $question->description }}</td>
              <td style="width: 250px;">
                <a class="btn btn-danger" href="{{ url('/questions/confirm/'.$question->id) }}">
                    <i class='fa fa-times'></i> {{ _v('remove') }}
                </a>
                <a class="btn btn-warning" href="{{ url('/questions/'.$question->id) }}">
                  <i class='fa fa-pencil'></i> {{ _v('edit') }}
                </a>
              </td>
            </tr>
        @endforeach
      </tbody>
    </table>

    {{ $questions->links() }}
@endsection
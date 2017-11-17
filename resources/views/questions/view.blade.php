@extends('home')

@section('btn-left')
    <a class="btn   btn-primary" href="{{ url('questions') }}">
        <i class="fa fa-btn fa-arrow-circle-left"></i> {{ __('lang.back') }}
    </a>
@endsection

@section('header')
    {{ __('lang.mines_gender_a') }} {{ __('lang.questions') }} {{ isset($categorie) ? '[ '.$categorie->description.' ]' : ''}}
@endsection

@section('btn-right')
  <a class="btn btn-success" href="{{ isset($categorie) ? url('/questions/categorie/'.$categorie->id.'/create/'):url('/questions/create/')}}">
      <i class="fa fa-plus"></i> {{ __('lang.add') }}
  </a>
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
          <th>{{ __('lang.code') }}</th>
          <th>{{ __('lang.image') }}</th>
          <th>{{ __('lang.description') }}</th>
          <th>{{ __('lang.actions') }}</th>
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
                    <i class='fa fa-times'></i> {{ __('lang.remove') }}
                </a>
                <a class="btn btn-warning" href="{{ url('/questions/'.$question->id) }}">
                  <i class='fa fa-pencil'></i> {{ __('lang.edit') }}
                </a>
              </td>
            </tr>
        @endforeach
      </tbody>
    </table>

    {{ $questions->links() }}
@endsection
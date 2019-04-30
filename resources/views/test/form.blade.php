@php
    $action = _v($titleKey);
    if (!isset($testCategory)) $testCategory = isset($test) ? $test->category()->first() : null;
    if (isset($testCategory)) $name = _v('in').' [ '.$testCategory->description.' ]'
@endphp

@extends('layouts.app')

@section('btn-left')
    <a class="btn   btn-primary" href="{{ url('test') }}">
        <i class="fa fa-arrow-circle-left"></i> {{ _v('back') }}
    </a>
@endsection

@section('body')
    <form action="{{ url('/test/'.$test->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($test->id))
            @method("PUT")
        @endif
        @php(Field::build('id', 'text', isset($test) ? $test->id : null, false, true))
        <div class="form-group">
            <label for="category_id">{{ _v('category_id') }}:</label>
            @include('category.tree.select', [
                'father' => false,
                'type'=> 'test',
                'key' => 'category_id',
                'category' => $testCategory,
                'categories' => $testCategories
            ])
        </div>
        @php(Field::build('description', 'textarea', isset($test) ? $test->description : null))
        @php(Submit::build('fa fa-save'))
    </form>
    @if (isset($test->id))
        <iframe src="{{url('/tests/'.$test->id."/questions")}}" frameborder="0"></iframe>
    @endif
@endsection
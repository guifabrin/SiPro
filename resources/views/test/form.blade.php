@extends('home')

@section('btn-left')
    <a class="btn   btn-primary" href="{{ url('test') }}">
        <i class="fa fa-arrow-circle-left"></i> {{ _v('back') }}
    </a>
@endsection

@section('body')
    <h3>
        {{ _v($titleKey) }} {{_v('test')}}
        @if (isset($testCategory))
            {{  _v('in').' [ '.$testCategory->description.' ]' }}
        @else
            @php($testCategory = isset($test) ? $test->category()->first() : null)
        @endif
    </h3>
    <form action="{{ url('/test/'.$test->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($test->id))
            @method("PUT")
        @endif
        @php(Field::build('id', 'text', isset($test) ? $test->id : null, false, true))
        <div class="form-group">
            <label for="categorie_id">{{ _v('categorie_id') }}:</label>
            @include('categories.tree.select', [
                'father' => false,
                'type'=> 'test',
                'key' => 'categorie_id',
                'category' => $testCategory,
                'categories' => $testCategories
            ])
        </div>
        @php(Field::build('description', 'textarea', isset($test) ? $test->description : null))
        @php(Submit::build('fa fa-floppy-o'))
    </form>
    @if (isset($test->id))
        <iframe src="{{url('/tests/'.$test->id."/questions")}}" frameborder="0"></iframe>
    @endif
@endsection
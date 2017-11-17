@extends('home')

@section('btn-left')
    <a class="btn btn-primary" href="{{ url('/user/') }}">
        <i class="fa fa-btn fa-arrow-circle-left"></i> {{ __('lang.back') }}
    </a>
@endsection

@section('header')
    @if (Auth::user()->password=="")
        {{ __('lang.create_password') }}
    @else
        {{ __('lang.edit_password') }}
    @endif
@endsection

@section('body')
    {!! Form::open(array('method' => 'post')) !!}

        @if (Auth::user()->password!="")
        	<fieldset class="form-group">
        	    <label class="col-md-4 control-label">{{ __('lang.actual_password') }}:</label>
        	    <div class="col-md-6">
        	        <input type="password" class="form-control" name="old-password" required="">
        	    </div>
        	</fieldset>
        @endif

        <fieldset class="form-group">
            <label class="col-md-4 control-label">{{ __('lang.new_password') }}:</label>
            <div class="col-md-6">
                <input type="password" class="form-control" name="password" required="">
            </div>
        </fieldset>

        <fieldset class="form-group">
            <label class="col-md-4 control-label">{{ __('lang.repeat_password') }}:</label>
            <div class="col-md-6">
                <input type="password" class="form-control" name="new-password" required="">
            </div>
        </fieldset>

        <fieldset class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-btn fa-floppy-o"></i> {{ __('lang.save') }}
                </button>
            </div>
        </fieldset>

    {!! Form::close() !!}
@endsection
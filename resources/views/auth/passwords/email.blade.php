@extends('home')

@section('header')
    {{ __('lang.reset_title') }}
@endsection

@section('body')
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
        {!! csrf_field() !!}

        <div class="form-group">
            <label class="col-md-4 control-label">{{ __('lang.email') }}</label>

            <div class="col-md-6">
                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-btn fa-envelope"></i> {{ __('lang.send') }}
                </button>
            </div>
        </div>
    </form>
@endsection

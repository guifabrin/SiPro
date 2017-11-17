@extends('home')

@section('header')
    {{ __('lang.reset_title') }}
@endsection

@section('body')
<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
    {!! csrf_field() !!}

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="form-group">
        <label class="col-md-4 control-label">{{ __('lang.email') }}</label>

        <div class="col-md-6">
            <input type="email" class="form-control" name="email" value="{{ $email or old('email') }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">{{ __('lang.password') }}</label>

        <div class="col-md-6">
            <input type="password" class="form-control" name="password">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">{{ __('lang.confirm_password') }}</label>
        <div class="col-md-6">
            <input type="password" class="form-control" name="password_confirmation">
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-btn fa-refresh"></i> {{ __('lang.reset') }}
            </button>
        </div>
    </div>
</form>
@endsection

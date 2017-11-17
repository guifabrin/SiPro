@extends('home')

@section('header')
    Registrar-se no Sistema de Provas
@endsection

@section('body')
    <center>
        <a href="redirect" class="btn btn-primary"><i class="fa fa-facebook"></i> {{ __('lang.register_facebook') }}</a>
    </center>
    <br>
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
        {!! csrf_field() !!}

        <fieldset class="form-group">
            <label class="col-md-4 control-label">{{ __('lang.name') }}</label>

            <div class="col-md-6">
                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
            </div>
        </fieldset>

        <fieldset class="form-group">
            <label class="col-md-4 control-label">{{ __('lang.email') }}</label>

            <div class="col-md-6">
                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
            </div>
        </fieldset>

        <fieldset class="form-group">
            <label class="col-md-4 control-label">{{ __('lang.password') }}</label>

            <div class="col-md-6">
                <input type="password" class="form-control" name="password">
            </div>
        </fieldset>

        <fieldset class="form-group">
            <label class="col-md-4 control-label">{{ __('lang.confirm_password') }}</label>

            <div class="col-md-6">
                <input type="password" class="form-control" name="password_confirmation">
            </div>
        </fieldset>

        <fieldset class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-btn fa-floppy-o"></i> {{ __('lang.register') }}
                </button>
            </div>
        </fieldset>
    </form>
@endsection

@extends('home')

@section('header')
    {{ __('lang.login_title') }}
@endsection

@section('body')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <center>
                <a href="redirect" class="btn btn-primary"><i class="fa fa-facebook"></i> {{ __('lang.login_facebook') }}</a>
            </center>
            <br>
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                {!! csrf_field() !!}

                <fieldset class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">{{ __('lang.email') }}</label>

                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                    </div>
                </fieldset>

                <fieldset class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">{{ __('lang.password') }}</label>

                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password">
                    </div>
                </fieldset>

                <fieldset class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember"> {{ __('lang.remember_me') }}
                            </label>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-sign-in"></i> {{ __('lang.login') }}
                        </button>

                        <a class="btn   btn-link" href="{{ url('/password/reset') }}">{{ __('lang.forgot') }}</a>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
@endsection

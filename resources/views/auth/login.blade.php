@extends('home')

@section('activeItem') active @endsection

@section('header')
    Entrar no Sistema de Provas
@endsection

@section('body')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <center>
                <a href="redirect" class="btn btn-sm btn-primary"><i class="fa fa-facebook"></i> Login com Facebook</a>
            </center>
            <br>
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                {!! csrf_field() !!}

                <fieldset class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">E-Mail</label>

                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                </fieldset>

                <fieldset class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">Senha</label>

                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password">

                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                </fieldset>

                <fieldset class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember"> Lembrar-me
                            </label>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fa fa-btn fa-sign-in"></i>Entrar
                        </button>

                        <a class="btn btn-sm btn-link" href="{{ url('/password/reset') }}">Esqueceu sua senha?</a>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
@endsection

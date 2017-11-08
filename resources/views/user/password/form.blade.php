@extends('home')

@section('my_account_active') active @endsection

@section('headerbtnl')
<a class="btn btn-sm btn-primary" href="{{ URL::previous() }}">
<i class="fa fa-btn fa-arrow-circle-left"></i> Voltar
</a> 
@endsection

@section('header')
@if (Auth::user()->password=="")
Criar senha de usuário
@else
Alterar senha de usuário
@endif

@endsection
@section('body')
{!! Form::open(array('method' => 'post')) !!}
@if (Auth::user()->password!="")
	<fieldset class="form-group">
	    <label class="col-md-4 control-label">Senha Atual:</label>
	    <div class="col-md-6">
	        <input type="password" class="form-control" name="old-password" required="">
	    </div>
	</fieldset>
@endif

<fieldset class="form-group">
    <label class="col-md-4 control-label">Nova Senha:</label>
    <div class="col-md-6">
        <input type="password" class="form-control" name="password" required="">
    </div>
</fieldset>

<fieldset class="form-group">
    <label class="col-md-4 control-label">Repita Nova Senha:</label>
    <div class="col-md-6">
        <input type="password" class="form-control" name="new-password" required="">
    </div>
</fieldset>

<fieldset class="form-group">
    <div class="col-md-6 col-md-offset-4">
        <button type="submit" class="btn btn-sm btn-primary">
            <i class="fa fa-btn fa-floppy-o"></i> Salvar
        </button>
    </div>
</fieldset>

{!! Form::close() !!}
<style>
#password_empty{
	display: none;
}
</style>
@endsection
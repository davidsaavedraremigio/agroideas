@extends('layouts.template-login')
@section('title', 'Registre su nueva contraseña')
@section('content')
<div class="login-logo bg-white">
    <a href=""><b>Sistema</b> {{ config('app.name') }}</a>
</div>
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Reestablecer contraseña</p>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            {!! Form::hidden('token', $token, ['class' => 'form-control']) !!}
            <div class="form-group row">
                <div class="col-md-12">
                    {!! Form::label('email', 'Correo electrónico') !!}
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                    {!! Form::label('password', 'Nueva Contraseña') !!}
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                    {!! Form::label('password-confirm', 'Confirmar contraseña') !!}
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        Reestablecer contraseña
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>







@endsection

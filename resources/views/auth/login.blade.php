@extends('layouts.template-login')
@section('title', 'Inicio de sesión')
@section('content')
<div class="login-logo bg-white">
    <a href=""><b>Sistema</b> {{ config('app.name') }}</a>
</div>
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Ingrese sus datos de acceso para iniciar sesión</p>
        <form method="POST" action="{{route('login')}}">
            @csrf
            <div class="input-group mb-3">
                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" placeholder="Email" required autocomplete="email" autofocus>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-group mb-3">
                <input id="password" placeholder="Contraseña" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-lock"></span>
                    </div>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="icheck-primary">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">
                            Recordarme
                        </label>
                    </div>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt"></i> Acceder</button>
                </div>
            </div>
            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    
                    Olvidó su contraseña?
                </a>
            @endif
        </form>
    </div>
</div>
@endsection

@extends('layouts.auth')

@section('form')
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card bg-secondary shadow border-0">
            <div class="card-header bg-white">
                <p class="text-center text-muted">{{ __('Login') }}</p>
            </div>

            <div class="card-body px-lg-5 py-lg-5">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                            </div>
                            <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                            </div>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-control-alternative custom-checkbox">
                            <input class="custom-control-input" id=" customCheckLogin" type="checkbox" data-com.agilebits.onepassword.user-edited="yes" name="remember" id="remember" value="{{ old('remember') ? 'checked' : '' }}">
                            <label class="custom-control-label" for=" customCheckLogin">
                                <span>Remember me</span>
                            </label>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                                {{ __('Login') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-6">
                <a class="text-light" href="{{ route('password.request') }}">
                        <small>{{ __('Forgot Your Password?') }}</small>
                </a>
            </div>
            <div class="col-6 text-right">
                <a class="text-light" href="{{ route('register') }}">
                    <small>Create new account</small>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

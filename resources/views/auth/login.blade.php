@extends('layouts.app')

@section('content')

    <form role="form" method="POST" action="{{ url('/login') }}" class="login">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <input type="email" name="email" value="{{ old('email') }}" class="{{ (session('error')) ? 'error' : '' }}" placeholder="{{ trans('forms.email') }}" required autofocus />

            @if ($errors->has('email'))
                <small>{{ $errors->first('email') }}</small>
            @endif
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <input type="password" name="password" class="{{ (session('error')) ? 'error' : '' }}" placeholder="{{ trans('forms.password') }}" required />

            @if ($errors->has('password'))
                <small>{{ $errors->first('password') }}</small>
            @endif
        </div>

        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember"> {{ trans('auth.remember_me') }}
                </label>
            </div>
        </div>

        <button>{{ trans('forms.submit') }}</button>

        <a href="{{ route('auth.password.reset') }}">{{ trans('auth.forgot_password') }}</a>
    </form>
@endsection

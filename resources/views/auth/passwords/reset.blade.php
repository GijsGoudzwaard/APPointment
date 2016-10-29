@extends('layouts.app')

@section('content')

    {!! Form::open(['method' => 'POST', 'url' => 'password/reset', 'class' => 'reset']) !!}

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <h4>{{ trans('auth.password_reset') }}</h4>

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <input type="email" name="email" value="{{ old('email') ?: $email }}" class="{{ (session('error')) ? 'error' : '' }}" placeholder="{{ trans('forms.email') }}" required autofocus />

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

    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <input type="password" name="password_confirmation" class="{{ (session('error')) ? 'error' : '' }}" placeholder="{{ trans('forms.password_confirmation') }}" required />

        @if ($errors->has('password_confirmation'))
            <small>{{ $errors->first('password_confirmation') }}</small>
        @endif
    </div>

    <input type="hidden" name="token" value="{{ $token }}">

    <button>{{ trans('forms.submit') }}</button>

    <a href="{{ route('auth.login') }}">{{ trans('forms.go_back') }}</a>

    {!! Form::close() !!}

@stop

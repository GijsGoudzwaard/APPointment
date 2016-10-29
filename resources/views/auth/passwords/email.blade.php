@extends('layouts.app')

@section('content')
    {!! Form::open(['method' => 'POST', 'url' => 'password/email', 'class' => 'email']) !!}

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <h4>{{ trans('auth.password_reset') }}</h4>

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <input type="email" name="email" value="{{ old('email') }}" class="{{ (session('error')) ? 'error' : '' }}" placeholder="{{ trans('forms.email') }}" required autofocus />

        @if ($errors->has('email'))
            <small>{{ $errors->first('email') }}</small>
        @endif
    </div>

    <button>{{ trans('forms.submit') }}</button>

    <a href="{{ route('auth.login') }}">{{ trans('forms.go_back') }}</a>

    {!! Form::close() !!}
@stop

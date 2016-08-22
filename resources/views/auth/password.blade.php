<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
	<title>APPointment {{ strtolower(trans('auth.password_reset')) }}</title>
	<link href="https://fonts.googleapis.com/icon?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" href="{{ url('assets/dist/login.css') }}" />
</head>
<body>

	{!! Form::open(['method' => 'POST', 'url' => 'password/email', 'class' => 'password-reset']) !!}

		@if (session('status'))
			<div class="alert alert-success">
				{{ session('status') }}
			</div>
		@endif

		<h4>{{ trans('auth.password_reset') }}</h4>

		<input type="email" name="email" placeholder="E-mail" class="{{ (session('error')) ? 'error' : '' }}" required autofocus />

		@if (session('error'))
			<small>{{ session('error') }}</small>
		@endif

		<button>{{ trans('forms.submit') }}</button>

		<a href="{{ route('auth.login') }}">{{ trans('forms.go_back') }}</a>

	{!! Form::close() !!}

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
	<title>APPointment login</title>
	<link href="https://fonts.googleapis.com/icon?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" href="{{ url('assets/dist/login.css') }}" />
</head>
<body>

	{!! Form::open() !!}
		<input type="email" name="email" placeholder="{{ trans('forms.email') }}" class="{{ (session('error')) ? 'error' : '' }}" value="{{ old('email') }}" required autofocus />

		@if (session('error'))
			<small>{{ session('error') }}</small>
		@endif

		<input type="password" name="password" placeholder="{{ trans('forms.password') }}"  class="{{ (session('error')) ? 'error' : '' }}" required />

		@if (session('error'))
			<small>{{ session('error') }}</small>
		@endif

		<label for="remember">{{ trans('auth.remember_me') }}
			<input type="checkbox" name="remember">
		</label>


		<button>{{ trans('forms.submit') }}</button>

		<a href="{{ url('password/reset') }}" class="forgot-password">{{ trans('auth.forgot_password') }}</a>

	{!! Form::close() !!}

</body>
</html>

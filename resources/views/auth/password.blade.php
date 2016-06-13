<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
	<title>APPointment password reset</title>
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

		<h4>Password reset</h4>

		<input type="email" name="email" placeholder="E-mail" class="{{ (session('error')) ? 'error' : '' }}" required autofocus />

		@if (session('error'))
			<small>{{ session('error') }}</small>
		@endif

		<button>Submit</button>

		<a href="{{ url('login') }}">Go back</a>

	{!! Form::close() !!}

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
	<title>Appointment login</title>
	<link href="https://fonts.googleapis.com/icon?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" href="{{ url('assets/dist/login.css') }}" />
</head>
<body>

	{!! Form::open() !!}
		<input type="email" name="email" placeholder="E-mail" class="{{ (session('error')) ? 'error' : '' }}" required autofocus />
		@if (session('error'))
			<small>{{ session('error') }}</small>
		@endif
		<input type="password" name="password" placeholder="Password"  class="{{ (session('error')) ? 'error' : '' }}" required />
		@if (session('error'))
			<small>{{ session('error') }}</small>
		@endif

		<label for="remember">Remember me
			<input type="checkbox" name="remember">
		</label>
		<button>Submit</button>
	{!! Form::close() !!}

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Appointment login</title>
	<link href="https://fonts.googleapis.com/icon?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" href="{{ url('assets/dist/login.css') }}" />
</head>
<body>

	{!! Form::open() !!}
		<input type="email" name="email" placeholder="E-mail" required autofocus />
		<input type="password" name="password" placeholder="Password" required />
		<label for="remember">Remember me
			<input type="checkbox" name="remember">
		</label>
		<button>Submit</button>
	{!! Form::close() !!}

</body>
</html>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Calendar{{ ($page != null) ? ' - ' . $page : '' }}</title>
		<link rel="stylesheet" href="{{ url('/resources/assets/css/app.css') }}">
	</head>
	<body>

		@include('layouts.nav')

		@yield('content')

	</body>
</html>

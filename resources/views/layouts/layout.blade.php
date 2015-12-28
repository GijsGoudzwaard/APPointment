<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Calendar{{ ($page != null) ? ' - ' . $page : '' }}</title>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="{{ url('/resources/assets/dist/all.css') }}">
	</head>
	<body>

		@include('layouts.nav')

		@yield('content')

	</body>
</html>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>APPointment{{ ($page != null) ? ' - ' . $page : '' }}</title>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons&amp;Roboto" rel="stylesheet">
		{{-- <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'> --}}
		<link rel="stylesheet" href="{{ url('assets/dist/all.css') }}">
	</head>
	<body>

		@include('layouts.nav')

		<div id="content">
			@yield('content')
		</div>

	</body>
</html>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>APPointment{{ ($page != null) ? ' - ' . $page : '' }}</title>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons|Roboto" rel="stylesheet">
		{{-- <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'> --}}
		<link rel="stylesheet" href="{{ url('assets/dist/all.css') }}">
	</head>
	<body>

		@include('layouts.nav')
		@include('layouts.topbar')

		<div id="content">
			@yield('content')
		</div>

		<script src="{{ url('assets/dist/all.js') }}"></script>
	</body>
</html>

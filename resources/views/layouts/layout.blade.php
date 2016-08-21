<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
		<title>APPointment{{ isset($page) ? ' - ' . $page : '' }}</title>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons|Roboto" rel="stylesheet">
		<link rel="stylesheet" href="{{ asset('assets/dist/all.css') }}">
	</head>
	<body>

		<div id="loader">
			<div class="container">
				<img src="{{ asset('assets/img/loading.svg') }}" alt="loader" />
				<p>Loading...</p>
			</div>
		</div>

		@include('layouts.nav')
		@include('layouts.header')

		<div id="content" class="{{ (isset($page) && strtolower($page) == 'appointments') ? 'calendar' : '' }} {{ isset($_COOKIE['smallMenu']) ? 'expanded' : '' }}">
			<?php $message = session('success') ?? session('errors') ?>

			@include('layouts.message')

			@yield('content')
		</div>

		<script src="{{ asset('assets/dist/all.js') }}"></script>
		@yield('js')
	</body>
</html>

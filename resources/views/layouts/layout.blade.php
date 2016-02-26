<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>APPointment{{ ($page != null) ? ' - ' . $page : '' }}</title>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons|Roboto" rel="stylesheet">
		<link rel="stylesheet" href="{{ asset('assets/dist/all.css') }}">
	</head>
	<body>

		@include('layouts.nav')
		@include('layouts.topbar')
		<div id="content" class="{{ (strtolower($page) == 'appointments') ? 'calendar' : '' }}">
			<?php $message = session('success') ?? session('errors') ?>

			@if ($message)
				<div class="alert alert-{{ (session('success')) ? 'success' : 'danger' }}" role="alert">
					@if (is_array($message))
						<ul>
							@foreach ($message as $m)
								<li>{{ $m }}</li>
							@endforeach
						</ul>
					@else
						{{ $message }}
					@endif
				</div>
			@endif

			@yield('content')
		</div>

		<script src="{{ asset('assets/dist/all.js') }}"></script>
		@yield('js')
	</body>
</html>

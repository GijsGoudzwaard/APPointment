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
				<p>{{ trans('base.loading') }}</p>
			</div>
		</div>

		@include('layouts.nav')
		@include('layouts.header')

		<div id="content" class="{{ (isset($page) && strtolower($page) == 'appointments') ? 'calendar' : '' }}">
			@include('layouts.message')
			@yield('content')
		</div>

		<script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-88946366-1', 'auto');
            ga('send', 'pageview');
		</script>

		<script src="{{ asset('assets/dist/all.js') }}"></script>
		@yield('js')
	</body>
</html>

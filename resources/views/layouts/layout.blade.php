<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Calendar{{ ($page != null) ? ' - ' . $page : '' }}</title>
	</head>
	<body>

		@include('layouts.nav')

		@yield('content')

	</body>
</html>

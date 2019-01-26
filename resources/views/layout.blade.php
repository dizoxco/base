<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
		<meta name="theme-color" content="#002f6c" />
		<title>خدمات رفاهی - @yield('title')</title>
		<link href="{{ asset('css/main.css') }}" rel="stylesheet">
	</head>
	<body class="portal @can('admin menu') admin @endcan">
		@component('components.nav.simple') @endcomponent
		<div>master page</div>
		<div id="contetn" class="container mx-auto">
			@yield('content')
		</div>
		@component('components.footer.simple') @endcomponent
	</body>
</html>
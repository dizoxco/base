<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
		<meta name="theme-color" content="#002f6c" />
		<title>خدمات رفاهی - @yield('title')</title>
		<link href="{{ asset('css/main.css') }}" rel="stylesheet">
	</head>
	<body class="portal @can('admin menu') admin @endcan" dir="rtl">
		@component('components.nav.simple') @endcomponent
		<div>master page</div>
		<div id="content" class="container mx-auto">
			@yield('content')
		</div>
		@component('components.footer.simple') @endcomponent
		<div class="flex flex-wrap">
			<div class="w-1/2 rtl">
				<div class="mdc-text-field">
					<input type="text" id="my-text-field" class="mdc-text-field__input">
					<label class="mdc-floating-label" for="my-text-field">Hint text</label>
					<div class="mdc-line-ripple">
				</div>
			  </div></div>
			<div class="w-1/2"> col 2</div>
		</div>
		<script src="/js/app.js"></script>
	</body>
</html>
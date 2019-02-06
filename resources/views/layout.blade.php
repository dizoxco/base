<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
		<meta name="theme-color" content="#002f6c" />
		<title>خدمات رفاهی - @yield('title')</title>
		<link href="{{ asset('css/main.css') }}" rel="stylesheet">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	</head>
	<body class="portal @can('admin menu') admin @endcan" dir="rtl">
		@component('components.nav.simple') @endcomponent
		<div>master page</div>
		<div id="content" class="container mx-auto">
			@yield('content')

			<br>
			<br>
			<br>
			<div class="flex flex-wrap">
				<div class="w-1/2 rtl">
					@component('components.form.textarea', ['label' => 'نام'])@endcomponent
					@component('components.form.text', ['label' => 'نام', 'icon' => 'edit'])@endcomponent
					@component('components.form.text', ['label' => 'فامیلی', 'outlined' => true, 'icon' => 'add'])@endcomponent
					@component('components.form.text', ['label' => 'dd', 'outlined' => true ])@endcomponent
					@component('components.form.text', ['label' => 'dd', 'outlined' => true, 'shaped' => true])@endcomponent
					@component('components.form.button', ['label' => 'dd', 'shaped' => true])@endcomponent
					@component('components.form.button', [
						'label' => 'dd',
						'outlined' => true,
						'shaped' => true
					])@endcomponent
					@component('components.form.button', ['label' => 'dd', 'raised' => true, 'icon' => 'favorite'])@endcomponent
				</div>
				<div class="w-1/2"> col 2</div>
			</div>
			<br>
			<br>
			<br>

			
		</div>
		@component('components.footer.simple') @endcomponent
		<script src="/js/app.js"></script>
	</body>
</html>
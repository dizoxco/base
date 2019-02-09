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
		<br><br><br><br><br>
		<div id="content">
			@yield('content')
		</div>
		<div class="container medium flex flex-wrap">
			@component('components.form.text',[
				'label' => 'نام خانوادگی',
			])
			@endcomponent
			@component('components.form.field')
				
			@endcomponent
			@component('components.form.text',[
				'label' => 'نام',
				'icon' => 'add',
			])
			@endcomponent
			@component('components.form.text',[
				'label' => 'نام',
				'icon' => 'add',
				'icon_front' => 'sd'
			])
			@endcomponent
			
			@component('components.form.text',[
				'label' => 'dfsd',
				'shaped' => true
			])				
			@endcomponent
			<div class="w-1/2"></div>
			@component('components.form.text',[
				'label' => 'dfsd',
				'icon' => 'add',
				'shaped' => true
			])				
			@endcomponent
			@component('components.form.text',[
				'label' => 'dfsd',
				'icon' => 'add',
				'shaped' => true,
				'icon_front' => 'sd'
			])				
			@endcomponent
			
			@component('components.form.field', ['full' => true])
				@component('components.form.button',[
					'label' => 'ذخیره',
					'type' => 'text'
				])
				@endcomponent
				@component('components.form.button',[
					'label' => 'ذخیره',
					'type' => 'text',
					'icon' => 'favorite'
				])
				@endcomponent
				@component('components.form.button',[
					'label' => 'ذخیره',
					'type' => 'text',
					'dense' => true
				])
				@endcomponent
				@component('components.form.button',[
					'label' => 'ذخیره',
					'type' => 'text',
					'icon' => 'favorite',
					'dense' => true
				])
				@endcomponent
			@endcomponent
			@component('components.form.field', ['full' => true])
				@component('components.form.button',[
					'label' => 'ذخیره',
					'type' => 'outlined'
				])
				@endcomponent
				@component('components.form.button',[
					'label' => 'ذخیره',
					'type' => 'outlined',
					'icon' => 'favorite'
				])
				@endcomponent
				@component('components.form.button',[
					'label' => 'ذخیره',
					'type' => 'outlined',
					'dense' => true,
				])
				@endcomponent
				@component('components.form.button',[
					'label' => 'ذخیره',
					'type' => 'outlined',
					'icon' => 'favorite',
					'dense' => true,
				])
				@endcomponent
			@endcomponent
			@component('components.form.field', ['full' => true])
				@component('components.form.button',[
					'label' => 'ذخیره'
				])
				@endcomponent
				@component('components.form.button',[
					'label' => 'ذخیره',
					'icon' => 'favorite'
				])
				@endcomponent
				@component('components.form.button',[
					'label' => 'ذخیره',
					'dense' => true
				])
				@endcomponent
				@component('components.form.button',[
					'label' => 'ذخیره',
					'icon' => 'favorite',
					'dense' => true
				])
				@endcomponent

			@endcomponent
			@component('components.form.field', ['full' => true])
				<button class="mdc-icon-button material-icons" data-mdc-auto-init="mdc-ripple" data-mdc-ripple-is-unbounded>favorite</button>
				<button class="mdc-icon-button material-icons" data-mdc-auto-init="mdc-ripple" data-mdc-ripple-is-unbounded >favorite</button>
			@endcomponent
			@component('components.form.field', ['full' => true])
				<button class="mdc-icon-button material-icons" data-mdc-auto-init="mdc-ripple" data-mdc-ripple-is-unbounded>favorite</button>
				<button class="mdc-icon-button material-icons" data-mdc-auto-init="mdc-ripple" data-mdc-ripple-is-unbounded >favorite</button>
			@endcomponent
		</div>
		<div class="bg-grey-light">
			<footer class="container mx-auto w-full">
				<div class="flex flex-row items-start -mx-2">
					<div class="footer-col1 w-1/4 px-4 py-2 m-2">
						simple footer col1
					</div>
					<div class="footer-col2 w-1/4 px-4 py-2 m-2">
						simple footer col 2
					</div>
					<div class="footer-col3 w-1/4 px-4 py-2 m-2">
						simple footer col 3
					</div>
					<div class="footer-col4 w-1/4 px-4 py-2 m-2">
						simple footer col 4
					</div>
				</div>
			</footer>
		</div>
		<script src="/js/app.js"></script>
	</body>
</html>
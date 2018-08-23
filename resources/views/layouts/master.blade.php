<!DOCTYPE HTML>
<html class="no-js" data-url="{{ url('/') }}" data-api-url="{{ url('/api') }}" lang="en">
	<head>
		@if ( config('app.google_site_id') )
		<meta name="google-site-verification" content="{{ config('app.google_site_id') }}">
		@endif
		<meta charset="utf-8">
		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="csrf-token" content="{{ csrf_token() }}">

		<title>@yield('title') | CSUN</title>

        <meta name="description" content="@yield('description')">
		<link rel="icon" href="//www.csun.edu/sites/default/themes/csun/favicon.ico" type="image/x-icon" />

		{{-- STYLESHEETS --}}
		{!! HTML::style('css/app.css') !!}

		@yield('page-specific-headers')
	</head>
	<body>

		{{-- FACULTY CONTENT --}}
		@include('layouts.partials.header')
			@yield('content')
		@include('layouts.partials.footer')

		{{-- SCRIPTS --}}
		{!! HTML::script('/js/manifest.js') !!}
		{!! HTML::script('/js/vendor.js') !!}
		{!! HTML::script('js/app.js') !!}

		@yield('page-specific-scripts')
		{{-- GOOGLE ANALYTICS --}}
		@if ( config('app.google_analytics_id') )
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', '{{ config("app.google_analytics_id") }}', 'auto');
			ga('send', 'pageview');
		</script>
		@endif
	</body>
</html>

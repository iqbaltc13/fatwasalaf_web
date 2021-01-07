<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php
        $publicUrl = url('/').'/templates/scutum-admin/scutum_v2.1.0/admin/html/dist/';   
    @endphp
	<meta charset="UTF-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{{ config('app.name', 'Starter Project Artcak') }} @yield('title')</title>
    <meta name="description" content="Scutum Admin Template" />

    <link rel="apple-touch-icon" sizes="180x180" href="{{$publicUrl}}assets/img/fav/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="{{asset('images/logo_oren.png')}}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/logo_oren.png')}}">
	<link rel="mask-icon" href="{{$publicUrl}}assets/img/fav/safari-pinned-tab.svg" color="#5bbad5">

	<link rel="manifest" href="{{$publicUrl}}manifest.json">
	<meta name="theme-color" content="#00838f">


	<!-- polyfills -->
	<script src="{{$publicUrl}}assets/js/vendor/polyfills.min.js"></script>

	<!-- UIKit js -->
	<script src="{{$publicUrl}}assets/js/uikit.min.js"></script>
	<style>
		/* #sc-header .uk-navbar{
			background:#497C73 !important;
		} */
		#sc-header .uk-navbar .uk-navbar-nav>li>a{
			color:black !important;
		}
		#sc-header .uk-navbar{
			background:#efefef !important;
		}
		.underline-success{
			border-bottom-color: green !important;
			border-bottom-style: solid !important;
			/* text-decoration-color: green; */
			/* text-decoration-style: double; */
		}
		/* #sc-header .uk-navbar{
			background:#FF5722 !important;
		} */
	</style>
</head>
    @yield('body')
</html>
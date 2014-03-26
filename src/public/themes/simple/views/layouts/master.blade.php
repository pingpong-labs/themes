<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title> @yield('title', site('name')) </title>
		<meta name="description" content="{{ site('description') }}" />
		<meta name="keywords" content="{{ site('keywords') }}" />
		<meta name="author" content="{{ site('author') }}" />
		<link rel="shortcut icon" href="{{ Theme::asset('favicon.ico') }}"> 
		{{ Theme::style('css/style.css') }}
		{{ Theme::script('js/modernizr.custom.js') }}
	</head>
	<body>

		@include('simple::partials.header')
		
		@yield('content')
		
		{{ Theme::script('js/jquery.min.js') }}
		{{ Theme::script('js/boxlayout.js') }}
		{{ Theme::script('js/nav.js') }}
		{{ Theme::script('js/all.js') }}
	</body>
</html>

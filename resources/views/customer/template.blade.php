<!DOCTYPE html>
<html class="preview-loader is-scrolling">
<head>
	<title>Tsana - @yield('title')</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<link rel="stylesheet" href="{{ asset("customer/assets/css/style.css") }}" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="{{ asset("customer/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css") }}" />
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  
	<script src="https://cdnjs.cloudflare.com/ajax/libs/particlesjs/2.2.3/particles.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body> 
	<canvas class="background"></canvas>
	@yield('body')
</body>
<script src="https://kit.fontawesome.com/d8162761f2.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>   
<script type="text/javascript" src="{{ asset("customer/assets/js/api.js") }}"></script>   
<script type="text/javascript" src="{{ asset("customer/assets/js/window.js") }}"></script>   
@yield('js')
</html>			
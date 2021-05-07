<html lang="en">
<head>
	<title>@yield('judul')</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="{{ asset('assets/favicon.png') }}"/>
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/loginn/vendor/bootstrap/css/bootstrap.min.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/loginn/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/loginn/fonts/iconic/css/material-design-iconic-font.min.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/loginn/vendor/animate/animate.css') }}">
	<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/loginn/vendor/css-hamburgers/hamburgers.min.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/loginn/vendor/animsition/css/animsition.min.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/loginn/vendor/select2/select2.min.css') }}">
	<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/loginn/vendor/daterangepicker/daterangepicker.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/loginn/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/loginn/css/main.css') }}">
	<!--===============================================================================================-->
</head>
<body>

	@yield('konten')

	<div id="dropDownSelect1"></div>

	<!--===============================================================================================-->
	<script src="{{ asset('assets/loginn/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
	<!--===============================================================================================-->
	<script src="{{ asset('assets/loginn/vendor/animsition/js/animsition.min.js') }}"></script>
	<!--===============================================================================================-->
	<script src="{{ asset('assets/loginn/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('assets/loginn/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
	<!--===============================================================================================-->
	<script src="{{ asset('assets/loginn/vendor/select2/select2.min.js') }}"></script>
	<!--===============================================================================================-->
	<script src="{{ asset('assets/loginn/vendor/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('assets/loginn/vendor/daterangepicker/daterangepicker.js') }}"></script>
	<!--===============================================================================================-->
	<script src="{{ asset('assets/loginn/vendor/countdowntime/countdowntime.js') }}"></script>
	<!--===============================================================================================-->
	<script src="{{ asset('assets/loginn/js/main.js') }}"></script>

</body>
</html>
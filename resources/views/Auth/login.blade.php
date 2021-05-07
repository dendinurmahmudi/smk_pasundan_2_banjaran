@extends('Auth/master')
@section('judul','Login')
@section('konten')
<div class="limiter">
	<div class="container-login100" style="background-image: url('{{ asset('assets/loginn/images/bg-01.jpg') }}')">
		<div class="wrap-login100">
			
			<form action="{{ route('login') }}" method="post">
				@csrf
				<span class="login100-form-logo">
					<img src="{{ asset('assets/favicon.png') }}" alt="" width="170px" height="170px" class="img-responsive">
				</span>

				<span class="login100-form-title p-b-34 p-t-27">
					Log in
				</span>
				
				@if(session('errors'))
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<ul>
						@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
				@endif
				@if (Session::has('success'))
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					{{ Session::get('success') }}
				</div>
				@endif
				@if (Session::has('error'))
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					{{ Session::get('error') }}
				</div>
				@endif

				<div class="wrap-input100 validate-input" data-validate = "Enter Nisn">
					<input class="input100" type="text" name="nisn" placeholder="NISN/NIP" value="">
				</div>
				<div class="wrap-input100 validate-input" data-validate="Enter password">
					<input class="input100" type="password" name="password" placeholder="Password" value="">
				</div>
				<div class="container-login100-form-btn">
					<button class="login100-form-btn" name="btn_login">
						Masuk
					</button>
				</div>
				<div class="text-center p-t-70" style="margin-top: -50px;">
					<a class="txt1" href="#" data-toggle="modal" data-target="#lupapass">
						Lupa Password?
					</a>
				</div>
				<font color="white">
					<div class="text-center p-t-80" style="margin-top: -50px;">
						<a class="txt1" href="{{ route('register') }}">Belum punya akun? Register sekarang!</a>
					</div>
				</form>

			</div>
		</div>
	</div>

	<div id="dropDownSelect1"></div>

	<div class="modal fade" id="lupapass" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="container-login10" style="background-image: url('{{ asset('assets/loginn/images/bg-01.jpg') }}')">
					<div class="wrap-login101">
						<div class="modal-body ">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<form action="{{ url('lupapass/send') }}" method="post">
								@csrf
								<span class="login100-form-logo">
									<img src="{{ asset('assets/favicon.png') }}" alt="" width="170px" height="170px" >
								</span>
								<span class="login100-form-title p-b-63 p-t-60">
									Lupa Password
								</span>
								<div class="wrap-input100 validate-input" data-validate = "Enter email">
									<input class="input100" type="text" name="id" placeholder="Masukan id">
								</div>
								<div class="container-login100-form-btn">
									<button class="login100-form-btn" name="btn_login">
										Kirim
									</button>
								</div>
								<div class="text-center p-t-80" style="margin-top: -50px;">
									Masukan ID anda dan pastikan email yang anda daftarkan aktif untuk mengikuti langkah-langkah mengubah password anda.
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endsection
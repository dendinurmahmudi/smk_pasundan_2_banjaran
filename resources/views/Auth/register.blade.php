@extends('Auth/master')
@section('judul','Register')
@section('konten')
<div class="limiter">
	<div class="container-login100" style="background-image: url('{{ asset('assets/loginn/images/bg-01.jpg') }}')">
		<div class="wrap-login100">
			
			<form action="{{ route('register') }}" method="post">
				@csrf
				<span class="login100-form-logo">
					<img src="{{ asset('assets/favicon.png') }}" alt="" width="170px" height="170px" >
				</span>

				<span class="login100-form-title p-b-34 p-t-27">
					Register
				</span>
				@if (Session::has('gagal'))
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					{{ Session::get('gagal') }}
				</div>
				@endif
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
				<div class="wrap-input100 validate-input" data-validate = "Enter nis">
					<input class="input100" type="text" name="nisn" placeholder="NISN">
					
				</div>

				<div class="wrap-input100 validate-input" data-validate = "Enter name">
					<input class="input100" type="text" name="name" placeholder="Nama Lengkap">
					
				</div>

				<div class="wrap-input100 validate-input" data-validate = "Enter email">
					<input class="input100" type="text" name="email" placeholder="email@contoh.com">
					
				</div>

				<div class="wrap-input100 validate-input" data-validate = "Enter lulusan">
					<input class="input100" type="text" name="lulusan" placeholder="Lulusan (contoh:2018)">
					
				</div>

				<div class="wrap-input100 validate-input" data-validate = "Enter Jurusan">
					<select class="form-control" name="jurusan" >
						<option value="0">Pilih Jurusan</option>
						@foreach ($jurusan as $j)
						<option value="{{$j->id_jurusan}}">{{$j->nama_jurusan}}</option>
						@endforeach
					</select>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Enter password">
					<input class="input100" type="password" name="password" placeholder="Password">
					
				</div>
				<div class="wrap-input100 validate-input" data-validate="Enter password_confirmation">
					<input class="input100" type="password" name="password_confirmation" placeholder="Ulangi Password">
					
				</div>

				<div class="container-login100-form-btn">
					<button class="login100-form-btn" name="btn_login">
						Kirim
					</button>
				</div>
				<font color="white">
					<div class="text-center p-t-70" style="margin-top: -50px;">
						<a class="txt1" href="{{ route('login') }}">Sudah punya akun? Login sekarang!</a>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="dropDownSelect1"></div>
	@endsection
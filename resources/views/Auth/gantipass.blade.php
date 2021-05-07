@extends('Auth/master')
@section('judul','Ubah Password')
@section('konten')
<div class="limiter">
	<div class="container-login100" style="background-image: url('{{ asset('assets/loginn/images/bg-01.jpg') }}')">
		<div class="wrap-login100">
			
			<form action="{{ route('register') }}" method="post">
				@csrf
				<span class="login100-form-logo">
					<img src="{{ asset('assets/loginn/images/bg-01.jpg') }}" alt="" width="130px" height="130px" class="rounded-circle">
				</span>

				<span class="login100-form-title p-b-34 p-t-27">
					Ubah Password
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
				<div class="wrap-input100 validate-input" data-validate="Enter password">
					<input class="input100" type="password" name="password" placeholder="Password Baru">
					
				</div>
				<div class="wrap-input100 validate-input" data-validate="Enter password_confirmation">
					<input class="input100" type="password" name="password_confirmation" placeholder="Ulangi Password">
					
				</div>

				<div class="container-login100-form-btn">
					<button class="login100-form-btn" name="btn_login">
						Kirim
					</button>
				</div>
			</form>

		</div>
	</div>
</div>

<div id="dropDownSelect1"></div>
@endsection
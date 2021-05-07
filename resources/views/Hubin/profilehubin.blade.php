@extends('master')
@section('judul','Profile')
@section('class','icon-user fa-fw')
@section('label','Profile')
@extends('Hubin/sidebar')
@section('konten')
<div class="row">
	@if(session('errors'))
	<div class="alert alert-danger" role="alert">

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
	@if (Session::has('gagal'))
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		{{ Session::get('gagal') }}
	</div>
	@endif
	<div class="col-sm-6">
		<div class="tab-content">
			<div class="white-box">                        
				<div class="user-bg"> <img width="100%" alt="user" src="{{ asset('data_file/profile/'.Auth::user()->foto) }}">
					<div class="overlay-box">
						<div class="user-content">
							<a href="javascript:void(0)"><img src="{{ asset('data_file/profile/'.Auth::user()->foto) }}" class="thumb-lg img-circle" alt="img"></a>
							<h4 class="text-white">{{ Auth::user()->name }}</h4>
							<h5 class="text-white">{{ Auth::user()->email}}</h5>
							<h5 class="text-white">{{ Auth::user()->nisn}}</h5>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<hr>
						<form class="form-material" action="updateprofile" method="POST" enctype="multipart/form-data">
							{{ csrf_field() }}
							<input type="hidden" name="nisn" value="{{ Auth::user()->nisn}}">
							<div class="col-md-12">
								<div class="white-box">
									<h3 class="box-title">Ganti Foto</h3>
									<input type="file" id="input-file-now" name="file" class="dropify" data-default-file="{{ asset('data_file/profile/'.Auth::user()->foto) }}"/><br>
								</div>
							</div>    
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-6">
			<div class="tab-content">
				<div class="white-box">                        
					<p class="text-muted font-13"> Detail profile </p>
					<p class="text-muted font-13"> <i>*mohon lengkapi biodata anda.</i> </p>
					<div class="row">
						<div class="col-sm-12">
							<hr>
							<form class="form-material" action="updatepenelusuran" method="POST">
								{{ csrf_field() }}

								<div class="form-group">
									<label for="exampleInputEmail1">NIP :</label>
									<input type="text" class="form-control" id="exampleInputEmail1" name="nisn" value="{{ Auth::user()->nisn}}" placeholder="" ></div>
									<div class="form-group">
										<label for="exampleInputEmail1">Nama :</label>
										<input type="text" class="form-control" id="exampleInputEmail1" name="name" value="{{ Auth::user()->name}}" placeholder=""> </div>
										<div class="form-group">
											<label for="exampleInputEmail1">Email :</label>
											<input type="text" class="form-control" id="exampleInputEmail1" name="email" value="{{ Auth::user()->email}}" placeholder=""> </div>
											<div class="col-sm-12 col-xs-12">
												<button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
												<a href="#" title="" data-toggle="modal" data-target="#gantipass" class="btn btn-info waves-effect waves-light m-r-10">Ganti Password</a>
											</div>        
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- modal -->
					<div id="gantipass" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title" id="myModalLabel">Ganti password</h4> </div>
									<div class="modal-body">
										<div class="white-box">
											<form action="/gantipass" enctype="multipart/form-data" method="post">
												{{ csrf_field() }}
												<div class="row">
													<div class="form-group col-sm-12">
														<input type="hidden" name="id" value="{{ Auth::user()->id}}">
														<div class="form-group col-sm-12">
														Password Lama
															<input type="password" name="passwordLama" class="form-control" placeholder="Password Lama" aria-label="Username" aria-describedby="basic-addon1" required>
														</div>
														<div class="form-group col-sm-12">
														Password Baru
															<input type="password" name="passwordBaru1" class="form-control" placeholder="Password Baru" aria-label="Username" aria-describedby="basic-addon1" required>
														</div>
														<div class="form-group col-sm-12">
														Ulangi Password
															<input type="password" name="passwordBaru2" class="form-control" placeholder="Ulangi Password Baru" aria-label="Username" aria-describedby="basic-addon1" required>
														</div>

													</div>
													<div class="col-sm-12 col-xs-12">
														<button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						@endsection
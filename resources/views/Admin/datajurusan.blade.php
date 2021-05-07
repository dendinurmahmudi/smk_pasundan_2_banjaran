<?php  ?>
@extends('master')
@section('judul','Data Jurusan')
@section('class','fa fa-sitemap fa-fw')
@section('label','Jurusan')
@extends('Admin/sidebar')
@section('konten')
<div class="row">
	<div class="col-sm-12">
		@if (Session::has('success'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			{{ Session::get('success') }}
		</div>
		@endif
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
		<a href="#" data-toggle="modal" data-target="#datajurusan" title="Data Jurusan" class="m-r-20"><i class="fa fa-sitemap m-b-30"></i> Data Jurusan</a>
		|
		<a href="#" data-toggle="modal" data-target="#tambahalumni" class="m-l-20" title="Tambah data Alumni"><i class="fa fa-plus-circle"></i> Tambah Alumni</a>
		<div class="white-box">
			<div class="row row-in">
				<!--  -->
				@foreach($jurusan as $j)
				<a href="/datalumni/{{$j->nama_jurusan}}" title="Data alumni {{$j->nama_jurusan}}">
					<?php 
					if ($j->nama_jurusan == 'Teknik Komputer Jaringan') {
						$warna11 = 'primary';
						$nama = 'TKJ';
					}elseif ($j->nama_jurusan == 'Teknik Kendaraan Ringan') {
						$warna11 = 'warning';
						$nama = 'TKR';
					}elseif ($j->nama_jurusan == 'Teknik Bisnis Sepeda Motor') {
						$warna11 = 'success';
						$nama = 'TBSM';
					}elseif ($j->nama_jurusan == 'Permesinan') {
						$warna11 = 'info';
						$nama = 'Permesinan';
					}elseif ($j->nama_jurusan == 'Kelistrikan') {
						$warna11 = 'purple';
						$nama = 'Kelistrikan';
					}else {
						$nama= $j->nama_jurusan;
						$warna11 = 'danger';
					} ?>
					<div class="col-lg-4 col-sm-12 row-in-br m-t-15 m-b-15">
						<ul class="col-in">
							<li>
								<span class="circle circle-md bg-{{$warna11}}"><i class="ti-clipboard"></i></span>
							</li>
							<li class="col-last">
								<h3 class="counter text-right m-t-15">{{$j->jumlah}}</h3></li>
								<li class="col-middle">
									<h4>{{$nama}}</h4>
									<div class="progress">
										<div class="progress-bar progress-bar-{{$warna11}}" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
										</div>
									</div>
								</li>
							</ul>
						</div>
					</a>
					@endforeach
					<!--  -->
				</div>
			</div>
		</div>
	</div>
	<!-- data -->
	<div id="datajurusan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModalLabel">Data Jurusan</h4> </div>
					<div class="modal-body">
						<div class="white-box">
							<a href="#" data-toggle="modal" data-target="#tambahjurusan" title="Tambah data Jurusan"><i class="fa fa-plus-circle m-b-10"></i> Tambah Jurusan</a>
							<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>No</th>
											<th>Nama Jurusan</th>
											<th class="text-nowrap">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; ?>
										@foreach($alljurusan as $j)
										<tr>
											<td>{{$no++}}</td>
											<td>
												{{$j->nama_jurusan}}
											</td>
											<td class="text-nowrap">
												<a href="/hapusjurusan/{{$j->id_jurusan}}" onclick="return confirm('Yakin hapus data {{ $j->nama_jurusan }} ?');" title="Hapus"> <i class="fa fa-trash text-inverse fa-fw"></i> </a>
												<a href="#" data-toggle="modal" title="Edit" data-target="#editjurusan{{$j->id_jurusan}}"> <i class="fa fa-pencil text-inverse"></i> </a>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- end data-->
<!-- tambah -->
<div id="tambahjurusan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Tambah Jurusan</h4> </div>
				<div class="modal-body">
					<div class="white-box">
						<form action="/tambahjurusan" enctype="multipart/form-data" method="post">
							{{ csrf_field() }}
							<div class="row">
								<div class="form-group col-sm-12">
									Tambah Jurusan
									<input type="text" name="namajurusan" class="form-control" placeholder="Tambah jurusan baru" required>
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

<!-- end tambah-->
<!-- edit -->
@foreach($alljurusan as $j)
<div id="editjurusan{{$j->id_jurusan}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Edit Jurusan</h4> </div>
				<div class="modal-body">
					<div class="white-box">
						<form action="/editjurusan" enctype="multipart/form-data" method="post">
							{{ csrf_field() }}
							<div class="row">
								<div class="form-group col-sm-12">
									Edit Jurusan
									<input type="hidden" name="id" value="{{$j->id_jurusan}}">
									<input type="text" name="namajurusan" class="form-control" placeholder="Tambah jurusan baru" required value="{{$j->nama_jurusan}}">
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
@endforeach
<!-- end edit-->
<!-- tambah alumni -->
<div id="tambahalumni" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Tambah Alumni</h4> </div>
				<div class="modal-body">
					<div class="white-box">
						<form action="/tambahalumni" enctype="multipart/form-data" method="post">
							{{ csrf_field() }}
							<div class="row">
								<div class="form-group col-sm-12">
									<label for="nisn">Nisn</label>
									<input type="text" name="nisn" class="form-control" placeholder="Nisn" required>
								</div>
								<div class="form-group col-sm-12">
									<label for="namalengkap">Nama Lengkap</label>
									<input type="text" name="namalengkap" class="form-control" placeholder="Nama Lengkap" required>
								</div>
								<div class="form-group col-sm-12">
									<label for="email">Email</label>
									<input type="text" name="email" class="form-control" placeholder="Email@contoh.com" required>
								</div>
								<div class="form-group col-sm-12">
									<label for="tahunlulus">Tahun lulus</label>
									<input type="text" name="tahunlulus" class="form-control" placeholder="Lulusan (contoh:2020)" required>
								</div>
								<div class="form-group col-sm-12">
									<label for="jurusan">Jurusan :</label>
									<select class="form-control" name="jurusan" >
										<option value="0">Pilih Jurusan</option>
										@foreach ($alljurusan as $j)
										<option value="{{$j->id_jurusan}}">{{$j->nama_jurusan}}</option>
										@endforeach
									</select>
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

<!-- end tambah-->
@endsection
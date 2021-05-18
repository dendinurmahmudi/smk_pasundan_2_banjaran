@extends('master')
@section('judul','Tambah Informasi')
@section('class','ti-bell fa-fw')
@section('label','Tambah Informasi')
@extends('Hubin/sidebar')
@section('konten')
<!--  -->
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
@if (Session::has('hapus'))
<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	{{ Session::get('hapus') }}
</div>
@endif
<a href="#" data-toggle="modal" data-target="#myModal" title="Tambah" class="btn btn-success">+ Tambah Informasi</a>
<?php $no=1;$no2=1; ?>
@foreach($info as $i)
<div class="row m-t-15">
	<div class="col-md-12">
		<div class="white-box">
			<div class="pull-right" id="table">
				<!-- <a href="hapusinformasi/{{$i->id}}" data-toggle="tooltip" title="Hapus" onclick="return confirm('Yakin hapus informasi {{ $i->judul }} ?');"> <i class="fa fa-trash text-inverse m-l-20"></i> </a> -->
				<a href="#" class="fa fa-trash text-inverse" data-toggle="modal" id="btndltnotif" data-id="{{$i->id}}" data-name="{{$i->judul}}" title="Hapus informasi {{$i->judul}}"></a>
				<a href="#" data-toggle="modal" data-target="#edit{{ $i->id }}" title="Edit"> <i class="fa fa-pencil text-inverse m-l-20"></i> 
				</a>
				@if($i->buka_apply=='Y')
				<i title="Apply lamaran dibuka" class="fa fa-check text-inverse m-l-20"></i> 
				@else
				<i title="Apply lamaran ditutup" class="fa fa-close text-inverse m-l-20"></i>
				@endif
			</div>
			<h3 class="box-title">{{ $i->judul }}</h3>
			{{ $i->created_at }}
			<div class="row">
				<div class="col-sm-3"><img src="{{ asset('data_file/informasi/'.$i->foto ) }}" class="img-responsive m-t-20" /></div>

				<div class="col-sm-9" id="slimtest{{$no++}}">
					{{ $i->isi }}
				</div>
			</div>

		</div>
	</div>
</div>

<script type="text/javascript">

	$('#slimtest{{$no2++}}').slimScroll({
		height: '250px'
	});
</script>
@endforeach

@foreach($info as $i)

<div id="edit{{ $i->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<script type="text/javascript" charset="utf-8" async defer>
		console.log('{{ $i->id }}');
	</script>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Edit Informasi</h4> </div>
				<div class="modal-body">
					<div class="white-box">
						<form action="editinformasi" enctype="multipart/form-data" method="post">
							{{ csrf_field() }}
							<div class="row">
								<div class="form-group col-sm-12">
									<input type="hidden" name="id" value="{{ $i->id }}">
									<label for="judul">Judul :</label>
									<input type="text" class="form-control" id="judul" name="judul" value="{{ $i->judul }}" placeholder="Judul">
								</div>
								<div class="form-group col-sm-12">
									<div class="form-group">
										<label>Isi :</label>
										<textarea class="textarea_editor form-control" rows="8" placeholder="Masukan teks ..." name="isi">{{ $i->isi }}</textarea>
										<label class="m-t-10">Gambar :</label>

										<input type="file" id="input-file-now" name="file" class="dropify" data-default-file="{{ asset('data_file/informasi/'.$i->foto ) }}"/>
									</div>
									<div class="form-group">
										<label for="exampleInputEmail1">Buka apply lamaran :</label>
										<input type="radio" name="buka_lamaran" id="radio" value="Y" <?php if ($i->buka_apply == 'Y')  echo "checked"; ?>>
										<label for="radio"> Ya </label>
|
										<input type="radio" name="buka_lamaran" id="radio2" value="T" <?php if ($i->buka_apply == 'T')  echo "checked"; ?>>
										<label for="radio2"> Tidak </label>
									</div>
								</div>
								<div class="col-sm-12 col-xs-12">
									<button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Kirim</button>
								</form>
								<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endforeach
	
	<!--  -->

	<!-- sample modal content -->
	<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModalLabel">Tambah Informasi</h4> </div>
					<div class="modal-body">
						<div class="white-box">
							<form action="tambahinformasi" enctype="multipart/form-data" method="post">
								{{ csrf_field() }}
								<div class="row">
									<div class="form-group col-sm-12">

										<label for="judul">Judul :</label>
										<input type="text" class="form-control" id="judul" name="judul" value="" placeholder="Judul">
									</div>
									<div class="form-group col-sm-12">
										<div class="form-group">
											<label>Isi :</label>
											<textarea class="textarea_editor form-control" rows="8" placeholder="Masukan teks ..." name="isi"></textarea>
											<label class="m-t-10">Gambar :</label>

											<input type="file" id="input-file-now" name="file" class="dropify"/>
										</div>
										<div class="form-group">
											<label for="exampleInputEmail1">Buka apply lamaran :</label>
											<input type="radio" name="buka_lamaran" id="radio3" value="Y">
											<label for="radio3"> Ya </label>
|
											<input type="radio" name="buka_lamaran" id="radio4" value="T">
											<label for="radio4"> Tidak </label>
										</div>
									</div>
									<div class="col-sm-12 col-xs-12">
										<button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Kirim</button>
									</form>
									<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				</div>
					</div>
				<!-- /.modal-dialog -->
				<!-- /.modal -->
				<script type="text/javascript">
					$('#table').on('click', '#btndltnotif', function() {
						const id = $(this).data('id');
						var nama = $(this).data('name');
						swal({
							title: 'Apakah anda yakin?',
							text: "Data informasi "+nama+" akan di hapus!",
							type: 'warning',
							showCancelButton: true,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							cancelButtonText: 'Batal',
							confirmButtonText: 'Ya, Hapus!'
						}, function(isConfirm) {
							if (isConfirm) {
								window.location.href = 'hapusinformasi/'+id;

							}
						});
					});
				</script>
				@endsection
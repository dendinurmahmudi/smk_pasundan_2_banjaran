@extends('master')
@section('judul','Beranda Admin')
@section('class','fa fa-dashboard fa-fw')
@section('label','Dashboard')
@extends('Admin/sidebar')
@section('konten')
<div class="row">
	<div class="col-sm-12">
		<div class="col-lg-3">
			<a href="/datajurusan" title="">
				<div class="white-box">
					<h3 class="box-title">Data Alumni</h3>
					<ul class="list-inline two-part">
						<li><i class="icon-people text-info"></i></li>
						<li class="text-right"><span class="counter">{{count($alumni)}}</span></li>
					</ul>
				</div>
			</a>
		</div>
		<div class="col-lg-3">
			<a href="/datpengguna" title="">
				<div class="white-box">
					<h3 class="box-title">Data Pengguna</h3>
					<ul class="list-inline two-part">
						<li><i class="icon-user text-purple"></i></li>
						<li class="text-right"><span class="counter">{{count($user)}}</span></li>
					</ul>
				</div>
			</a>
		</div>
		<div class="col-lg-3">
			<a href="/datpenelusuran" title="">
				<div class="white-box">
					<h3 class="box-title">Data Penelusuran</h3>
					<ul class="list-inline two-part">
						<li><i class="icon-book-open text-danger"></i></li>
						<?php $mengisi = count($penelusuran) - count($tidakisi); ?>
						<li class="text-right"><span class="">{{$mengisi}}</span></li>
					</ul>
				</div>
			</a>
		</div>
		<div class="col-lg-3">
			<a href="/datperusahaan" title="">
				<div class="white-box">
					<h3 class="box-title">Data Perusahaan</h3>
					<ul class="list-inline two-part">
						<li><i class="fa fa-building-o text-success"></i></li>
						<li class="text-right"><span class="">{{count($perusahaan)}}</span></li>
					</ul>
				</div>
			</a>
		</div>
		<!-- pengguna -->
		<div class="col-sm-12">
		@if (Session::has('success'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			{{ Session::get('success') }}
		</div>
		@endif
			<div class="white-box">
				<p class="text-muted m-b-30">Data pengguna yang menunggu verifikasi</p>
				<div class="table-responsive" id="table">
					<table id="example23" class="display nowrap" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>No</th>
								<th>Nisn</th>
								<th>Nama</th>
								<th>Email</th>
								<th>Jurusan</th>
								<th>Lulusan</th>
								<th>Akses</th>
								<th>Status</th>
								<th class="text-nowrap" width="50px">Pilihan</th>
							</tr>
						</thead>
						<tbody>
							<?php $no=1; ?>
							@foreach($pengguna as $a)
							<tr>
								<td>{{ $no++ }}</td>
								<td>{{ $a->nisn }}</td>
								<td>{{ $a->name }}</td>
								<td>{{ $a->email }}</td>
								<td>{{ $a->nama_jurusan }}</td>
								<td>{{ $a->tahun_lulus }}</td>
								@if($a->hak_akses == 1)
								<td>Alumni</td>
								@elseif($a->hak_akses == 2)
								<td>Wks. Hubin</td>
								@elseif($a->hak_akses == 3)
								<td>Kepala sekolah</td>
								@else
								<td>Admin</td>
								@endif
								@if($a->status_aktif == 1)
								<td><i class="fa fa-check text-success"></i> Aktif</td>
								@else
								<td><i class="fa fa-close text-danger"></i> Menunggu verifikasi</td>
								@endif
								<td class="text-nowrap">
									<!-- <a href="/hapusdatap/{{$a->nisn}}" data-toggle="tooltip" title="Hapus data {{$a->name}}" onclick="return confirm('Yakin hapus data {{ $a->name }} ?');"> <i class="fa fa-trash text-inverse m-l-15"></i> </a>  -->
									 <a href="#" class="fa fa-trash text-inverse" data-toggle="modal" id="btndltnotif" data-id="{{$a->nisn}}" data-name="{{$a->name}}" title="Hapus data {{$a->name}}"></a>
									<a href="/verifikasi/{{$a->id}}" title="Verifikasi data {{$a->name}}"> <i class="fa fa-check text-inverse m-l-15"></i> </a> 
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

<script src="{{ asset('assets/templates/plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>

<script>
	 $('#table').on('click', '#btndltnotif', function() {
            const id = $(this).data('id');
            var nama = $(this).data('name');
            swal({
                title: 'Apakah anda yakin?',
                text: "Data "+nama+" akan di hapus!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Hapus!',
                closeOnConfirm: false 
            }, function(isConfirm) {
                if (isConfirm) {
                    window.location.href = '/hapusdatap/'+id;
                    swal("Terhapus!", "Data "+nama+" berhasil dihapus.", "success");
                }
            });
        });

	$(document).ready(function() {
		$('#myTable').DataTable();
		$(document).ready(function() {
			var table = $('#example').DataTable({
				"columnDefs": [{
					"visible": false,
					"targets": 2
				}],
				"order": [
				[2, 'asc']
				],
				"displayLength": 25,
				"drawCallback": function(settings) {
					var api = this.api();
					var rows = api.rows({
						page: 'current'
					}).nodes();
					var last = null;
					api.column(2, {
						page: 'current'
					}).data().each(function(group, i) {
						if (last !== group) {
							$(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
							last = group;
						}
					});
				}
			});
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
            	var currentOrder = table.order()[0];
            	if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
            		table.order([2, 'desc']).draw();
            	} else {
            		table.order([2, 'asc']).draw();
            	}
            });
        });
	});
	$('#example23').DataTable({
		dom: 'Bfrtip',
		buttons: [
		'excel', 'pdf', 'print'
		]
	});
</script>
<!--  -->
@foreach($pengguna as $p)
<div id="edit{{ $p->nisn }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
				<h4 class="modal-title" id="myModalLabel">{{$p->name}}</h4> </div>
				<div class="modal-body">
					<div class="white-box">
						<form action="editpengguna" enctype="multipart/form-data" method="post">
							{{ csrf_field() }}
							<div class="row">
								<div class="form-group col-sm-12">
									<p>Join Tanggal : {{$p->created_at}}</p>
									<label for="nisn">Nisn</label>
									<input class="form-control" type="text" name="nisn" value="{{$p->nisn}}" readonly>
								</div>
								<div class="form-group col-sm-12">
									<label for="name">Nama</label>
									<input class="form-control" type="text" name="nama" value="{{$p->name}}" readonly>
								</div>
								<div class="form-group col-sm-6">
									<label for="jurusan">Jurusan</label>
									<input class="form-control" type="text" name="jurusan" value="{{$p->nama_jurusan}}" readonly>
								</div>
								<div class="form-group col-sm-6">
									<label for="lulusan">Lulusan</label>
									<input class="form-control" type="text" name="lulusan" value="{{$p->tahun_lulus}}" readonly>
								</div>
								<div class="form-group col-sm-12">
									<label for="email">Email</label>
									<input class="form-control" type="text" name="email" value="{{$p->email}}" readonly>
								</div>
								<div class="form-group col-sm-12">
									<input type="hidden" name="id" value="{{ $p->id }}">
									Hak akses <select class="form-control" name="hak_akses" required>
										<?php 
										if($p->hak_akses == 1){
											$akses='Alumni';
										}
										elseif($p->hak_akses == 2){
											$akses='Wks. Hubin';
										}
										elseif($p->hak_akses == 3){
											$akses='Kepala sekolah';
										}
										else{
											$akses='Admin';
										}
										?>
										<option value="{{$p->hak_akses}}">{{$akses}}</option>
										<?php for ($i=1; $i <5 ; $i++) { 
											if($i == 1){
												$akses='Alumni';
											}
											elseif($i == 2){
												$akses='Wks. Hubin';
											}
											elseif($i == 3){
												$akses='Kepala sekolah';
											}
											else{
												$akses='Admin';
											}   ?>
											<option value="{{$i}}">{{$akses}}</option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group col-sm-12">
									Status <select class="form-control" name="status" required>
										<?php 
										if ($p->status_aktif==1) {
											$status = 'Aktif';
										}
										else{
											$status = 'Non-Aktif';
										} ?>
										<option value="{{$p->status_aktif}}">{{$status}}</option>
										<?php for ($i=1; $i <3 ; $i++) { 
											if($i == 1){
												$status='Aktif';
											}
											else{
												$status='Non-Aktif';
											}   ?>
											<option value="{{$i}}">{{$status}}</option>
										<?php } ?>
									</select>

								</div>
								<div class="col-sm-12 col-xs-12">
									<button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
								</form>
								<button type="button" class="btn btn-info waves-effect waves-light m-r-10">Reset password</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endforeach
	@endsection
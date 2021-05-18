@extends('master')
@section('judul','Data alumni')
@section('class','icon-people fa-fw')
@section('label','Data alumni')
@extends('Admin/sidebar')
@section('konten')
@if (Session::has('success'))
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	{{ Session::get('success') }}
</div>
@endif
<div class="col-sm-12">
	<div class="white-box">
		<div class="row">
			<form method="POST" action="/alumniBy_tahun">
				{{ csrf_field() }}
				<div class="col-sm-7">
					<p class="text-muted m-b-30">Export data ke Excel, PDF & Print</p>
				</div>
				<div class="form-group" style="margin-bottom: 50px">
					<div class="col-sm-3">
						<select class="form-control" id="lulusan" name="lulusan">
							<option value="0">Pilih tahun lulus</option>
							@foreach($lulusan as $l)
							@if($l->tahun_lulus==null)
							<option value="{{$l->tahun_lulus}}">Belum diatur</option>
							@else
							<option value="{{$l->tahun_lulus}}">{{$l->tahun_lulus}}</option>
							@endif
							@endforeach
							@foreach($jrsn as $a)
							<input type="hidden" name="jrsn" value="{{$a->nama_jurusan}}">
							@endforeach
						</select>
					</div>
					<div class="col-sm-2">
						<button type="submit" class="btn btn-block btn-info">Tampilkan</button>
					</div>
				</div>
			</form>
		</div>
		<div class="table-responsive" id="table">
			<table id="example23" class="display nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Nisn</th>
						<th>Nama</th>
						<th>Email</th>
						<th>No Hp</th>
						<th>Jurusan</th>
						<th>Tahun lulus</th>
						<th class="text-nowrap" width="50px">Pilihan</th>
					</tr>
				</thead>
				<tbody>
					<?php $no=1; ?>
					@foreach($alumni as $a)
					<tr>
						<td>{{ $no++ }}</td>
						<td>{{ $a->nisn }}</td>
						<td>{{ $a->name }}</td>
						<td>{{ $a->email }}</td>
						@if($a->no_hp == null)
						<td align="center" title="Belum diatur"><i class="fa fa-minus text-danger"></i></td>
						@else
						<td align="center">{{ $a->no_hp }}</td>
						@endif
						@if($a->id_jurusan == '6')
						<td  align="center" title="Belum diatur"><i class="fa fa-minus text-danger"></i></td>
						@else
						<td>{{ $a->nama_jurusan }}</td>
						@endif
						@if($a->tahun_lulus == null)
						<td align="center" title="Belum diatur"><i class="fa fa-minus text-danger"></i></td>
						@else
						<td align="center" >{{ $a->tahun_lulus }}</td>
						@endif
						<td class="text-nowrap">
							<!-- <a href="/hapusdata/{{$a->nisn}}/{{$a->nama_jurusan}}" data-toggle="tooltip" title="Hapus data {{$a->name}}" onclick="return confirm('Yakin hapus data {{ $a->name }} ?');"> <i class="fa fa-trash text-inverse"></i> </a>  -->
							<a href="#" class="fa fa-trash text-inverse" data-toggle="modal" id="btndltnotif" data-id="{{$a->nisn}}" data-name="{{$a->name}}" data-jurusan="{{$a->nama_jurusan}}" title="Hapus data {{$a->name}}"></a>
							<a href="#" data-toggle="modal" data-target="#edit{{$a->id}}" title="Edit data {{$a->name}}"> <i class="fa fa-pencil text-inverse m-l-15"></i> </a> 
							<a href="#" data-toggle="modal" title="Lihat data {{$a->name}}" data-target="#lihatdata{{$a->id}}"> <i class="fa fa-eye text-inverse m-l-15"></i> </a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

<script src="{{ asset('assets/templates/plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
<!-- start - This is for export functionality only -->
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
<script type="text/javascript">
	$('#table').on('click', '#btndltnotif', function() {
            const id = $(this).data('id');
            var nama = $(this).data('name');
            var jur = $(this).data('jurusan');
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
                    window.location.href = '/hapusdata/'+id+'/'+jur;
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
<!-- lihat -->
@foreach($alumni as $a)
<div class="modal fade bs-example-modal-lg" id="lihatdata{{$a->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myLargeModalLabel">{{ $a->name }}</h4> </div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-5">
							<div class="white-box">                        
								<img width="100%" alt="user" src="{{ asset('data_file/profile/'.$a->foto)}}">
							</div>
						</div>
						<div class="col-sm-7">
							<div class="white-box">                        
								<table>
									<thead>
										<tr>
											<th width="60"></th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Nisn </td>
											<td>:  {{$a->nisn}}</td>
										</tr>
										<tr>
											<td>Nama </td>
											<td>:  {{$a->name}}</td>
										</tr>
										<tr>
											<td>Jenis K </td>
											@if($a->jenis_kelamin==null)
											<td class="text-danger">:  Belum diatur</td>
											@elseif($a->jenis_kelamin=='L')
											<td>:  Laki-laki</td>
											@else
											<td>:  Perempuan</td>
											@endif
										</tr>
										<tr>
											<td>Email </td>
											<td>:  {{$a->email}}</td>
										</tr>
										<tr>
											<td>No Hp </td>
											@if($a->no_hp==null)
											<td class="text-danger">:  Belum diatur</td>
											@else
											<td>:  {{$a->no_hp}}</td>
											@endif
										</tr>
										<tr>
											<td>Alamat </td>
											@if($a->alamat==null)
											<td class="text-danger">:  Belum diatur</td>
											@else
											<td>: {{$a->alamat}}</td>
											@endif
										</tr>
										<tr>
											<td>Jurusan </td>
											@if($a->nama_jurusan=='Belum diatur')
											<td class="text-danger">:  Belum diatur</td>
											@else
											<td>: {{$a->nama_jurusan}}</td>
											@endif
										</tr>
										<tr>
											<td>Lulusan </td>
											@if($a->tahun_lulus==null)
											<td class="text-danger">:  Belum diatur</td>
											@else
											<td>: {{$a->tahun_lulus}}</td>
											@endif
										</tr>
										<tr>
											<td>Lamaran </td>
											@if($a->file_lamaran==null)
											<td class="text-danger">:  Belum upload lamaran</td>
											@else
											<td>: {{$a->file_lamaran}}</td>
											@endif
										</tr>
										@if($a->nama_perusahaan == null && $a->nama_kampus == null && $a->pencaker == null)
										<tr>
											<td>

											</td>
											<td>
												<i class="text-danger">( Belum isi data penelusuran )</i>
											</td>
										</tr>
										@endif
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--  -->
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	@endforeach
	<!-- edit -->
	@foreach($alumni as $a)
	<div id="edit{{ $a->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModalLabel">Edit Alumni</h4> </div>
					<div class="modal-body">
						<div class="white-box">
							<form action="/editalumni1/{{$a->nama_jurusan}}" enctype="multipart/form-data" method="post">
								{{ csrf_field() }}
								<div class="row">
									<div class="form-group col-sm-12">
										<input type="hidden" name="nisn" value="{{ $a->nisn }}">
										<label for="nama">Nama :</label>
										<input type="text" class="form-control" id="nama" name="nama" value="{{ $a->name }}" disabled="true">

										<label class="m-t-5" for="email">Email :</label>
										<input type="text" class="form-control" id="email" name="email" value="{{ $a->email }}" disabled="true">

										<label class="m-t-5" for="nohp">No Hp :</label>
										<input type="text" class="form-control" id="nohp" name="nohp" value="{{ $a->no_hp }}" >

										<label for="exampleInputEmail1">Jurusan :</label>
										<select class="form-control" name="jurusan" >
											<option value="{{$a->id_jurusan}}">{{$a->nama_jurusan}}</option>
											@foreach ($jurusan as $j)
											<option value="{{$j->id_jurusan}}">{{$j->nama_jurusan}}</option>
											@endforeach
										</select>

										<label class="m-t-5" for="tahun_lulus">Tahun lulus :</label>
										<input type="text" class="form-control" id="tahun_lulus" name="tahun_lulus" value="{{ $a->tahun_lulus }}">
									</div>
									<div class="col-sm-12 col-xs-12">
										<button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
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

				@endsection

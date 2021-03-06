@extends('master')
@section('judul','Data perusahaan')
@section('class','fa fa-building-o fa-fw')
@section('label','Data perusahaan')
@extends('Alumni/sidebar')
@section('konten')
<div class="col-sm-12">
	<div class="white-box">
		<p class="text-muted m-b-30">Daftar perusahaan yang merekrut pekerja dari lulusan SMK Paundan 2 Banjaran untuk rekomendasi melamar pekerjaan ke perusahaan tersebut.</p>
		<div class="table-responsive">
			<table id="example23" class="display nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Perusahaan</th>
						<th>Alumni bekerja</th>
						<th>Sesuai kompetensi</th>
						<th>Merasa puas</th>
					</tr>
				</thead>
				<tbody>
					<?php $no=1;
					?>
					@foreach($perusahaan as $p)
					<tr>
						@if($p->nama_perusahaan==null)

						@else
						<td>{{ $no++ }}</td>
						<td>{{ $p->nama_perusahaan }}</td>
						<td>{{ $p->jumlah }}</td>
						<td>{{ $p->kesesuaian }}</td>
						<td>{{ $p->kepuasan }}</td>
						@endif

					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

<script src="{{ asset('assets/templates/plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
<!-- start - This is for export functionality only -->

<script>
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
		's'
		]
	});
</script>
@endsection
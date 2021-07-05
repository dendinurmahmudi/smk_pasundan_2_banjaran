@extends('master')
@section('judul','Proses Algoritma')
@section('class','fa fa-building-o fa-fw')
@section('label','Proses Algoritma')
@extends('Hubin/sidebar')
@section('konten')
<div class="col-sm-12">
	<div class="white-box">
		<div class="table-responsive">
			1. Penyiapan Data set
			<table class="example23 table table-striped display nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Jurusan</th>
						<th>Bekerja</th>
						<th>Lulusan</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$no = 1;
					?>
					@foreach($dataset as $d)
					<tr>
						<td>{{$no++}}</td>
						<td>{{$d->name}}</td>
						<td>{{$d->nama_jurusan}}</td>
						<td>{{$d->nama_perusahaan}}</td>
						<td>{{$d->tahun_lulus}}</td>
						@endforeach
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="col-sm-12">
	<div class="white-box">
		<div class="table-responsive">
			2. Pencarian Frequent Itemset
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Tahun</th>
						@foreach($allperu1 as $a)
						<th>{{$a->nama_perusahaan}}</th>
						@endforeach
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>2018</b></td>
						@foreach($fp2018 as $fp)
						<td>{{$fp['jumlah']}}</td>
						@endforeach
					</tr>
					<tr>
						<td><b>2019</b></td>
						@foreach($fp2019 as $fp)
						<td>{{$fp['jumlah']}}</td>
						@endforeach
					</tr>
					<tr>
						<td><b>2020</b></td>
						@foreach($fp2020 as $fp)
						<td>{{$fp['jumlah']}}</td>
						@endforeach
					</tr>
					<tr bgcolor="yellow">
						<td><b>Frekuensi</b></td>
						@foreach($fp2020 as $fp)
						<td>{{$fp['total']}}</td>
						@endforeach
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="col-sm-12">
	<div class="white-box">
		<div class="table-responsive">
			3. * Data set diurutkan berdasar priority
			<table class="example23 table table-striped display nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Perusahaan</th>
						<th>Frekuensi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$no = 1;
					?>
					@foreach($allperu as $d)
					<tr>
						<td>{{$no++}}</td>
						<td>{{$d->nama_perusahaan}}</td>
						<td>{{$d->jumlah}}</td>
						@endforeach
					</tr>
				</tbody>
			</table>
		</div>

		<div class="table-responsive m-t-30">
			* Urutkan data perusahaan berdasar priority pertahun
			<table class="table table-striped">
				<thead>
					<tr>
						
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>2018</b></td>
						@foreach($hslfp2018 as $fp)
						@if($fp['jumlah'] != 0)
						<td>{{$fp['nama_perusahaan']}} : {{$fp['jumlah']}}</td>
						@endif
						@endforeach
					</tr>
					<tr>
						<td><b>2019</b></td>
						@foreach($hslfp2019 as $fp)
						@if($fp['jumlah'] != 0)
						<td>{{$fp['nama_perusahaan']}} : {{$fp['jumlah']}}</td>
						@endif
						@endforeach
					</tr>
					<tr>
						<td><b>2020</b></td>
						@foreach($hslfp2020 as $fp)
						@if($fp['jumlah'] != 0)
						<td>{{$fp['nama_perusahaan']}} : {{$fp['jumlah']}}</td>
						@endif
						@endforeach
					</tr>
					
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="col-sm-12">
	<div class="white-box">
		<div class="table-responsive">
			4. Dataset berdasar minimum suport
			<table class="example23 table table-striped display nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Perusahaan</th>
						<th>Frekuensi</th>
						<th>Suport</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$no = 1;
					?>
					@foreach($hasil as $d)
					<tr>
						<td>{{$no++}}</td>
						<td>{{$d['nama_perusahaan']}}</td>
						<td>{{$d['jumlah']}}</td>
						<td>{{$d['suport']}}</td>
						@endforeach
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="col-sm-12">
	<div class="white-box">
		5. Fp Tree
		<div id="treeview5" class=""></div>
	</div>
</div>
<div class="col-sm-12">
	<div class="white-box">
		<div class="table-responsive">
			6.	Pembangkitan Conditional Pattern Base
			<table class="example23 table table-striped display nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Perusahaan</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$no = 1;
					?>
					@foreach($hasilasc as $d)
					<tr>
						<td>{{$no++}}</td>
						<td>{{$d['nama_perusahaan']}}</td>
						<td>{{$d['jumlah']}} : {{$d['suport']}}</td>
						@endforeach
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="col-sm-12">
	<div class="white-box">
		<div class="table-responsive">
			7.	Frequent item 2 set
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Frequent 2 item</th>
						<?php
						for ($i=0; $i < count($hasil2d[0])-1; $i++) { 
							echo "<th>".$hasil2d[0][$i]['nama_perusahaanb'];
						}
						?>
					</tr>
				</thead>
				<tbody>
					<?php
					for ($i=0; $i < count($hasil2d[0])-1; $i++) { 
						echo "<tr><td><b>".$hasil2d[0][$i]['nama_perusahaanb'];
						for ($j=0; $j < count($hasil2d[0])-1; $j++) { 
							echo "<td>".$hasil2d[$i][$j]['frekuensi'];
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="col-sm-12">
	<div class="white-box">
		<div class="table-responsive">
			8.	Mencari suport
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Frequent 2 item</th>
						<?php
						for ($i=0; $i < count($hasil2d[0])-1; $i++) { 
							echo "<th>".$hasil2d[0][$i]['nama_perusahaanb'];
						}
						?>
					</tr>
				</thead>
				<tbody>
					<?php
					for ($i=0; $i < count($hasil2d[0])-1; $i++) { 
						echo "<tr><td><b>".$hasil2d[0][$i]['nama_perusahaanb'];
						for ($j=0; $j < count($hasil2d[0])-1; $j++) { 
							echo "<td>".$hasil2d[$i][$j]['frekuensi']/count($jmltahun);
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="col-sm-12">
	<div class="white-box">
		<div class="table-responsive">
			9.	Mencari confidence
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Frequent 2 item</th>
						<?php
						for ($i=0; $i < count($hasil2d[0])-1; $i++) { 
							echo "<th>".$hasil2d[0][$i]['nama_perusahaanb'];
						}
						?>
					</tr>
				</thead>
				<tbody>
					<?php
					for ($i=0; $i < count($hasil2d[0])-1; $i++) { 
						echo "<tr><td><b>".$hasil2d[0][$i]['nama_perusahaanb'];
						for ($j=0; $j < count($hasil2d[0])-1; $j++) { 
							echo "<td>".$hasil2d[$i][$j]['frekuensi']/$hasil2d[$i][$j]['confidence'];
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="col-sm-12">
	<div class="white-box">
		<div class="table-responsive">
			10.	Hasil
			<table class="table table-striped display nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Untuk 3 data terdapat 1 data yang confidance, yaitu : </th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>@foreach($hslallperu as $d)
						<b>{{$d->nama_perusahaan}},</b>
						@endforeach</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script src="{{ asset('assets/templates/plugins/bower_components/bootstrap-treeview-master/dist/bootstrap-treeview.min.js') }}">    
</script>

<script src="{{ asset('assets/templates/plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
<!-- start - This is for export functionality only -->
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script>
	$(document).ready(function() {
		$('.myTable').DataTable();
		$(document).ready(function() {
			var table = $('.example').DataTable({
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
            $('.example tbody').on('click', 'tr.group', function() {
            	var currentOrder = table.order()[0];
            	if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
            		table.order([2, 'desc']).draw();
            	} else {
            		table.order([2, 'asc']).draw();
            	}
            });
        });
	});
	$('.example23').DataTable({
		dom: 'Bfrtip',
		buttons: [

		]
	});
	$(function() {
		var defaultData = [
		{
			text: 'NULL',
			href: '#null',
			tags: ['0'],
			nodes: [

			// <?php 
			// foreach ($hslfp2018 as $p18) {
			// 	if ($p18['jumlah'] !=0) {
			// 	echo "{text: '".$p18['nama_perusahaan']." : ".$p18['jumlah']."',";
			// 	echo "href: '#".$p18['nama_perusahaan']."',";
			// 	echo "tags: ['".$p18['jumlah']."'],";
			// 	echo "nodes : [";
			// 	}
			// } foreach ($hslfp2018 as $p18) {
			// 	if ($p18['jumlah'] !=0) {
			// 	echo "]},";
			// }
			// }
			// ?>

			// <?php 
			// foreach ($hslfp2019 as $p18) {
			// 	if ($p18['jumlah'] !=0) {
			// 	echo "{text: '".$p18['nama_perusahaan']." : ".$p18['jumlah']."',";
			// 	echo "href: '#".$p18['nama_perusahaan']."',";
			// 	echo "tags: ['".$p18['jumlah']."'],";
			// 	echo "nodes : [";
			// }
			// } foreach ($hslfp2019 as $p18) {
			// 	if ($p18['jumlah'] !=0) {
			// 	echo "]},";
			// }
			// }
			// ?>

			<?php 
			foreach ($hasil as $p18) {
				if ($p18['jumlah'] !=0) {
					echo "{text: '".$p18['nama_perusahaan']." : ".$p18['jumlah']."',";
					echo "href: '#".$p18['nama_perusahaan']."',";
					echo "tags: ['".$p18['jumlah']."'],";
					echo "nodes : [";
				}
			} foreach ($hasil as $p18) {
				if ($p18['jumlah'] !=0) {
					echo "]},";
				}
			}
			?>

			]
		}, 
		];
		$('#treeview5').treeview({
			expandIcon: 'ti-angle-right',
			onhoverColor: "rgba(0, 0, 0, 0.05)",
			selectedBackColor: "#03a9f3",
			collapseIcon: 'ti-angle-down',
			nodeIcon: 'glyphicon glyphicon-bookmark',
			data: defaultData
		});
	});
</script>
@endsection
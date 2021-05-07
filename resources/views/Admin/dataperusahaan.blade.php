@extends('master')
@section('judul','Data perusahaan')
@section('class','fa fa-building-o fa-fw')
@section('label','Data perusahaan')
@extends('Admin/sidebar')
@section('konten')
<div class="col-sm-12">
    <div class="white-box">
        <p class="text-muted m-b-30">Export data ke Excel, PDF & Print</p>
        <div class="table-responsive">
            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>Perusahaan</th>
							<th>Alumni bekerja</th>
							<th>Sesuai kompetensi</th>
							<th>Merasa puas</th>
                            <th>Support</th>
                            <th>Confidance</th>
							<th class="text-nowrap" width="50px">Pilihan</th>
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
                            <td>{{ $p->jumlah/count($jmltahun) }}</td>
                            <?php 
                            foreach ($allprshn as $a) {
                            $thn = $a->tahun_lulus;
                            $nmprshn = $a->nama_perusahaan;
                            if($nmprshn){
                                if ($thn=='2019' && $thn=='2018'){
                                    $jml=2;                                
                                }
                                elseif ($thn=='2018') {
                                    $jml=1;
                                }
                                elseif ($thn=='2019') {
                                    $jml=1;
                                }
                            }
                            }
                             ?>
                            <td>{{ $p->jumlah/$jml }}</td>
							<td class="text-nowrap">
								<a href="#" data-toggle="tooltip" title="Edit"> <i class="fa fa-pencil text-inverse m-l-15"></i> </a> 
								<a href="#" data-toggle="modal" data-target="" title="Lihat data"> <i class="fa fa-eye text-inverse m-l-15"></i> </a>
							</td>
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
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
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
        'excel', 'pdf', 'print'
        ]
    });
</script>
@endsection

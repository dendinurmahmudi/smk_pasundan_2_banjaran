@extends('master')
@section('judul','Apply lamaran')
@section('class','ti-email fa-fw')
@section('label','Apply lamaran')
@extends('Alumni/sidebar')
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
        <div class="table-responsive">
            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Perusahaan</th>
                            <th>Tanggal apply</th>
                            <th class="text-nowrap">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php $no=1;
                       ?>
                       @foreach($berkas as $p)
                       <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $p->untuk_perusahaan }}</td>
                        <td>{{ $p->created_at }}</td>
                        <td class="text-nowrap">
                        	<a href="/hapuslam/{{$p->id}}" data-toggle="tooltip" title="Batalkan lamaran" onclick="return confirm('Yakin batalkan lamaran untuk {{ $p->untuk_perusahaan }} ?');"><i class="fa fa-close text-inverse"></i></a>
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

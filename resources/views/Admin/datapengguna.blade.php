@extends('master')
@section('judul','Data pengguna')
@section('class','icon-people fa-fw')
@section('label','Data pengguna')
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
        <p class="text-muted m-b-30">Export data ke Excel, PDF & Print</p>
        <div class="table-responsive">
            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nisn</th>
                        <th>Nama</th>
                        <th>Email</th>
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
                    <td><i class="fa fa-close text-danger"></i> Non-Aktif</td>
                    @endif
                    <td class="text-nowrap">
                        <a href="/hapusdatap/{{$a->nisn}}" data-toggle="tooltip" title="Hapus data {{$a->name}}" onclick="return confirm('Yakin hapus data {{ $a->name }} ?');"> <i class="fa fa-trash text-inverse m-l-15"></i> </a> 
                        <a href="#" data-toggle="modal" data-target="#edit{{$a->nisn}}" title="Edit data {{$a->name}}"> <i class="fa fa-pencil text-inverse m-l-15"></i> </a> 
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
<!--  -->
@foreach($pengguna as $p)
<div id="edit{{ $p->nisn }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">{{$p->name}}</h4> </div>
                <div class="modal-body">
                    <div class="white-box">
                        <form action="editpengguna" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for="nisn">Nisn</label>
                                    <input class="form-control" type="text" name="nisn" value="{{$p->nisn}}" readonly>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="name">Nama</label>
                                    <input class="form-control" type="text" name="nama" value="{{$p->name}}" readonly>
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
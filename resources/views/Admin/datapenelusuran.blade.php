@extends('master')
@section('judul','Data penelusuran')
@section('class','ti-clipboard fa-fw')
@section('label','Data penelusuran')
@extends('Admin/sidebar')
@section('konten')
<div class="col-sm-12">
    <div class="white-box">
        <div class="row">
            <form method="POST" action="/penelusuranBy_jurusan_tahun1">
                {{ csrf_field() }}
                <div class="col-sm-3">
                    <p class="text-muted m-b-30">Export data ke Excel, PDF & Print</p>
                </div>
                <div class="form-group" style="margin-bottom: 50px">
                    <div class="col-sm-2">
                        <select class="form-control" id="jurusan" name="jurusan">
                            <option value="0">Pilih jurusan</option>
                            @foreach($jurusan as $j)
                            <option value="{{$j->id_jurusan}}">{{$j->nama_jurusan}}</option>
                            @endforeach
                            
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <select class="form-control" id="lulusan" name="lulusan">
                            <option value="0">Pilih tahun lulus</option>
                            @foreach($lulusan as $l)
                            @if($l->tahun_lulus==null)
                            <option value="{{$l->tahun_lulus}}">Belum diatur</option>
                            @else
                            <option value="{{$l->tahun_lulus}}">{{$l->tahun_lulus}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" id="tampilan" name="tampilan">
                            <option value="0">Pilih tampilan data</option>
                            
                            <option value="T">Belum isi data</option>
                            <option value="Y">Sudah isi data</option>
                            
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-block btn-info">Tampilkan</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nisn</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Lulusan</th>
                    <th>Bekerja</th>
                    <th>Kuliah</th>
                    <th>Pencaker</th>
                    <th>Kesesuaian</th>
                    <th>Gaji</th>
                    <th>Kepuasan</th>
                    <th class="text-nowrap">Pilihan</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; ?>
                @foreach ($penelusuran as $p)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $p->nisn }}</td>

                    @if($p->nama_perusahaan==null && $p->nama_kampus==null && $p->pencaker==null)
                    <td class="text-danger" title="Belum isi data penelusuran">{{ $p->name }}</td>
                    @else
                    <td>{{ $p->name }}</td>
                    @endif

                    @if($p->nama_jurusan == 'Belum diatur')
                    <td class="text-danger">Belum diatur</td>
                    @else
                    <td>{{ $p->nama_jurusan }}</td>
                    @endif

                    @if($p->tahun_lulus == null)
                    <td align="center"><a href="#" title="Minta atur">Belum diatur</a></td>
                    @else
                    <td align="center">{{ $p->tahun_lulus }}</td>
                    @endif

                    @if($p->nama_perusahaan == null)
                    <td align="center"><i class="fa fa-minus text-warning fa-fw"></i>T</td>
                    @else
                    <td>{{ $p->nama_perusahaan }}</td>
                    @endif
                    @if($p->nama_kampus == null)
                    <td align="center"><i class="fa fa-minus text-warning fa-fw"></i>T</td>
                    @else
                    <td>{{ $p->nama_kampus }}</td>
                    @endif

                    @if($p->pencaker == 'Y')
                    <td align="center"><i class="fa fa-check text-success fa-fw"></i>Y</td>
                    @elseif($p->pencaker == 'B')
                    <td align="center"><i class="fa fa-close text-danger fa-fw"></i>T</td>
                    @elseif($p->pencaker == 'T')
                    <td align="center"><i class="fa fa-close text-danger fa-fw"></i>T</td>
                    @else
                    <td align="center"><i class="fa fa-minus text-warning fa-fw"></i>T</td>
                    @endif

                    @if($p->sesuai_kompetensi == 'Y')
                    <td align="center"><i class="fa fa-check text-success fa-fw"></i>Y</td>
                    @elseif($p->sesuai_kompetensi == 'B')
                    <td align="center"><i class="fa fa-minus text-warning fa-fw"></i>T</td>
                    @elseif($p->sesuai_kompetensi == 'T')
                    <td align="center"><i class="fa fa-close text-danger fa-fw"></i>T</td>
                    @else
                    <td align="center"><i class="fa fa-minus text-warning fa-fw"></i>T</td>
                    @endif

                    @if($p-> gaji == 'B')
                    <td align="center"><i class="fa fa-minus text-warning fa-fw"></i>T</td>
                    @elseif($p->gaji == null)
                    <td align="center"><i class="fa fa-minus text-warning fa-fw"></i>T</td>
                    @else
                    <td align="center">{{ $p->gaji }}</td>
                    @endif

                    @if($p->kepuasan == 'Y')
                    <td align="center"><i class="fa fa-check text-success fa-fw"></i>Y</td>
                    @elseif($p->kepuasan == 'B')
                    <td align="center"><i class="fa fa-minus text-warning fa-fw"></i>T</td>
                    @elseif($p->kepuasan == 'T')
                    <td align="center"><i class="fa fa-close text-danger fa-fw"></i>T</td>
                    @else
                    <td align="center"><i class="fa fa-minus text-warning fa-fw"></i>T</td>
                    @endif
                    <td align="center">
                        <a href="#" data-toggle="modal" title="Lihat data" data-target="#lihat{{$p->id}}"> <i class="fa fa-eye text-inverse m-l-15"></i> </a>
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
<!-- modal -->
@foreach ($penelusuran as $p)
<div class="modal fade bs-example-modal-lg" id="lihat{{$p->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">{{ $p->name }}</h4> </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="white-box">    
                                <h4>No Hp :</h4> 
                                @if($p->no_hp == null)
                                <p><i>*Belum diatur</i></p>
                                @else
                                <p><input type="text" id="pilih" value="{{$p->no_hp}}" style="border-bottom: none;
                                border-left: none;
                                border-right: none;
                                border-top: none;
                                outline: none;" readonly> <a href="#" class="fa fa-copy" title="salin no hp" onclick="copy_text()"></a></p>
                                @endif
                                <hr>         
                                <h4>Email :</h4>            
                                @if($p->email == null)
                                <p><i>*Belum diatur</i></p>
                                @else
                                <p><input type="text" id="pilih2" value="{{$p->email}}" style="border-bottom: none;
                                border-left: none;
                                border-right: none;
                                border-top: none;
                                outline: none;" readonly> <a href="#" class="fa fa-copy" title="salin email" onclick="copy_text2()"></a></p>
                                @endif
                                <hr>                    
                                <h4>Keterangan :</h4>
                                @if($p->keterangan == null)
                                <p><i>*Tidak ada keterangan</i></p>
                                @else
                                <p>" {{$p->keterangan}} "</p>
                                @endif
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
    <script type="text/javascript">
        function copy_text() {
            document.getElementById("pilih").select();
            document.execCommand("copy");
            alert('Berhasil copy No Hp');
        }
        function copy_text2() {
            document.getElementById("pilih2").select();
            document.execCommand("copy");
            alert('Berhasil copy Email');
        }
    </script>
    @endforeach
    @endsection
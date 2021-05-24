@extends('master')
@section('judul','Beranda Alumni')
@section('class','fa fa-dashboard fa-fw')
@section('label','Dashboard')
@extends('Alumni/sidebar')
@section('konten')
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <div class="row row-in">
                <a href="/informasi" title="{{count($info)}} informasi hari ini">
                    <div class="col-lg-4 col-sm-12 row-in-br">
                        <ul class="col-in">
                            <li>
                                <span class="circle circle-md bg-info"><i class="ti-bell"></i></span>
                            </li>
                            <li class="col-last">
                                <h3 class="counter text-right m-t-15">{{count($info)}}</h3></li>
                                <li class="col-middle">
                                    <h4>Informasi</h4><h5>{{date('d M Y')}}</h5>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </a>
                    <!--  -->
                    @if($penelusuran->nama_perusahaan == null && $penelusuran->nama_kampus == null && $penelusuran->pencaker == null)
                    <a href="/penelusuran" title="Segera isi data penelusuran">
                        <div class="col-lg-4 col-sm-12 row-in-br  b-r-none">
                            <ul class="col-in">
                                <li>
                                    <span class="circle circle-md bg-danger"><i class="ti-close"></i></span>
                                </li>
                                <li class="col-last">
                                    <h3 class="counter text-right m-t-15"><i class="ti-close"></i></h3></li>
                                    <li class="col-middle">
                                        <h4>Data penelusuran</h4>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                <span class="sr-only">40% Complete (success)</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </a>
                        @else
                        <a href="/penelusuran" title="Data penelusuran telah diisi">
                            <div class="col-lg-4 col-sm-12 row-in-br  b-r-none">
                                <ul class="col-in">
                                    <li>
                                        <span class="circle circle-md bg-success"><i class="ti-check"></i></span>
                                    </li>
                                    <li class="col-last">
                                        <h3 class="counter text-right m-t-15"><i class="ti-check"></i></h3></li>
                                        <li class="col-middle">
                                            <h4>Data penelusuran</h4>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                    <span class="sr-only">40% Complete (success)</span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </a>
                            @endif
                            <!--  -->
                            <!--  -->
                            @if($profile->alamat == null || $profile->jenis_kelamin == null || $profile->tahun_lulus == null || $profile->file_lamaran == null)
                            <a href="/profile1" title="Mohon lengkapi data diri anda">
                                <div class="col-lg-4 col-sm-12  b-0">
                                    <ul class="col-in">
                                        <li>
                                            <span class="circle circle-md bg-danger"><i class="ti-close"></i></span>
                                        </li>
                                        <li class="col-last">
                                            <h3 class="counter text-right m-t-15"><i class="ti-close"></i></h3></li>
                                            <li class="col-middle">
                                                <h4>Data diri / profile</h4>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                        <span class="sr-only">40% Complete (success)</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </a>
                                @else
                                <a href="/profile1" title="Data diri telah diisi lengkap">
                                    <div class="col-lg-4 col-sm-12  b-0">
                                        <ul class="col-in">
                                            <li>
                                                <span class="circle circle-md bg-success"><i class="ti-check"></i></span>
                                            </li>
                                            <li class="col-last">
                                                <h3 class="counter text-right m-t-15"><i class="ti-check"></i></h3></li>
                                                <li class="col-middle">
                                                    <h4>Data diri / profile</h4>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                            <span class="sr-only">40% Complete (success)</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </a>
                                    @endif
                                    <!--  -->
                                </div>
                            </div>
                        </div>
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ Session::get('success') }}
                        </div>
                        @endif
                        @if (Session::has('eror'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ Session::get('eror') }}
                        </div>
                        @endif
                        <?php $no=1;$no2=1; ?>
                        @foreach($info as $i)
                        <div class="col-md-12">
                            <div class="white-box">
                                <div align="center">
                                    <i class="ti-bell fa-fw"></i>Informasi Hari ini
                                </div>
                                <div class="pull-right">
                                    @if($i->buka_apply=='Y')
                                    <form action="kirimlamaran" enctype="multipart/form-data" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="file" value="{{$file->file_lamaran}}">
                                        <input type="hidden" name="nisn" value="{{$file->nisn}}">
                                        <input type="hidden" name="judul" value="{{$i->judul}}">
                                        <button type="submit" title="Apply lamaran" class="btn btn-success btn-circle"><i class="fa fa-check"></i></button>
                                    </form>
                                    @endif
                                </div>
                                <h3 class="box-title">{{ $i->judul }}</h3>
                                {{ $i->created_at }}
                                <div class="row">
                                    <div class="col-sm-3"><img src="{{ asset('data_file/informasi/'.$i->foto ) }}" class="img-responsive m-t-20" />
                                    </div>
                                    <div class="col-sm-9" id="slimtest{{$no++}}">
                                        {{ $i->isi }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endforeach
                        <div class="col-sm-12">
                            <div class="white-box">
                                <div align="center" class="m-b-15">    
                                    <i class="fa fa-building-o  fa-fw"></i>Daftar perusahaan yang merekrut pekerja dari lulusan SMK Pasundan 2 Banjaran untuk rekomendasi melamar pekerjaan ke perusahaan tersebut.
                                </div>
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
                    </div>
                    <script src="{{ asset('assets/templates/plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
                    <script type="text/javascript">

                        $('#slimtest{{$no2++}}').slimScroll({
                            height: '250px'
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
                            's'
                            ]
                        });
                    </script>

                    @endsection
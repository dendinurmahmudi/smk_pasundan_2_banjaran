<?php  ?>
@extends('master')
@section('judul','Beranda Hubin')
@section('class','fa fa-dashboard fa-fw')
@section('label','Dashboard')
@extends('Hubin/sidebar')
@section('konten')
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <div class="row row-in">
                <a href="/dataalumni" title="">
                    <div class="col-lg-4 col-sm-12 row-in-br">
                        <ul class="col-in">
                            <li>
                                <span class="circle circle-md bg-info"><i class="ti-clipboard"></i></span>
                            </li>

                            <li class="col-last">
                                <h3 class="counter text-right m-t-15">{{ count($all)}}</h3></li>
                                <li class="col-middle">
                                    <h4>Total Alumni</h4>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                            <span class="sr-only">100% Complete (success)</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </a>
                    <a href="/datapenelusuran" title="">
                        <div class="col-lg-4 col-sm-12 row-in-br  b-r-none">
                            <ul class="col-in">
                                <li>
                                    <span class="circle circle-md bg-success"><i class="ti-check"></i></span>
                                </li>
                                <?php 
                                $mengisi = count($all) - count($tidakisi);
                                $total1 = $mengisi/count($all)*100;
                                ?>
                                <li class="col-last">
                                    <h3 class="counter text-right m-t-15">{{ $mengisi }}</h3></li>
                                    <li class="col-middle">
                                        <h4>Mengisi Data</h4>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{$total1}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$total1}}%">
                                                <span class="sr-only">{{$total1}}% Complete (success)</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </a>
                        <a href="/databelumisi" title="">
                            <div class="col-lg-4 col-sm-12  b-0">
                                <ul class="col-in">
                                    <li>
                                        <span class="circle circle-md bg-danger"><i class="fa fa-close"></i></span>
                                    </li>
                                    <?php 
                                    $total2 = count($tidakisi)/count($all)*100;
                                    ?>
                                    <li class="col-last">
                                        <h3 class="counter text-right m-t-15">{{count($tidakisi)}}</h3></li>
                                        <li class="col-middle">
                                            <h4>Belum Isi</h4>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="{{$total2}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$total2}}%">
                                                    <span class="sr-only">{{$total2}}% Complete (success)</span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="white-box">
                        <h3 class="box-title"><?php echo date('d M Y')?></h3>
                        <div class="row text-center">
                            <?php 
                            $all = count($penelusuran);
                            $bekerja = count($bekerja); 
                            $hitung1 = $bekerja/$all*100;
                            ?>
                            <div class="col-sm-3">
                                <a href="/databekerja" title="">
                                    <div class="chart easy-pie-chart-3" data-percent="{{ $hitung1 }}"> <span class="percent"></span> <br><h5>Alumni yang bekerja</h5></div>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <?php 
                                $all = count($penelusuran);
                                $pencaker = count($pencaker); 
                                $hitung2 = $pencaker/$all*100;
                                ?>
                                <a href="/datapencaker" title="">
                                    <div class="chart easy-pie-chart-4" data-percent="{{ $hitung2 }}"> <span class="percent"></span> <br><h5>Alumni yang belum bekerja</h5></div>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <?php 
                                $all = count($penelusuran);
                                $kuliah = count($kuliah); 
                                $hitung3 = $kuliah/$all*100;
                                ?>
                                <a href="/datakuliah" title="">
                                    <div class="chart easy-pie-chart-5" data-percent="{{ $hitung3 }}"> <span class="percent"></span>  <br><h5>Alumni yang melanjutkan sekolah</h5></div>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <?php 
                                $kesesuaian = count($kesesuaian);
                                $sesuai = count($sesuai); 
                                $hitung = $sesuai/$kesesuaian*100;
                                ?>
                                <a href="/datasesuai" title="">
                                    <div class="chart easy-pie-chart-2" data-percent="{{$hitung}}"> <span class="percent"></span>  <br><h5>kesesuaian jurusan dan pekerjaan</h5></div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- jurusan -->
                <div class="col-sm-12 m-t-10">
                    <div class="white-box">
                        <p class="text-muted m-b-30">Jurusan bekerja</p>
                        <div class="table-responsive">
                            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jurusan</th>
                                        <th>Jumlah bekerja</th>
                                        <th>Jumlah pencaker</th>
                                        <th>Sesuai kompetensi</th>
                                        <th>Tidak sesuai</th>
                                        <th>Merasa puas</th>
                                        <th>Tidak puas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php $no=1;
                                   ?>
                                   @foreach($countjurusan as $p)
                                   <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $p->nama_jurusan }}</td>
                                    <td>{{ $p->jumlah }}</td>
                                    <td>{{ $p->pnckr }}</td>
                                    <td>{{ $p->kesesuaian }}</td>
                                    <td>{{ $p->tdksesuai }}</td>
                                    <td>{{ $p->kepuasan }}</td>
                                    <td>{{ $p->tdkpuas }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 m-b-20">
                <a href="/dashboard"><button class="btn btn-outline btn-info btn-lg btn-block">Informasi Lainya</button></a>
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
                '', '', ''
                ]
            });
        </script>

        @endsection
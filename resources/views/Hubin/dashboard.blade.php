<?php  ?>
@extends('master')
@section('judul','Beranda Hubin')
@section('label','Dashboard')
@extends('Hubin/sidebar')
@section('konten')
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
           <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title">Jumlah alumni tiap jurusan yang bekerja pertahun</h3>
                    <ul class="list-inline text-right">
                        <li>
                            <h5><i class="fa fa-circle m-r-5" style="color: #00bfc7;"></i>Kelistrikan</h5> </li>
                            <li>
                                <h5><i class="fa fa-circle m-r-5" style="color: #fdc006;"></i>Permesinan</h5> </li>
                                <li>
                                    <h5><i class="fa fa-circle m-r-5" style="color: #9675ce;"></i>TKR</h5> </li>
                                    <li>
                                        <h5><i class="fa fa-circle m-r-5" style="color: #ff0000;"></i>TKJ</h5> </li>
                                        <li>
                                            <h5><i class="fa fa-circle m-r-5" style="color: #00f508;"></i>TBSM</h5> </li>
                                        </ul>
                                        <div id="morris-area-chart"></div>
                                    </div>
                                </div>

                            </div> 
                        </div>
                    </div>    
                </div>
                <!--  -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-md-5 control-label">
                                    <h2 class="box-title m-b-0">Persentase Kompetensi Kerja Lulusan</h2>
                                </label>

                            </div>
                            <br>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th colspan="3" class="text-center">Jurusan Kelistrikan</th>
                                            <th></th>
                                            <th colspan="3" class="text-center">Jurusan Permesinan</th>
                                            <th></th>
                                            <th colspan="3" class="text-center">Jurusan TKJ</th>
                                            <th></th>
                                            <th colspan="3" class="text-center">Jurusan TKR</th>
                                            <th></th>
                                            <th colspan="3" class="text-center">Jurusan TBSM</th>
                                            <th></th>
                                        </tr>

                                        <tr>
                                            <th>Tahun</th>
                                            <th class="text-center">Telah Bekerja</th>
                                            <th class="text-center">Sesuai Linear Kompetensi</th>
                                            <th class="text-center">Belum mengisi Data</th>

                                            <th></th>

                                            <th class="text-center">Telah Bekerja</th>
                                            <th class="text-center">Sesuai Linear Kompetensi</th>
                                            <th class="text-center">Belum mengisi Data</th>

                                            <th></th>

                                            <th class="text-center">Telah Bekerja</th>
                                            <th class="text-center">Sesuai Linear Kompetensi</th>
                                            <th class="text-center">Belum mengisi Data</th>

                                            <th></th>

                                            <th class="text-center">Telah Bekerja</th>
                                            <th class="text-center">Sesuai Linear Kompetensi</th>
                                            <th class="text-center">Belum mengisi Data</th>

                                            <th></th>

                                            <th class="text-center">Telah Bekerja</th>
                                            <th class="text-center">Sesuai Linear Kompetensi</th>
                                            <th class="text-center">Belum mengisi Data</th>

                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kelistrikan as $k)
                                        <tr>
                                            <td>{{$k->tahun_lulus}}</td>
                                            <td class="text-center">{{$k->jumlah}}</td>
                                            <td class="text-center">{{$k->kesesuaian}}</td>
                                            <td class="text-center">{{$k->kosong}}</td>
                                            
                                            <th></th>
                                            
                                            <td class="text-center">{{$k->jumlah}}</td>
                                            <td class="text-center">{{$k->kesesuaian}}</td>
                                            <td class="text-center">{{$k->kosong}}</td>
                                            
                                            <th></th>
                                            
                                            <td class="text-center">{{$k->jumlah}}</td>
                                            <td class="text-center">{{$k->kesesuaian}}</td>
                                            <td class="text-center">{{$k->kosong}}</td>
                                            
                                            <th></th>
                                            
                                            <td class="text-center">{{$k->jumlah}}</td>
                                            <td class="text-center">{{$k->kesesuaian}}</td>
                                            <td class="text-center">{{$k->kosong}}</td>
                                            
                                            <th></th>
                                            
                                            <td class="text-center">{{$k->jumlah}}</td>
                                            <td class="text-center">{{$k->kesesuaian}}</td>
                                            <td class="text-center">{{$k->kosong}}</td>
                                            
                                            <th></th>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <div class="white-box">
                                <p class="text-muted m-b-30">Rekomendasi perusahaan</p>
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
            </div>
            <script type="text/javascript" >
                Morris.Area({
                    element: 'morris-area-chart',
                    data: [
                    <?php 
                        echo "{period: '2018'";
                        foreach ($th2018 as $l) {
                            if ($l['id_jurusan']==1) {
                                $nama_jurusan = "Kelistrikan";
                            }elseif($l['id_jurusan']==2){
                                $nama_jurusan = "Permesinan";
                            }
                            elseif($l['id_jurusan']==3){
                                $nama_jurusan = "TKR";
                            }elseif($l['id_jurusan']==4){
                                $nama_jurusan = "TKJ";
                            }elseif($l['id_jurusan']==5){
                                $nama_jurusan = "TBSM";
                            }
                        echo ",".$nama_jurusan.": ".$l['jumlah'];
                        }
                        echo "},";
                        echo "{period: '2019'";
                        foreach ($th2019 as $l) {
                           if ($l['id_jurusan']==1) {
                                $nama_jurusan = "Kelistrikan";
                            }elseif($l['id_jurusan']==2){
                                $nama_jurusan = "Permesinan";
                            }
                            elseif($l['id_jurusan']==3){
                                $nama_jurusan = "TKR";
                            }elseif($l['id_jurusan']==4){
                                $nama_jurusan = "TKJ";
                            }elseif($l['id_jurusan']==5){
                                $nama_jurusan = "TBSM";
                            }
                        echo ",".$nama_jurusan.": ".$l['jumlah'];
                        }
                        echo "},";
                        echo "{period: '2020'";
                        foreach ($th2020 as $l) {
                           if ($l['id_jurusan']==1) {
                                $nama_jurusan = "Kelistrikan";
                            }elseif($l['id_jurusan']==2){
                                $nama_jurusan = "Permesinan";
                            }
                            elseif($l['id_jurusan']==3){
                                $nama_jurusan = "TKR";
                            }elseif($l['id_jurusan']==4){
                                $nama_jurusan = "TKJ";
                            }elseif($l['id_jurusan']==5){
                                $nama_jurusan = "TBSM";
                            }
                        echo ",".$nama_jurusan.": ".$l['jumlah'];
                        }
                        echo "},";
                         ?>
                    ],
                    xkey: 'period',
                    ykeys: ['Kelistrikan','Permesinan','TKR','TKJ','TBSM'],
                    labels: ['Kelistrikan','Permesinan','TKR','TKJ','TBSM'],
                    pointSize: 3,
                    fillOpacity: 0,
                    pointStrokeColors:['#00bfc7', '#fdc006', '#9675ce','#ff0000','#00f508'],
                    behaveLikeLine: true,
                    gridLineColor: '#e0e0e0',
                    lineWidth: 1,
                    hideHover: 'auto',
                    lineColors: ['#00bfc7', '#fdc006', '#9675ce','#ff0000','#00f508'],
                    resize: true

                });
            </script>
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

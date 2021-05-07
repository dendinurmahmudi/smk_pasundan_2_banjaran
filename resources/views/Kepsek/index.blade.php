<?php  ?>
@extends('master')
@section('judul','Beranda Kepala sekolah')
@section('label','Dashboard')
@extends('Kepsek/sidebar')
@section('konten')
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <div class="row row-in">
                <div class="col-lg-4 col-sm-12 row-in-br">
                    <ul class="col-in">
                        <li>
                            <span class="circle circle-md bg-info"><i class="ti-clipboard"></i></span>
                        </li>

                        <li class="col-last">
                            <h3 class="counter text-right m-t-15">{{ count($penelusuran)}}</h3></li>
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
                    <div class="col-lg-4 col-sm-12 row-in-br  b-r-none">
                        <ul class="col-in">
                            <li>
                                <span class="circle circle-md bg-success"><i class="ti-check"></i></span>
                            </li>
                            <?php 
                            $mengisi = count($penelusuran) - count($tidakisi);
                            $total1 = $mengisi/count($penelusuran)*100;
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
                        <div class="col-lg-4 col-sm-12  b-0">
                            <ul class="col-in">
                                <li>
                                    <span class="circle circle-md bg-danger"><i class="fa fa-close"></i></span>
                                </li>
                                <?php 
                                $total2 = count($tidakisi)/count($penelusuran)*100;
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
                                <div class="chart easy-pie-chart-3" data-percent="{{ $hitung1 }}"> <span class="percent"></span> <br><b>Alumni yang bekerja</b></div>
                            </div>
                            <div class="col-sm-3">
                                <?php 
                                $all = count($penelusuran);
                                $pencaker = count($pencaker); 
                                $hitung2 = $pencaker/$all*100;
                                ?>
                                <div class="chart easy-pie-chart-4" data-percent="{{ $hitung2 }}"> <span class="percent"></span> <br><b>Alumni yang belum bekerja</b></div>
                            </div>
                            <div class="col-sm-3">
                                <?php 
                                $all = count($penelusuran);
                                $kuliah = count($kuliah); 
                                $hitung3 = $kuliah/$all*100;
                                ?>
                                <div class="chart easy-pie-chart-5" data-percent="{{ $hitung3 }}"> <span class="percent"></span>  <br><b>Alumni yang melanjutkan sekolah</b></div>
                            </div>
                            <div class="col-sm-3">
                                <?php 
                                $kesesuaian = count($kesesuaian);
                                $sesuai = count($sesuai); 
                                $hitung = $sesuai/$kesesuaian*100;
                                ?>
                                <div class="chart easy-pie-chart-2" data-percent="{{$hitung}}"> <span class="percent"></span>  <br><b>kesesuaian jurusan dan pekerjaan</b></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endsection
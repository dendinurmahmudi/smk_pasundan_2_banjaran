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
                <a href="/informasi" title="informasi hari ini">
                <div class="col-lg-4 col-sm-12 row-in-br">
                    <ul class="col-in">
                        <li>
                            <span class="circle circle-md bg-info"><i class="ti-bell"></i></span>
                        </li>
                        <li class="col-last">
                            <h3 class="counter text-right m-t-15">{{count($info)}}</h3></li>
                            <li class="col-middle">
                                <h4>Informasi</h4>{{date('d M Y')}}
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
            </div>
            @endsection
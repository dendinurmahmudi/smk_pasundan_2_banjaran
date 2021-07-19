<?php  ?>
@extends('master')
@section('judul','Data alumni')
@section('class','icon-people fa-fw')
@section('label','Data alumni')
@extends('Hubin/sidebar')
@section('konten')
<div class="row">
	<div class="col-sm-12">
		@foreach($jmlllsn as $j)
		<div class="col-lg-3">
			<a href="/datajurusan" title="">
				<div class="white-box">
					<h4 class="box-title">Jumlah alumni : {{$j['jumlah']}}</h4>
					<ul class="list-inline two-part">
						<li><i class="icon-people text-info"></i></li>
						<li class="text-right"><span class="counter">{{$j['tahun']}}</span></li>
					</ul>
				</div>
			</a>
		</div>
		@endforeach
	</div>
</div>

@endsection
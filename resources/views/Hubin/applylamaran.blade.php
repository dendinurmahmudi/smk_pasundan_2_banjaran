<?php  ?>
@extends('master')
@section('judul','Apply lamaran')
@section('class','ti-email fa-fw')
@section('label','Apply lamaran')
@extends('Hubin/sidebar')
@section('konten')
<div class="row">
	<div class="col-sm-12">
		<div class="white-box">
			<div class="row row-in">
				@foreach($berkas as $b)
				<?php
				$data = $b->jumlah; 
				if ($data >=  1 && $data <= 5 ) {
					$banner = 'danger';
				}elseif ($data >= 6 && $data <= 10 ) {
					$banner = 'warning';
				}elseif ($data >= 11 && $data <= 15 ) {
					$banner = 'success';
				}elseif ($data >= 16 ) {
					$banner = 'info';
				}
				?>
				<div class="col-lg-4 col-sm-12 row-in-br">
					<a href="datapelamar/{{$b->untuk_perusahaan}}" title="lihat data">
						<ul class="col-in">
							<li>
								<span class="circle circle-md bg-{{$banner}}"><i class="ti-clipboard"></i></span>
							</li>
							<li class="col-last">
								<h3 class="counter text-right m-t-15">{{$b->jumlah}}</h3></li>
								<li class="col-middle">
									<h4>{{$b->untuk_perusahaan}}</h4>
									<div class="progress">
										<div class="progress-bar progress-bar-{{$banner}}" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
										</div>
									</div>
								</li>
							</ul>
						</a>
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
	@endsection
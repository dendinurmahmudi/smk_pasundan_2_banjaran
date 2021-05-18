@extends('master')
@section('judul','Pesan')
@section('class','ti-email fa-fw')
@section('label','Pesan')
@extends('Admin/sidebar')
@section('konten')
<div class="chat-main-box">
	<!-- .chat-left-panel -->
	<div class="chat-left-aside">
		<div class="open-panel"><i class="ti-angle-right"></i></div>
		<div class="chat-left-inner">
			<div class="form-material">
				<input class="form-control p-20" type="text" id="seacrh" name="seacrh" placeholder="Search Contact">
			</div>
			<ul class="chatonline style-none ">
				<div class="customvtab">
					<ul class="nav tabs-vertical" id="slimtest3">
						@foreach($history as $h)
						<li class="tab">
							<a data-toggle="tab" href="#vhome3" aria-expanded="true"><img src="{{ asset('data_file/profile/'.$h->foto) }}"  width="35" height="35" alt="user-img" class="img-circle"><span data-nisn="{{$h->nisn}}" data-nama="{{$h->name}}" data-foto="{{$h->foto}}">{{$h->name}}</span></a>
						</li>
						@endforeach
					</ul>
				</div>
				<li class="p-20"></li>
			</ul>
		</div>
	</div>
	<!-- .chat-left-panel -->
	<!-- .chat-right-panel -->
	<div class="tab-content">
		<div id="vprofile3" class="tab-pane active">
			<div class="chat-right-aside">
				<div class="chat-main-header">
					<div class="row" id="nama">
						<div class="col-sm-1 m-l-10">
							<img src="{{ asset('assets/favicon.png') }}" class="img-circle" alt="img" width="50">
						</div>
						<div class="col-sm-9 m-l-10" id="oso">
							<h4 class="box-title">Chat SMK Pasundan 2 Banjaran</h4>
						</div>
					</div>
					<hr>
				</div>
				<div class="chat-box " id="slimtest2">
					<ul class="chat-list slimscroll p-t-30">
						<div id="isichat">
							<h2 align="center">Masih tahap percobaan yaaaa...</h2>
						</div>
						<div id="isikirim">

						</div>
					</ul>
				</div>
				<div class="row send-chat-box">
					<form method="get" accept-charset="utf-8">
						<div class="col-sm-12">
							<input type="hidden" name="nisn" id="nisn" value="" placeholder="">
							<input type="hidden" name="namap" id="namap" value="{{Auth::user()->name}}" placeholder="">
							<textarea class="form-control" name="isipesan" id="isipesan" placeholder="Ketikan pesan disini"></textarea>
						</form>
						<div class="custom-send">
							<input class="btn btn-info btn-rounded" type="button" value="Kirim" id="kirim" >
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- .chat-right-panel -->
	</div>
	<?php $zona = time()+(60*60*7); ?> 
	<input type="hidden" name="" id="waktu" value="{{gmdate('H:i',$zona)}}">
	<script type="text/javascript">

		$('#slimtest1').slimScroll({
			height: '260px'
		});
		$('#slimtest2').slimScroll({
			height: '260px'
		});
		$('#slimtest3').slimScroll({
			height: '360px'
		});

		$('#seacrh').on('keyup',(a)=>{
			let seacrh = $('#seacrh').val();
			$.getJSON(`/search/${seacrh}`,(data)=>{
				$('#slimtest3').html('')
				$.each(data,(i,pt)=>{
					console.log(pt.name);
					$('#slimtest3').append(`<li class="tab"><a data-toggle="tab" href="#" aria-expanded="true"><img src="{{ asset("data_file/profile/`+pt.foto+`") }}" alt="user-img" width="35" height="35" class="img-circle"><span data-nisn="${pt.nisn}" data-nama="${pt.name}" data-foto="${pt.foto}">${pt.name}</span></a></li>`);
				});
			});    
		});
		$('#slimtest3').on('click',(slimtest3)=>{
			console.log(slimtest3.target.dataset.nama);
			$('#nama').html('')
			$('#nisn').val(slimtest3.target.dataset.nisn);
			$('#nama').append(`<div class="col-sm-1 m-l-10">
				<img src="{{ asset('data_file/profile/`+slimtest3.target.dataset.foto+`') }}" class="img-circle" alt="img" width="50" height="50">
				</div>
				<div class="col-sm-9 m-l-10">
				<h4 class="box-title">`+slimtest3.target.dataset.nama+`</h4></div>
				<div class="col-sm-1 m-l-10">
				<a href="#" title="Hapus pesan `+slimtest3.target.dataset.nama+`" class="btn btn-danger btn-circle"><i class="fa fa-trash"></i></a>
				</div>
				`);
			$('#isikirim').html('')
			$.getJSON(`/isichat/${slimtest3.target.dataset.nisn}`,(data)=>{
				$('#isichat').html('')
				console.log('yai');
				$.each(data,(i,pt)=>{
					console.log(pt.dari);
					$('#isichat').append(`<li>
						<div class="chat-image"> <img alt="male"  width="40" height="40" src="{{ asset('data_file/profile/`+pt.foto+`') }}"> </div>
						<div class="chat-body">
						<div class="chat-text">
						<p>${pt.isi}</p> <b>${pt.waktu}</b> </div>
						</div>
						</li>
						<div id="pengirim">
						<li class="odd" onFocus="true">
						<div class="chat-image"> <img alt="Female" width="40" height="40" src="{{ asset('data_file/profile/'.Auth::user()->foto) }}"> </div>
						<div class="chat-body">
						<div class="chat-text">
						<p>${pt.isi}</p> <b>${pt.waktu}</b> </div>
						</div>
						</li>`);
				});
			});    
		});

		$('#kirim').on('click',(kirim)=>{
			var p = $('#isipesan').val();
			var n = $('#nisn').val();
			var k = $('#namap').val();
			var w = $('#waktu').val();
			$('#isikirim').append(`<li class="odd" onFocus="true">
				<div class="chat-image"> <img alt="Female" width="40" height="40" src="{{ asset('data_file/profile/'.Auth::user()->foto) }}"> </div>
				<div class="chat-body">
				<div class="chat-text">
				<p>`+p+`</p> <b>`+w+`</b> </div>
				</div>
				</li>`);
			$.getJSON(`/kirimp/${n}/${p}`);
			$('#isipesan').val('');
		});

	</script>
	@endsection
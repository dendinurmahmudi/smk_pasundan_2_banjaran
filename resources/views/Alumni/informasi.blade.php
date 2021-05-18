@extends('master')
@section('judul','Informasi')
@section('class','ti-bell fa-fw')
@section('label','Informasi')
@extends('Alumni/sidebar')
@section('konten')
<!--  -->
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
<div class="row m-t-15">
	<div class="col-md-12">
		<div class="white-box">
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
</div>

<script type="text/javascript">

	$('#slimtest{{$no2++}}').slimScroll({
		height: '250px'
	});
</script>
@endforeach
@endsection
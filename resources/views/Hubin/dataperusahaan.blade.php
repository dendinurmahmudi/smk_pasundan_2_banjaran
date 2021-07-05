@extends('master')
@section('judul','Data perusahaan')
@section('class','fa fa-building-o fa-fw')
@section('label','Data perusahaan')
@extends('Hubin/sidebar')
@section('konten')
@if (Session::has('success'))
<div class="col-sm-12">
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{ Session::get('success') }}
    </div>
</div>
@endif
<div class="col-sm-12">
  <div class="white-box">
    <div class="row">
      <div class="col-sm-9">
        
      </div>
      <div class="form-group" style="margin-bottom: 50px">
        <div class="col-sm-3 pull-right">
          <a href="/prosesalgo" class="btn btn-info">Tampilkan proses Algo</a>
        </div>
      </div>
    </div>
    <!-- Nav tabs -->
    <ul class="nav customtab nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#home1" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Semua</span></a></li>
      <li role="presentation" class=""><a href="#profile1" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">MOU</span></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane fade active in" id="home1">
       <div class="table-responsive">
        <table class="example23 table table-striped display nowrap" cellspacing="0" width="100%">
         <thead>
          <tr>
           <th>No</th>
           <th>Perusahaan</th>
           <th>Status</th>
           <th>Alumni bekerja</th>
           <th>Sesuai kompetensi</th>
           <th>Merasa puas</th>
           <th>Pilihan</th>
         </tr>
       </thead>
       <tbody>
        <?php $no=1;$no1=1;$no2=1;$no3=1;
        ?>
        @foreach($perusahaan as $p)
        <tr>
         <td>{{ $no++ }}</td>
         <td>{{ $p['nama_perusahaan'] }}</td>
         @if($p['status'] == 'Y')
         <td><i class="fa fa-check text-success"></i> MOU</td>
         @else
         <td><i class="fa fa-close text-danger"></i> Belum MOU</td>
         @endif
         <td>{{ $p['jumlah'] }}</td>
         <td>{{ $p['kesesuaian'] }}</td>
         <td>{{ $p['kepuasan'] }}</td>
         <td class="text-nowrap">
          <a href="#" data-toggle="modal" data-target="#edit{{$no1++}}" title="Edit {{$p['nama_perusahaan']}}"> <i class="fa fa-pencil text-inverse m-l-15"></i> </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
</div>
<div role="tabpanel" class="tab-pane fade" id="profile1">
  <div class="table-responsive">
    <table class="example23 table table-striped display nowrap" cellspacing="0" width="100%">
     <thead>
      <tr>
       <th>No</th>
       <th>Perusahaan</th>
       <th>Status</th>
       <th>Alumni bekerja</th>
       <th>Sesuai kompetensi</th>
       <th>Merasa puas</th>
       <th>Pilihan</th>
     </tr>
   </thead>
   <tbody>
    <?php $no=1;
    ?>
    @foreach($perusahaan as $p)
    @if($p['status'] == 'Y')
    <tr>
     <td>{{ $no++ }}</td>
     <td>{{ $p['nama_perusahaan'] }}</td>
     @if($p['status'] == 'Y')
     <td><i class="fa fa-check text-success"></i> MOU</td>
     @else
     <td><i class="fa fa-close text-danger"></i></td>
     @endif
     <td>{{ $p['jumlah'] }}</td>
     <td>{{ $p['kesesuaian'] }}</td>
     <td>{{ $p['kepuasan'] }}</td>
     <td class="text-nowrap">
      <a href="#" data-toggle="modal" data-target="#edit{{$no3++}}" title="Edit {{$p['nama_perusahaan']}}"> <i class="fa fa-pencil text-inverse m-l-15"></i> </a>
    </td>
  </tr>
  @endif
  @endforeach
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
@foreach($perusahaan as $p)
<div id="edit{{$no2++}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Edit Perusahaan</h4> </div>
                <div class="modal-body">
                    <div class="white-box">
                        <form action="/editperu" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <input type="text" name="namaperusahaan" class="form-control"  value="{{$p['nama_perusahaan']}}" readonly>
                                </div>
                                <div class="form-group col-sm-12">
                                    <b><input type="checkbox" name="mou" value="Y" <?php if ($p['status'] == 'Y')  echo "checked"; ?>> <label> MOU</label></b>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

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
    $('.myTable').DataTable();
    $(document).ready(function() {
      var table = $('.example').DataTable({
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
            $('.example tbody').on('click', 'tr.group', function() {
              var currentOrder = table.order()[0];
              if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                table.order([2, 'desc']).draw();
              } else {
                table.order([2, 'asc']).draw();
              }
            });
          });
  });
  $('.example23').DataTable({
    dom: 'Bfrtip',
    buttons: [
    'excel', 'pdf', 'print'
    ]
  });
</script>
@endsection
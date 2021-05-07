@extends('master')
@section('judul','Penelusuran')
@section('class','ti-clipboard fa-fw')
@section('label','Penelusuran alumni')
@extends('Alumni/sidebar')
@section('konten')

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<div class="tab-content">
    <div class="white-box">                        
        <div class="user-bg"> <img width="100%" alt="user" src="{{ asset('data_file/profile/'.Auth::user()->foto) }}">
            <div class="overlay-box">
                <div class="user-content">
                    <a href="javascript:void(0)"><img src="{{ asset('data_file/profile/'.Auth::user()->foto) }}" class="thumb-lg img-circle" alt="img"></a>
                    <h4 class="text-white">{{ Auth::user()->name }}</h4>
                    <h5 class="text-white">{{ Auth::user()->email}}</h5>
                    <h5 class="text-white">{{ Auth::user()->nisn}}</h5>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <hr>
                <p class=""> Isi data di bawah sesuai situasi anda saat ini </p>
                @if (Session::has('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ Session::get('success') }}
                </div>
                @endif
                <form class="form-material" action="updatepenelusuran" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="nisn" value="{{ $penelusuran->nisn }}"> <br/>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bekerja">Bekerja:</label>
                            <input type="text" class="typeahead form-control" id="bekerja" name="bekerja" value="{{$penelusuran->nama_perusahaan}}" placeholder="*kosongkan jika belum bekerja dan centang pencaker"> </div>
                            <div id="cari" class="m-b-5">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kuliah">Kuliah:</label>
                                <input type="text" class="form-control" id="kuliah" name="kuliah" value="{{$penelusuran->nama_kampus}}" placeholder="*kosongkan jika tidak melanjutkan kuliah"> </div>

                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="checkbox" id="pencaker" name="pencaker" value="Y"<?php if ($penelusuran->pencaker == 'Y')  echo "checked"; ?>> <label for="pencaker">Pencaker</label></div>
                                    <p class="text-muted m-b-30 font-13"> Detail pekerjaan </p>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Gaji Pertama:</label>
                                        <div class="col-sm-7">
                                            <div class="input-group"><span class="input-group-addon">Rp.</span>
                                                <input type="number" name="gaji" value="{{$penelusuran->gaji}}" class="form-control" id="inputEmail3" placeholder="Masukan nominal gaji"> </div>
                                                <br>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-4 control-label">Sesuai Kompetensi :</label>
                                            <div class="col-sm-7">
                                                <div class="radio radio-success">
                                                    <input type="radio" name="sesuai_kompetensi" id="radio" value="Y" <?php if ($penelusuran->sesuai_kompetensi == 'Y')  echo "checked"; ?>>
                                                    <label for="radio"> Ya</label>
                                                </div>
                                                <div class="radio radio-danger">
                                                    <input type="radio" name="sesuai_kompetensi" id="radio2" value="T" <?php if ($penelusuran->sesuai_kompetensi == 'T')  echo "checked"; ?>>
                                                    <label for="radio2"> Tidak </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-4 control-label">Kepuasan Bekerja :</label>
                                            <div class="col-sm-7">

                                                <div class="radio radio-success">
                                                    <input type="radio" name="kepuasan" id="radio4" value="Y" <?php if ($penelusuran->kepuasan == 'Y')  echo "checked"; ?>>
                                                    <label for="radio4"> Ya</label>
                                                </div>
                                                <div class="radio radio-danger">
                                                    <input type="radio" name="kepuasan" id="radio6" value="T" <?php if ($penelusuran->kepuasan == 'T')  echo "checked"; ?>>
                                                    <label for="radio6"> Tidak </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Keterangan :</label>
                                            <textarea class="form-control" name="keterangan" id="exampleInputEmail1" placeholder="Keterangan.." rows="4">{{ $penelusuran->keterangan }}</textarea></div>
                                        </div><br>
                                        
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                        <div class="col-sm-12 col-xs-12">
                                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="{{ asset('assets/templates/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
                <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> -->
                <script type="text/javascript">
                    $('#bekerja').on('keyup',(a)=>{
                        let bekerja = $('#bekerja').val();
                        $.getJSON(`/cari/${bekerja}`,(data)=>{
                            $('#cari').html('')
                            $.each(data,(i,pt)=>{
                                $('#cari').append(`<label title="Pilih" data-bekerja="${pt.nama_perusahaan}">${pt.nama_perusahaan}</label><br>`);
                            });
                            
                        });    
                    });
                    
                    $('#cari').on('click',(cari)=>{
                        console.log(cari.target.dataset.bekerja);
                        $('#bekerja').val(cari.target.dataset.bekerja);
                        $('#cari').html('');
                    });
                    // $('#cari')
              //       $('#cari').select2({
              //           placeholder: 'Cari...',
              //           ajax: {
              //             url: '/cari',
              //             dataType: 'json',
              //             delay: 250,
              //             processResults: function (data) {
              //               return {
              //                 results:  $.map(data, function (item) {
              //                   return {
              //                     text: item.nama_perusahaan
              //                 }
              //             })
              //             };
              //         },
              //         cache: true
              //     }
              // });

          </script>

          @endsection
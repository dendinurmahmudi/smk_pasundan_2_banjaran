<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Session;
use Hash;
use App\penelusuran;
use App\alumni;
use App\perusahaan;
use App\informasi;
use App\berkas_lamaran;
use App\user;
class AlumniController extends Controller
{
    public function index()
    { 
        $info = informasi::whereRaw('left(created_at,10)="'.date('Y-m-d').'"')->get();
        $penelusuran = penelusuran::where('nisn',Auth::user()->nisn)->first();
        $profile = alumni::where('nisn',Auth::user()->nisn)->first();
        $warna = ['oval','','','',''];
    	return view('Alumni/index',['info' => $info,'penelusuran' => $penelusuran,'profile'=>$profile,'warna' =>$warna]);
    }
    public function profile()
    {
        $alumni = alumni::join('users','alumni.nisn','=','users.nisn')
        ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
        ->where('alumni.nisn',Auth::user()->nisn)->first();
        $jurusan = DB::select('select * from jurusan where id_jurusan!=6');
        $warna = ['','','','',''];
        return view('Alumni/profile',['alumni' => $alumni,'jurusan' => $jurusan,'warna'=>$warna]);	
    }
    public function updateprofile(Request $request)
    {
        $rules = [
            'name'                  => 'required|min:3|max:35',
            'email'                 => 'required|email'
        ];
        $messages = [
            'name.required'         => 'Nama Lengkap wajib diisi',
            'name.min'              => 'Nama lengkap minimal 3 karakter',
            'name.max'              => 'Nama lengkap maksimal 35 karakter',
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        alumni::where('nisn',$request->nisn)->update([
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tahun_lulus' => $request->tahun_lulus,
            'jurusan' => $request->jurusan,
            'no_hp' => $request->no_hp
        ]);
        DB::table('users')->where('nisn',$request->nisn)->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
        Session::flash('success', 'Berhasil mengedit profile');

        if ($request->file != null) {

            $rules = [
                'file' => 'file|image|mimes:jpeg,png,jpg|max:2048'
            ];
            $messages = [
                'file.image'            => 'File harus Foto',
                'file.mimes'            => 'File yang diperbolehkan jpeg,png,jpg',
                'file.max'              => 'ukuran max 2 mb'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }
            $file = $request->file('file');
            $nama_file = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'data_file/profile';
            $file->move($tujuan_upload,$nama_file);
            DB::table('users')->where('nisn',$request->nisn)->update([
                'foto' => $nama_file
            ]);
            Session::flash('success', 'Berhasil mengubah foto profile');
        }
        else if ($request->file2 != null) {

            $rules = [
                'file2' => 'file|mimes:pdf'
            ];
            $messages = [
                'file2.mimes'            => 'File yang diperbolehkan pdf'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }
            $file = $request->file('file2');
            $nama_file = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'data_file/berkas_lamaran';
            $file->move($tujuan_upload,$nama_file);
            alumni::where('nisn',$request->nisn)->update([
                'file_lamaran' => $nama_file
            ]);
            Session::flash('success', 'Berhasil menambah berkas lamaran');
        }

        return redirect()->route('profile');
    }
    public function penelusuran(){
    	$penelusuran = penelusuran::join('alumni','alumni.nisn','=','penelusuran.nisn')->where('penelusuran.nisn',Auth::user()->nisn)->first();
        $warna = ['','','','oval',''];
    	return view('Alumni/penelusuran',['penelusuran' => $penelusuran,'warna'=>$warna]);
    }
    
    public function autocomplete($id)
    {
        $perusahaan=$id;
    $data = penelusuran::select('nama_perusahaan')->whereRaw('nama_perusahaan LIKE "%'.$id.'%" group by nama_perusahaan limit 3 ')->get();
            // var_dump($request);
        echo json_encode($data);
    }

    public function tambahpenelusuran(Request $request)
    {
    	penelusuran::create([
    		'nama_perusahaan' =>$request->bekerja,
    		'sesuai_kompetensi' =>$request->sesuai_kompetensi,
    		'gaji' =>$request->gaji,
    		'kepuasan' =>$request->kepuasan,
    		'nama_kampus' =>$request->kuliah,
    		'nisn' => Auth::user()->nisn,
    		'keterangan' =>$request->keterangan
    	]);
    	return redirect()->route('penelusuran');
    }
    public function updatepenelusuran(Request $request)
    {   
        if($request->pencaker!=null){
            penelusuran::where('nisn',$request->nisn)->update([
                'nama_perusahaan' => null,
                'nama_kampus' => null,
                'pencaker' =>$request->pencaker,
                'kepuasan' =>'B',
                'sesuai_kompetensi' => 'B',
                'gaji' => 'B',
                'keterangan' => $request->keterangan
            ]);
            perusahaan::where('nisn',$request->nisn)->update([
                'perusahaan' => null
            ]);
        }
        else if($request->kuliah!=null && $request->bekerja!=null){
            penelusuran::where('nisn',$request->nisn)->update([
                'nama_perusahaan' => $request->bekerja,
                'nama_kampus' => $request->kuliah,
                'pencaker' => 'T',
                'kepuasan' => $request->kepuasan,
                'sesuai_kompetensi' => $request->sesuai_kompetensi,
                'gaji' => $request->gaji,
                'keterangan' => $request->keterangan
            ]);
            perusahaan::where('nisn',$request->nisn)->update([
                'perusahaan' => $request->bekerja
            ]);
        }else if($request->kuliah!=null){
            penelusuran::where('nisn',$request->nisn)->update([
                'nama_perusahaan' => null,
                'nama_kampus' => $request->kuliah,
                'pencaker' =>'B',
                'kepuasan' =>'B',
                'sesuai_kompetensi' => 'B',
                'gaji' => 'B',
                'keterangan' => $request->keterangan
            ]);
            perusahaan::where('nisn',$request->nisn)->update([
                'perusahaan' => null
            ]);
        }else if($request->bekerja!=null){
            penelusuran::where('nisn',$request->nisn)->update([
                'nama_perusahaan' => $request->bekerja,
                'nama_kampus' => null,
                'sesuai_kompetensi' => $request->sesuai_kompetensi,
                'gaji' => $request->gaji,
                'kepuasan' => $request->kepuasan,
                'pencaker' => 'T',
                'keterangan' => $request->keterangan
            ]);
            perusahaan::where('nisn',$request->nisn)->update([
                'perusahaan' => $request->bekerja
            ]);
        }else {
            penelusuran::where('nisn',$request->nisn)->update([
                'nama_perusahaan' => null,
                'nama_kampus' => null,
                'pencaker' => null,
                'kepuasan' => null,
                'sesuai_kompetensi' => null,
                'gaji' => null,
                'keterangan' => null
            ]);
            perusahaan::where('nisn',$request->nisn)->update([
                'perusahaan' => null
            ]);
        }
        Session::flash('success', 'Berhasil Menambah data penelusuran');
        return redirect()->route('penelusuran');
    }
    public function informasi()
    {
        $info = informasi::orderBy('created_at','desc')->get();
        $file = alumni::select('file_lamaran','nisn')->where('nisn',Auth::user()->nisn)->first();
        $warna = ['','','oval','',''];
        return view('Alumni/informasi',['info' => $info, 'file' => $file,'warna'=>$warna ]);
    }
    public function kirimlamaran(Request $request)
    {
        if ($request->file==null) {
            Session::flash('eror', 'Silahkan apply lamaran anda terlebih dahulu pada halaman profile');    
            return redirect()->route('informasi');
        }else if(berkas_lamaran::whereRaw('untuk_perusahaan="'.$request->judul.'" and nisn="'.$request->nisn.'"')->first()){
            Session::flash('eror', 'Apply lamaran sudah dilakukan dan hanya diperbolehkan Apply lamaran 1 kali');    
            return redirect()->route('informasi');
        }
        berkas_lamaran::create([
            'untuk_perusahaan' => $request->judul,
            'nisn' => $request->nisn,
            'file_lamaran' => $request->file
        ]);
        Session::flash('success', 'Berhasil Mengirim file lamaran');
        return redirect()->route('informasi');
    }
    public function applylamaran($id)
    {
        $berkas = berkas_lamaran::where('nisn',$id)->get();
        $warna = ['','oval','','',''];
        return view('Alumni/applylamaran',['berkas'=>$berkas,'warna'=>$warna]);
    }
    public function daftarperusahaan()
    {
        $perusahaan = DB::select('select nama_perusahaan, count(nama_perusahaan)as jumlah,count(if(sesuai_kompetensi="Y",sesuai_kompetensi,null))as kesesuaian, count(if(kepuasan="Y", kepuasan,null))as kepuasan from penelusuran where nama_perusahaan!="null" group by nama_perusahaan');
        $warna = ['','','','','oval'];
        return view('Alumni/daftarperusahaan',['perusahaan' => $perusahaan,'warna'=>$warna]);
    }
    public function hapuslam($id)
    {
        berkas_lamaran::where('id',$id)->delete();
         Session::flash('success', 'Berhasil menambah berkas lamaran');        
         return redirect('apllylamaranalumni/'.Auth::user()->nisn);
    }
    public function gantipass1(Request $request)
    {
         $rules = [
             'passwordBaru1'         => 'min:6'
         ];
         $messages = [
             'passwordBaru1.min'          => 'Password minimal 6 karakter'
         ];
         $validator = Validator::make($request->all(), $rules, $messages);
         if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $passlama = $request->passwordLama;
        $passbaru = $request->passwordBaru1;
        $passbaru2 = $request->passwordBaru2;
        if ($passlama==password_verify($passlama, Auth::user()->password)) {
            if($passbaru!=$passbaru2){
                Session::flash('gagal', 'Password tidak sama, mohon ulangi');
                return redirect('profile'.Auth::user()->hak_akses);   
            }else{
                user::where('id',$request->id)->update([
                    'password' => Hash::make($passbaru)
                ]);
                Session::flash('success', 'Password berhasil diubah');
                return redirect('profile'.Auth::user()->hak_akses);   
            }
        }else{
            Session::flash('gagal', 'Password lama salah');
                return redirect('profile'.Auth::user()->hak_akses);   
        }
    }
    
}
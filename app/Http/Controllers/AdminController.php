<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use Hash;
use App\alumni;
use App\user;
use App\penelusuran;
use App\perusahaan;
use App\berkas_lamaran;
class AdminController extends Controller
{
	public function index()
	{
		$alumni = alumni::all();
		$user = user::all();
		$penelusuran = penelusuran::all();
		$tidakisi = penelusuran::where('nama_perusahaan',null)->where('nama_kampus',null)->where('pencaker',null)->get();
		$perusahaan = DB::select('select nama_perusahaan, count(nama_perusahaan)as jumlah,count(if(sesuai_kompetensi="Y",sesuai_kompetensi,null))as kesesuaian, count(if(kepuasan="Y", kepuasan,null))as kepuasan from penelusuran where nama_perusahaan!="null" group by nama_perusahaan order by nama_perusahaan desc');
        $pengguna = alumni::join('users','alumni.nisn','=','users.nisn')->join('jurusan','jurusan.id_jurusan','=','alumni.jurusan')->where('users.status_aktif','2')->orderBy('users.created_at','desc')->get();
		$warna = ['oval','','','',''];
		return view('Admin/index',['alumni'=>$alumni,'user'=>$user,'penelusuran'=>$penelusuran,'tidakisi'=>$tidakisi,'perusahaan'=>$perusahaan,'warna'=>$warna,'pengguna'=>$pengguna]);
	}
	public function dataalumni($id)
    {
    	$alumni = alumni::join('users','alumni.nisn','=','users.nisn')
        ->join('penelusuran','alumni.nisn','=','penelusuran.nisn')
        ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
        ->where('jurusan.nama_jurusan',$id)
        ->orderBy('users.name')
        ->get();
        $jurusan = DB::select('select * from jurusan where id_jurusan!=6');
        $warna = ['','oval','','',''];
        $lulusan = alumni::select('tahun_lulus')->groupBy('tahun_lulus')->get();
        $jrsn = alumni::join('users','alumni.nisn','=','users.nisn')
        ->join('penelusuran','alumni.nisn','=','penelusuran.nisn')
        ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
        ->where('jurusan.nama_jurusan',$id)
        ->orderBy('users.name')
        ->get();
      return view('Admin/dataalumni',['alumni' => $alumni,'warna'=>$warna,'jurusan'=>$jurusan,'lulusan'=>$lulusan,'jrsn'=>$jrsn]);
  	}
  	public function datapengguna()
  	{
  		$pengguna = user::orderBy('name')->get();
  		$warna = ['','','oval','',''];
  		return view('Admin/datapengguna',['pengguna' => $pengguna,'warna'=>$warna]);
  	}
  	public function datapenelusuran(){
    	$penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
        ->join('alumni','alumni.nisn','=','users.nisn')
        ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
        ->orderBy('users.name')
        ->get();
        $warna = ['','','','oval',''];
        $jurusan = DB::table('jurusan')->get();
        $lulusan = alumni::select('tahun_lulus')->groupBy('tahun_lulus')->get();
        return view('Admin/datapenelusuran',['penelusuran' => $penelusuran,'warna'=>$warna,'jurusan'=>$jurusan,'lulusan'=>$lulusan]);
    }
    public function dataperusahaan()
  	{
    $perusahaan = DB::select('select nama_perusahaan, count(nama_perusahaan)as jumlah,count(if(sesuai_kompetensi="Y",sesuai_kompetensi,null))as kesesuaian, count(if(kepuasan="Y", kepuasan,null))as kepuasan,count(tahun_lulus)jml from penelusuran join alumni on penelusuran.nisn=alumni.nisn where nama_perusahaan!="null" group by nama_perusahaan');
    $jmltahun = DB::select('select nama_perusahaan, tahun_lulus from penelusuran join alumni on penelusuran.nisn=alumni.nisn where nama_perusahaan!="null" group by tahun_lulus');
    $allprshn = DB::select('select nama_perusahaan,tahun_lulus from penelusuran p join alumni a on p.nisn=a.nisn');
    $warna = ['','','','','oval'];
    return view('Admin/dataperusahaan',['perusahaan' => $perusahaan,'warna'=>$warna,'jmltahun'=>$jmltahun,'allprshn'=>$allprshn]);
    }
    public function datajurusan()
    {
    	$jurusan = DB::select('select jurusan.nama_jurusan, count(alumni.jurusan)jumlah from alumni join jurusan on alumni.jurusan=jurusan.id_jurusan group by nama_jurusan desc');
        $alljurusan = DB::select('select * from jurusan where id_jurusan!=6');
    	$warna = ['','oval','','',''];
    	return view('Admin/datajurusan',['jurusan' => $jurusan,'warna'=>$warna,'alljurusan'=>$alljurusan]);
    }
    public function hapusdata($id,$jrsn)
    {
        alumni::where('nisn',$id)->delete();
        penelusuran::where('nisn',$id)->delete();
        user::where('nisn',$id)->delete();
        Session::flash('success', 'Berhasil Menghapus data '.$id);
        return redirect('/datalumni/'.$jrsn);
    }
    public function hapusdatap($id)
    {
        alumni::where('nisn',$id)->delete();
        penelusuran::where('nisn',$id)->delete();
        user::where('nisn',$id)->delete();
        berkas_lamaran::where('nisn',$id)->delete();
        Session::flash('success', 'Berhasil Menghapus data '.$id);
        return redirect('/datpengguna');
    }
    public function editpengguna(Request $request)
    {
    	user::where('id',$request->id)->update([
    		'hak_akses'		=> $request->hak_akses,
    		'status_aktif'	=> $request->status
    	]);
    	Session::flash('success', 'Berhasil Mengedit data '.$request->id);
        return redirect('/datpengguna');	
    }
    public function resetpass($id)
    {
        user::where('nisn',$id)->update([
            'password' => Hash::make($id),
        ]);
        Session::flash('success', 'Berhasil Reset password '.$id);
        return redirect('/datpengguna');    
    }
    public function profile()
    {
        $warna = ['','','','',''];
        return view('Admin/profileadmin',['warna'=>$warna]);
    }
    public function editalumni1(Request $request,$id)
    {
        alumni::where('nisn',$request->nisn)->update([
            'no_hp' => $request->nohp,
            'jurusan' => $request->jurusan,
            'tahun_lulus' => $request->tahun_lulus
        ]);
        Session::flash('success', 'Berhasil Mengedit data '.$request->nisn);
        return redirect('/datalumni/'.$id);    
    }
    public function gantipass2(Request $request)
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
    public function editprofileadmin(Request $request)
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
        user::where('id',$request->id)->update([
            'nisn'  => $request->nisn,
            'name'  => $request->name,
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
            user::where('nisn',$request->nisn)->update([
                'foto' => $nama_file
            ]);
            Session::flash('success', 'Berhasil mengubah foto profile');
        }
        return redirect('profile'.Auth::user()->hak_akses);   
    }
    public function alumniBy_tahun(Request $request)
    {
        if ($request->lulusan==0) {
            $alumni = alumni::join('users','alumni.nisn','=','users.nisn')
            ->join('penelusuran','alumni.nisn','=','penelusuran.nisn')
            ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
            ->where('jurusan.nama_jurusan',$request->jrsn)
            ->orderBy('users.name')
            ->get();
        }else if ($request->lulusan==null) {
            $alumni = alumni::join('users','alumni.nisn','=','users.nisn')
            ->join('penelusuran','alumni.nisn','=','penelusuran.nisn')
            ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
            ->where('jurusan.nama_jurusan',$request->jrsn)
            ->where('alumni.tahun_lulus',null)
            ->orderBy('users.name')
            ->get();
        }else{
            $alumni = alumni::join('users','alumni.nisn','=','users.nisn')
            ->join('penelusuran','alumni.nisn','=','penelusuran.nisn')
            ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
            ->where('jurusan.nama_jurusan',$request->jrsn)
            ->where('alumni.tahun_lulus',$request->lulusan)
            ->orderBy('users.name')
            ->get();
        }
        $jrsn = alumni::join('users','alumni.nisn','=','users.nisn')
            ->join('penelusuran','alumni.nisn','=','penelusuran.nisn')
            ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
            ->where('jurusan.nama_jurusan',$request->jrsn)
            ->orderBy('users.name')
            ->get();
        $jurusan = DB::select('select * from jurusan where id_jurusan!=6');
        $warna = ['','oval','','',''];
        $lulusan = alumni::select('tahun_lulus')->groupBy('tahun_lulus')->get();
      return view('Admin/dataalumni',['alumni' => $alumni,'warna'=>$warna,'jurusan'=>$jurusan,'lulusan'=>$lulusan,'jrsn'=>$jrsn]);        
    }
    public function penelusuranBy_jurusan_tahun1(Request $request)
    {
        if($request->jurusan && $request->lulusan==null){
            $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
            ->join('alumni','alumni.nisn','=','users.nisn')
            ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
            ->whereRaw('alumni.jurusan="'.$request->jurusan.'" and alumni.tahun_lulus="null"')
            ->orderBy('users.name')
            ->get();        

        }else if($request->lulusan==null){
            $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
            ->join('alumni','alumni.nisn','=','users.nisn')
            ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
            ->where('alumni.tahun_lulus',null)
            ->orderBy('users.name')
            ->get();        

        }else if($request->jurusan){
            $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
            ->join('alumni','alumni.nisn','=','users.nisn')
            ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
            ->where('alumni.jurusan',$request->jurusan)
            ->orderBy('users.name')
            ->get();        

        }else if($request->lulusan){
            $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
            ->join('alumni','alumni.nisn','=','users.nisn')
            ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
            ->where('alumni.tahun_lulus',$request->lulusan)
            ->orderBy('users.name')
            ->get();        

        }else if($request->tampilan=='Y'){
            $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
            ->join('alumni','alumni.nisn','=','users.nisn')
            ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
            ->whereRaw('penelusuran.nama_perusahaan!="null" or penelusuran.nama_kampus!="null" or penelusuran.pencaker!="null"')
            ->orderBy('users.name')
            ->get();    

        }else if ($request->tampilan=='T') {
            $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
            ->join('alumni','alumni.nisn','=','users.nisn')
            ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
            ->where('penelusuran.nama_perusahaan',null)->where('penelusuran.nama_kampus',null)->where('penelusuran.pencaker',null)
            ->orderBy('users.name')
            ->get();    

        }else if($request->tampilan==0){
            $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
            ->join('alumni','alumni.nisn','=','users.nisn')
            ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
            ->orderBy('users.name')
            ->get();        

        }else if($request->jurusan==0 && $request->lulusan==0 && $request->tampilan==0){
            $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
            ->join('alumni','alumni.nisn','=','users.nisn')
            ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
            ->orderBy('users.name')
            ->get();        

        }else if($request->jurusan && $request->lulusan){
            $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
            ->join('alumni','alumni.nisn','=','users.nisn')
            ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
            ->whereRaw('alumni.jurusan="'.$request->jurusan.'" and alumni.tahun_lulus="'.$request->lulusan.'"')
            ->orderBy('users.name')
            ->get();        

        }else if($request->jurusan && $request->lulusan){
            if ($request->tampilan=='Y') {
                $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
                ->join('alumni','alumni.nisn','=','users.nisn')
                ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
                ->whereRaw('penelusuran.nama_perusahaan!="null" or penelusuran.nama_kampus!="null" or penelusuran.pencaker!="null" and alumni.jurusan="'.$request->jurusan.'" and alumni.tahun_lulus="'.$request->lulusan.'"')
                ->orderBy('users.name')
                ->get();    
            }else if($request->tampilan=='T'){
            $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
            ->join('alumni','alumni.nisn','=','users.nisn')
            ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
            ->where('penelusuran.nama_perusahaan',null)
            ->where('penelusuran.nama_kampus',null)
            ->where('penelusuran.pencaker',null)
            ->whereRaw('alumni.jurusan="'.$request->jurusan.'" and alumni.tahun_lulus="'.$request->lulusan.'"')
            ->orderBy('users.name')
            ->get();    

            }
        }
      
        $jurusan = DB::table('jurusan')->get();
        $warna = ['','','','','oval',''];
        $lulusan = alumni::select('tahun_lulus')->groupBy('tahun_lulus')->get();
        return view('Admin/datapenelusuran',['penelusuran' => $penelusuran,'warna'=>$warna,'jurusan'=>$jurusan,'lulusan'=>$lulusan]);
    
    }
    public function tambahjurusan(Request $request)
    {
        DB::table('jurusan')->insert([
            'nama_jurusan' => $request->namajurusan
        ]);
        Session::flash('success', 'Berhasil menambah jurusan '.$request->nama_jurusan);
        return redirect('/datajurusan');
    }
    public function hapusjurusan($id)
    {
        DB::table('jurusan')->where('id_jurusan',$id)->delete();
        Session::flash('success', 'Berhasil menghapus jurusan');
        return redirect('/datajurusan');
    }
    public function editjurusan(Request $request)
    {
        DB::table('jurusan')->where('id_jurusan',$request->id)->update([
            'nama_jurusan' => $request->namajurusan
        ]);
        Session::flash('success', 'Berhasil mengedit jurusan');
        return redirect('/datajurusan');
    }
    public function tambahalumni(Request $request)
    {
        $rules = [
           'nisn'                  => 'required|numeric|unique:users,nisn',
           'namalengkap'           => 'required|min:3|max:35',
           'email'                 => 'required|email|unique:users,email',
           'tahunlulus'            => 'required|numeric'
       ];

       $messages = [
           'nisn.required'         => 'NISN wajib diisi',
           'nisn.numeric'          => 'NISN harus angka',
           'nisn.unique'           => 'Nisn sudah terdaftar',
           'namalengkap.required'  => 'Nama Lengkap wajib diisi',
           'namalengkap.min'       => 'Nama lengkap minimal 3 karakter',
           'namalengkap.max'       => 'Nama lengkap maksimal 35 karakter',
           'tahunlulus.required'   => 'Tahun lulusan wajib diisi',
           'tahunlulus.numeric'    => 'Tahun lulusan hanya boleh angka',
           'email.required'        => 'Email wajib diisi',
           'email.email'           => 'Email tidak valid',
           'email.unique'          => 'Email sudah terdaftar'
       ];

       $validator = Validator::make($request->all(), $rules, $messages);

       if($validator->fails()){
        return redirect()->back()->withErrors($validator)->withInput($request->all);
    }
    if ($request->jurusan==0) {
        Session::flash('gagal', 'Jurusan harus dipilih');
        return redirect()->route('datajurusan');
    }else{
        $user = new User;
        $user->nisn = ucwords(strtolower($request->nisn));
        $user->name = ucwords(strtolower($request->namalengkap));
        $user->email = strtolower($request->email);
        $user->hak_akses = '1';
        $user->status_aktif = '1';
        $user->foto = 'default.png';
        $user->password = Hash::make($request->nisn);
        $user->email_verified_at = \Carbon\Carbon::now();
        $simpan = $user->save();
        DB::table('alumni')->insert([
            'nisn'          => ucwords(strtolower($request->nisn)),
            'jurusan'       => $request->jurusan,
            'tahun_lulus'   => ucwords(strtolower($request->tahunlulus))
        ]);
        DB::table('penelusuran')->insert([
            'nisn' =>ucwords(strtolower($request->nisn))
        ]);
        if($simpan){
            Session::flash('success', 'Berhasil menambah data alumni, silahkan hubungi alumni untuk login menggunakan NISN dan password default menggunakan NISN');
            return redirect()->route('datajurusan');
        } else {
            Session::flash('errors', ['' => 'Register gagal! Silahkan ulangi beberapa saat lagi']);
            return redirect()->route('datajurusan');
            }
        }
    }
    public function chatadmin()
    {
        $warna = ['','','','','',''];
        $history = DB::select('select name,foto,nisn from users u join pesan p on u.nisn=p.untuk or u.nisn=p.dari where p.dari='.Auth::user()->nisn.' or p.untuk='.Auth::user()->nisn.' group by name');
        return view('Admin/chat',['warna'=>$warna,'history'=>$history]);        
    }
    public function search($id)
    {
        $data = user::select('name','foto','nisn')->whereRaw('name LIKE "%'.$id.'%" limit 5')->get();
        echo json_encode($data);
    }
    public function kirimp($nisn,$pesan)
    {   
        $zona = time()+(60*60*7);
        DB::table('pesan')->insert([
            'id'    => Auth::user()->nisn,
            'dari'  => Auth::user()->nisn,
            'untuk' => $nisn,
            'isi'   => $pesan,
            'waktu' => gmdate('H:i',$zona)
        ]);
    }
    public function isichat($nisn)
    {
        $data = DB::select('select dari,isi,untuk,name,foto,waktu from pesan p join users u on p.untuk=u.nisn where dari='.Auth::user()->nisn.' and untuk='.$nisn.' or dari='.$nisn.' and untuk='.Auth::user()->nisn);
        echo json_encode($data);   
    }
}

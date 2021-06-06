<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Exception;
use File;
use Response;
use Validator;
use Hash;
use Session;
use App\Alumni;
use App\penelusuran;
use App\perusahaan;
use App\informasi;
use App\berkas_lamaran;
use App\User;
class HubinController extends Controller
{
    public function index(){
        $penelusuran = penelusuran::whereRaw('nama_perusahaan!="null" or nama_kampus!="null" or pencaker!="null"')->get();
        $all = penelusuran::all();
        $sesuai = penelusuran::where('sesuai_kompetensi','Y')->get();
        $kesesuaian = penelusuran::whereRaw('sesuai_kompetensi="Y" or sesuai_kompetensi="T"')->get();
        $bekerja = penelusuran::where('pencaker','T')->get();
        $pencaker = penelusuran::where('pencaker','Y')->get();
        $kuliah = penelusuran::where('nama_perusahaan',null)->where('pencaker','B')->get();
        $tidakisi = penelusuran::where('nama_perusahaan',null)->where('nama_kampus',null)->where('pencaker',null)->get();
        $warna = ['oval','','','','',''];
        $countjurusan = DB::select('select count(penelusuran.nama_perusahaan)jumlah,
            count(if(sesuai_kompetensi="Y",sesuai_kompetensi,null))as kesesuaian,
            count(if(sesuai_kompetensi="T",sesuai_kompetensi,null))as tdksesuai, 
            count(if(kepuasan="Y", kepuasan,null))as kepuasan,
            count(if(kepuasan="T", kepuasan,null))as tdkpuas,
            count(if(pencaker="Y", pencaker,null))as pnckr,
            jurusan.id_jurusan,jurusan.nama_jurusan,alumni.tahun_lulus 
            from alumni join penelusuran on penelusuran.nisn=alumni.nisn 
            join jurusan on alumni.jurusan=jurusan.id_jurusan 
            where nama_perusahaan!="null" or pencaker="Y" group by nama_jurusan order by jumlah desc');
        return view('Hubin/index',['penelusuran' => $penelusuran, 'sesuai' => $sesuai, 'bekerja' => $bekerja, 'pencaker' => $pencaker, 'kuliah' => $kuliah, 'kesesuaian' => $kesesuaian, 'tidakisi' => $tidakisi, 'all'=>$all,'warna'=>$warna,'countjurusan'=> $countjurusan]);
    }public function dashboard()
    {
        $jurusan = DB::select('select jurusan.id_jurusan,jurusan.nama_jurusan,count(nama_jurusan)jumlah,alumni.tahun_lulus from penelusuran left join alumni on penelusuran.nisn=alumni.nisn left join jurusan on alumni.jurusan=jurusan.id_jurusan where nama_perusahaan!="null" group by nama_jurusan');
        $perusahaan = DB::select('select nama_perusahaan, count(nama_perusahaan)as jumlah,count(if(sesuai_kompetensi="Y",sesuai_kompetensi,null))as kesesuaian, count(if(kepuasan="Y", kepuasan,null))as kepuasan from penelusuran where nama_perusahaan!="null" group by nama_perusahaan');
        $kelistrikan = DB::select("select count(nama_perusahaan)jumlah,count(*)-count(nama_perusahaan)kosong,nama_jurusan,id_jurusan,tahun_lulus,count(if(sesuai_kompetensi='Y',sesuai_kompetensi,null))as kesesuaian,nama_perusahaan from penelusuran join alumni on penelusuran.nisn=alumni.nisn join jurusan on alumni.jurusan=jurusan.id_jurusan group by nama_jurusan");
        $jmlthn = DB::select('select tahun_lulus from alumni group by tahun_lulus');
        $alljrsn = DB::table('jurusan')->whereRaw('id_jurusan!=6')->get();
        $warna = ['oval','','','','',''];
        foreach ($alljrsn as $th) {
            $th2018 []=[ 
                'tahun'=>'2018',
                'id_jurusan'=>$th->id_jurusan,
                'nama_jurusan'=>$th->nama_jurusan,
                'jumlah'=>$this->jmljurusan($th->id_jurusan,'2018'),
            ];
            $th2019 []=[ 
                'tahun'=>'2019',
                'id_jurusan'=>$th->id_jurusan,
                'nama_jurusan'=>$th->nama_jurusan,
                'jumlah'=>$this->jmljurusan($th->id_jurusan,'2019'),
            ];
            $th2020 []=[ 
                'tahun'=>'2020',
                'id_jurusan'=>$th->id_jurusan,
                'nama_jurusan'=>$th->nama_jurusan,
                'jumlah'=>$this->jmljurusan($th->id_jurusan,'2020'),
            ];
        }
        echo json_encode($th2018);
        die;
        return view('Hubin/dashboard',['warna'=>$warna,'jurusan'=>$jurusan,'perusahaan'=>$perusahaan,'kelistrikan'=>$kelistrikan,'jmlthn'=>$jmlthn,'th2018'=>$th2018,'th2019'=>$th2019,'th2020'=>$th2020]);
    }
    public function jmljurusan($jrsn,$thn)
    {
        $idjurusan = DB::select('select count(nama_jurusan)jumlah from penelusuran left join alumni on penelusuran.nisn=alumni.nisn left join jurusan on alumni.jurusan=jurusan.id_jurusan where pencaker!="Y" and pencaker!="B" and id_jurusan='.$jrsn.' and tahun_lulus="'.$thn.'"');
        foreach ($idjurusan as $k) {
            $jml= $k->jumlah;
        }
        return $jml;
    }
    public function datapenelusuran(){
    	$penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
        ->join('alumni','alumni.nisn','=','users.nisn')
        ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
        ->orderBy('users.name')
        ->get();
        
        $jurusan = DB::table('jurusan')->get();
        $warna = ['','','','','oval',''];
        $lulusan = alumni::select('tahun_lulus')->groupBy('tahun_lulus')->get();
        $ket = 'Semua data Alumni';
        return view('Hubin/datapenelusuran',['penelusuran' => $penelusuran,'warna'=>$warna,'jurusan'=>$jurusan,'lulusan'=>$lulusan,'ket'=>$ket]);
    }
    public function databelumisi(){
        $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
        ->join('alumni','alumni.nisn','=','users.nisn')
        ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
        ->where('nama_perusahaan',null)->where('nama_kampus',null)->where('pencaker',null)
        ->orderBy('users.name')
        ->get();
        
        $jurusan = DB::table('jurusan')->get();
        $warna = ['','','','','oval',''];
        $lulusan = alumni::select('tahun_lulus')->groupBy('tahun_lulus')->get();
        $ket = 'Data belum isi penelusuran';
        return view('Hubin/datapenelusuran',['penelusuran' => $penelusuran,'warna'=>$warna,'jurusan'=>$jurusan,'lulusan'=>$lulusan,'ket'=>$ket]);
    }
    public function databekerja(){
        $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
        ->join('alumni','alumni.nisn','=','users.nisn')
        ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
        ->whereRaw('nama_perusahaan!="null"')
        ->orderBy('users.name')
        ->get();
        
        $jurusan = DB::table('jurusan')->get();
        $warna = ['','','','','oval',''];
        $lulusan = alumni::select('tahun_lulus')->groupBy('tahun_lulus')->get();
        $ket = 'Alumni yang bekerja';
        return view('Hubin/datapenelusuran',['penelusuran' => $penelusuran,'warna'=>$warna,'jurusan'=>$jurusan,'lulusan'=>$lulusan,'ket'=>$ket]);
    }
    public function datapencaker(){
        $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
        ->join('alumni','alumni.nisn','=','users.nisn')
        ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
        ->where('pencaker','Y')
        ->orderBy('users.name')
        ->get();
        
        $jurusan = DB::table('jurusan')->get();
        $warna = ['','','','','oval',''];
        $lulusan = alumni::select('tahun_lulus')->groupBy('tahun_lulus')->get();
        $ket = 'Alumni yang belum bekerja';
        return view('Hubin/datapenelusuran',['penelusuran' => $penelusuran,'warna'=>$warna,'jurusan'=>$jurusan,'lulusan'=>$lulusan,'ket'=>$ket]);
    }
    public function datakuliah(){
        $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
        ->join('alumni','alumni.nisn','=','users.nisn')
        ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
        ->whereRaw('nama_kampus!="null"')
        ->orderBy('users.name')
        ->get();
        
        $jurusan = DB::table('jurusan')->get();
        $warna = ['','','','','oval',''];
        $lulusan = alumni::select('tahun_lulus')->groupBy('tahun_lulus')->get();
        $ket = 'Alumni yang melanjutkan sekolah';
        return view('Hubin/datapenelusuran',['penelusuran' => $penelusuran,'warna'=>$warna,'jurusan'=>$jurusan,'lulusan'=>$lulusan,'ket'=>$ket]);
    }
    public function datasesuai(){
        $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
        ->join('alumni','alumni.nisn','=','users.nisn')
        ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
        ->where('sesuai_kompetensi','Y')
        ->orderBy('users.name')
        ->get();
        
        $jurusan = DB::table('jurusan')->get();
        $warna = ['','','','','oval',''];
        $lulusan = alumni::select('tahun_lulus')->groupBy('tahun_lulus')->get();
        $ket = 'kesesuaian jurusan';
        return view('Hubin/datapenelusuran',['penelusuran' => $penelusuran,'warna'=>$warna,'jurusan'=>$jurusan,'lulusan'=>$lulusan,'ket'=>$ket]);
    }
    public function dataalumni()
    {
    	$alumni = alumni::join('users','alumni.nisn','=','users.nisn')
        ->join('penelusuran','alumni.nisn','=','penelusuran.nisn')
        ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
        ->orderBy('users.name')
        ->get();         
        $jurusan = DB::table('jurusan')->get();
        $warna = ['','oval','','','',''];
        $lulusan = alumni::select('tahun_lulus')->groupBy('tahun_lulus')->get();
      return view('Hubin/dataalumni',['alumni' => $alumni,'warna'=>$warna,'jurusan'=>$jurusan,'lulusan'=>$lulusan]);
  }

  public function dataperusahaan()
  {
    $perusahaan = DB::select('select nama_perusahaan, count(nama_perusahaan)as jumlah,
        count(if(sesuai_kompetensi="Y",sesuai_kompetensi,null))as kesesuaian,
        count(if(sesuai_kompetensi="T",sesuai_kompetensi,null))as tdksesuai, 
        count(if(kepuasan="Y", kepuasan,null))as kepuasan,
        count(if(kepuasan="T", kepuasan,null))as tdkpuas from penelusuran 
        where nama_perusahaan!="null" group by nama_perusahaan');
    $warna = ['','','','','','oval'];
    return view('Hubin/dataperusahaan',['perusahaan' => $perusahaan,'warna'=>$warna]);
    }

    public function addinformasi()
    {
        $info = informasi::orderBy('created_at','desc')->get();
        $warna = ['','','','oval','',''];
        return view('Hubin/addinformasi',['info' => $info,'warna'=>$warna]);
    }
    public function tambahinformasi(Request $request)
    {
        $rules = [
                'file' => 'file|image|mimes:jpeg,png,jpg|max:2048',
                'judul' => 'required',
                'buka_lamaran' => 'required',
                'isi' => 'required'
          ];
         $messages = [
                'judul.required'        => 'Judul informasi harus diisi',
                'isi.required'          => 'Isi informasi harus diisi',
                'file.image'            => 'File harus Foto',
                'file.mimes'            => 'File yang diperbolehkan jpeg,png,jpg',
                'file.max'              => 'ukuran max 2 mb',
                'buka_lamaran.required' => 'Mohon pilih buka lamaran, Ya atau Tidak'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }
     if ($request->file!=null) {
            $file = $request->file('file');
            $nama_file = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'data_file/informasi';
            $file->move($tujuan_upload,$nama_file);

            informasi::create([
                'judul'         => $request->judul,
                'isi'           => $request->isi,
                'foto'          => $nama_file,
                'buka_apply'    => $request->buka_lamaran
            ]);
        }
        else{
            informasi::create([
                'judul'         => $request->judul,
                'isi'           => $request->isi,
                'buka_apply'    => $request->buka_lamaran
            ]);
        }
        Session::flash('success', 'Berhasil menambah informasi '.$request->judul);
        return redirect()->route('addinformasi');
    }
    public function editinformasi(Request $request)
    {
        $rules = [
                'file'          => 'file|image|mimes:jpeg,png,jpg|max:2048',
                'judul'         => 'required',
                'buka_lamaran'  => 'required',
                'isi'           => 'required'
          ];
         $messages = [
                'judul.required'        => 'Judul informasi harus diisi',
                'isi.required'          => 'Isi informasi harus diisi',
                'file.image'            => 'File harus Foto',
                'file.mimes'            => 'File yang diperbolehkan jpeg,png,jpg',
                'file.max'              => 'ukuran max 2 mb',
                'buka_lamaran.required' => 'Mohon pilih buka lamaran, Ya atau Tidak'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }
     if ($request->file!=null) {
            $file = $request->file('file');
            $nama_file = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'data_file/informasi';
            $file->move($tujuan_upload,$nama_file);

            informasi::where('id',$request->id)->update([
                'judul'         => $request->judul,
                'isi'           => $request->isi,
                'foto'          => $nama_file,
                'buka_apply'    => $request->buka_lamaran
            ]);
        }
        else{
            informasi::where('id',$request->id)->update([
                'judul'         => $request->judul,
                'isi'           => $request->isi,
                'buka_apply'    => $request->buka_lamaran
            ]);
        }
        Session::flash('success', 'Berhasil mengedit informasi '.$request->judul);
        return redirect()->route('addinformasi');   
    }
    public function hapusinformasi($id)
    {
        informasi::where('id',$id)->delete();
        Session::flash('hapus', 'Berhasil menghapus informasi');
        return redirect()->route('addinformasi');   
    }
    public function datalamaran()
    {
        $berkas = DB::select('select untuk_perusahaan, count(file_lamaran)jumlah from berkas_lamaran group by untuk_perusahaan');
        $warna = ['','','oval','','',''];
        return view('Hubin/applylamaran',['berkas' => $berkas,'warna'=>$warna]);        
    }
    public function datapelamar($id)
    {
        $pelamar = DB::select('select berkas_lamaran.untuk_perusahaan,berkas_lamaran.file_lamaran, users.name, users.email, berkas_lamaran.created_at from berkas_lamaran join users on berkas_lamaran.nisn=users.nisn where untuk_perusahaan="'.$id.'"');
        $warna = ['','','oval','','',''];
        return view('Hubin/datalamaran',['pelamar'=> $pelamar,'warna'=>$warna]);
    }
    public function getlamaran($filename,$id)
    {
       return response()->download(Storage::disk('public')->get('index.php'));
       $pelamar = DB::select('select berkas_lamaran.untuk_perusahaan,berkas_lamaran.file_lamaran, users.name, users.email, berkas_lamaran.created_at from berkas_lamaran join users on berkas_lamaran.nisn=users.nisn where untuk_perusahaan="'.$id.'"');
       $warna = ['','','oval','','',''];
       return view('Hubin/datalamaran',['pelamar'=> $pelamar,'warna'=>$warna]);         
   }
    public function profile()
    {
        $warna = ['','','','','',''];
        return view('Hubin/profilehubin',['warna'=>$warna]);
    }
    public function gantipass(Request $request)
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
    public function alumniBy_jurusan_tahun(Request $request)
    {
        if ($request->jurusan && $request->lulusan==null) {
            $alumni = alumni::join('users','alumni.nisn','=','users.nisn')
                    ->join('penelusuran','alumni.nisn','=','penelusuran.nisn')
                    ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
                    ->whereRaw('alumni.jurusan="'.$request->jurusan.'" and alumni.tahun_lulus="null"')
                    ->orderBy('users.name')
                    ->get();               

        }else if($request->lulusan==null){
            $alumni = alumni::join('users','alumni.nisn','=','users.nisn')
                    ->join('penelusuran','alumni.nisn','=','penelusuran.nisn')
                    ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
                    ->where('alumni.tahun_lulus',null)
                    ->orderBy('users.name')
                    ->get();                        

        }else if ($request->jurusan==0 && $request->lulusan==0) {
            $alumni = alumni::join('users','alumni.nisn','=','users.nisn')
                    ->join('penelusuran','alumni.nisn','=','penelusuran.nisn')
                    ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
                    ->orderBy('users.name')
                    ->get();               

        }else if($request->lulusan && $request->jurusan){
            $alumni = alumni::join('users','alumni.nisn','=','users.nisn')
                    ->join('penelusuran','alumni.nisn','=','penelusuran.nisn')
                    ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
                    ->whereRaw('alumni.jurusan="'.$request->jurusan.'" and alumni.tahun_lulus="'.$request->lulusan.'"')
                    ->orderBy('users.name')
                    ->get();               
                    
        }else if($request->jurusan){
            $alumni = alumni::join('users','alumni.nisn','=','users.nisn')
                    ->join('penelusuran','alumni.nisn','=','penelusuran.nisn')
                    ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
                    ->where('alumni.jurusan',$request->jurusan)
                    ->orderBy('users.name')
                    ->get();                        

        }else if($request->lulusan){
            $alumni = alumni::join('users','alumni.nisn','=','users.nisn')
                    ->join('penelusuran','alumni.nisn','=','penelusuran.nisn')
                    ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
                    ->where('alumni.tahun_lulus',$request->lulusan)
                    ->orderBy('users.name')
                    ->get();                        
        }
        $jurusan = DB::table('jurusan')->get();
        $warna = ['','oval','','','',''];
        $lulusan = alumni::select('tahun_lulus')->groupBy('tahun_lulus')->get();
        
        return view('Hubin/dataalumni',['alumni' => $alumni,'warna'=>$warna,'jurusan'=>$jurusan,'lulusan'=>$lulusan]);
    }
    public function penelusuranBy_jurusan_tahun(Request $request)
    {
        if($request->jurusan && $request->lulusan==null){
            $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
            ->join('alumni','alumni.nisn','=','users.nisn')
            ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
            ->whereRaw('alumni.jurusan="'.$request->jurusan.'" and alumni.tahun_lulus="null"')
            ->orderBy('users.name')
            ->get();        
            $ket = 'Data jurusan '.$request->jurusan;

        }else if($request->lulusan==null){
            $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
            ->join('alumni','alumni.nisn','=','users.nisn')
            ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
            ->where('alumni.tahun_lulus',null)
            ->orderBy('users.name')
            ->get();        
            $ket = '';

        }else if($request->jurusan){
            $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
            ->join('alumni','alumni.nisn','=','users.nisn')
            ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
            ->where('alumni.jurusan',$request->jurusan)
            ->orderBy('users.name')
            ->get(); 
            $ket = 'Data jurusan '.$request->jurusan;       

        }else if($request->lulusan){
            $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
            ->join('alumni','alumni.nisn','=','users.nisn')
            ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
            ->where('alumni.tahun_lulus',$request->lulusan)
            ->orderBy('users.name')
            ->get();        
            $ket = 'Data lulusan '.$request->lulusan;

        }else if($request->tampilan=='Y'){
            $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
            ->join('alumni','alumni.nisn','=','users.nisn')
            ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
            ->whereRaw('penelusuran.nama_perusahaan!="null" or penelusuran.nama_kampus!="null" or penelusuran.pencaker!="null"')
            ->orderBy('users.name')
            ->get();    
            $ket = 'Mengisi data penelusuran';

        }else if ($request->tampilan=='T') {
            $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
            ->join('alumni','alumni.nisn','=','users.nisn')
            ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
            ->where('penelusuran.nama_perusahaan',null)->where('penelusuran.nama_kampus',null)->where('penelusuran.pencaker',null)
            ->orderBy('users.name')
            ->get();    
            $ket = 'Belum isi data penelusuran';

        }else if($request->tampilan==0){
            $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
            ->join('alumni','alumni.nisn','=','users.nisn')
            ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
            ->orderBy('users.name')
            ->get();        
            $ket = '';

        }else if($request->jurusan==0 && $request->lulusan==0 && $request->tampilan==0){
            $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
            ->join('alumni','alumni.nisn','=','users.nisn')
            ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
            ->orderBy('users.name')
            ->get();
            $ket = '';        

        }else if($request->jurusan && $request->lulusan){
            $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
            ->join('alumni','alumni.nisn','=','users.nisn')
            ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
            ->whereRaw('alumni.jurusan="'.$request->jurusan.'" and alumni.tahun_lulus="'.$request->lulusan.'"')
            ->orderBy('users.name')
            ->get(); 
            $ket = 'Data '.$request->jurusan.', '.$request->lulusan;       

        }else if($request->jurusan && $request->lulusan){
            if ($request->tampilan=='Y') {
                $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
                ->join('alumni','alumni.nisn','=','users.nisn')
                ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
                ->whereRaw('penelusuran.nama_perusahaan!="null" or penelusuran.nama_kampus!="null" or penelusuran.pencaker!="null" and alumni.jurusan="'.$request->jurusan.'" and alumni.tahun_lulus="'.$request->lulusan.'"')
                ->orderBy('users.name')
                ->get();    
                $ket = 'Mengisi, '.$request->jurusan.', '.$request->lulusan;                
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
            $ket = 'Tidak isi, '.$request->jurusan.', '.$request->lulusan;                

            }
        }
      
        $jurusan = DB::table('jurusan')->get();
        $warna = ['','','','','oval',''];
        $lulusan = alumni::select('tahun_lulus')->groupBy('tahun_lulus')->get();
        return view('Hubin/datapenelusuran',['penelusuran' => $penelusuran,'warna'=>$warna,'jurusan'=>$jurusan,'lulusan'=>$lulusan,'ket'=>$ket]);
    }

}

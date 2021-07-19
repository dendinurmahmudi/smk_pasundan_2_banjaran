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
use Mail;
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
        $lulusan = alumni::select('tahun_lulus')->groupBy('tahun_lulus')->get();
        return view('Hubin/index',['penelusuran' => $penelusuran, 'sesuai' => $sesuai, 'bekerja' => $bekerja, 'pencaker' => $pencaker, 'kuliah' => $kuliah, 'kesesuaian' => $kesesuaian, 'tidakisi' => $tidakisi, 'all'=>$all,'warna'=>$warna,'countjurusan'=> $countjurusan,'lulusan'=>$lulusan]);
    }public function dashboard()
    {
        $jurusan = DB::select('select jurusan.id_jurusan,jurusan.nama_jurusan,count(nama_jurusan)jumlah,alumni.tahun_lulus from penelusuran left join alumni on penelusuran.nisn=alumni.nisn left join jurusan on alumni.jurusan=jurusan.id_jurusan where nama_perusahaan!="null" group by nama_jurusan');
        $perusahaan = DB::select('select nama_perusahaan, count(nama_perusahaan)as jumlah,count(if(sesuai_kompetensi="Y",sesuai_kompetensi,null))as kesesuaian, count(if(kepuasan="Y", kepuasan,null))as kepuasan from penelusuran where nama_perusahaan!="null" group by nama_perusahaan');
        $kelistrikan = DB::select("select count(nama_perusahaan)jumlah,count(*)-count(nama_perusahaan)kosong,nama_jurusan,id_jurusan,tahun_lulus,count(if(sesuai_kompetensi='Y',sesuai_kompetensi,null))as kesesuaian,nama_perusahaan from penelusuran join alumni on penelusuran.nisn=alumni.nisn join jurusan on alumni.jurusan=jurusan.id_jurusan group by nama_jurusan");
        $jmlthn = DB::select('select tahun_lulus from alumni group by tahun_lulus');
        $alljrsn = DB::table('jurusan')->whereRaw('id_jurusan!=6')->get();

        $warna = ['oval','','','','',''];
        foreach ($jmlthn as $k) {
                foreach ($alljrsn as $th) {
            $datatahun[] = [
                'tahun' => $k->tahun_lulus,
                    'id_jurusan'=>$th->id_jurusan,
                    'nama_jurusan'=>$th->nama_jurusan,
                    'jumlah'=>$this->jmljurusan($th->id_jurusan,$k->tahun_lulus),
                    'pencaker'=>$this->jmlpnckr($th->id_jurusan,$k->tahun_lulus),
                    'kosong'=>$this->jmlkosong($th->id_jurusan,$k->tahun_lulus),
                    'sesuai'=>$this->jmlsesuai($th->id_jurusan,$k->tahun_lulus),
            ];
                }
        }
        foreach ($alljrsn as $th) {
            $th2018[] =[ 
                'tahun'=>'2018',
                'id_jurusan'=>$th->id_jurusan,
                'nama_jurusan'=>$th->nama_jurusan,
                'jumlah'=>$this->jmljurusan($th->id_jurusan,'2018'),
                'pencaker'=>$this->jmlpnckr($th->id_jurusan,'2018'),
                'kosong'=>$this->jmlkosong($th->id_jurusan,'2018'),
                'sesuai'=>$this->jmlsesuai($th->id_jurusan,'2018'),
            ];
            $th2019[] =[ 
                'tahun'=>'2019',
                'id_jurusan'=>$th->id_jurusan,
                'nama_jurusan'=>$th->nama_jurusan,
                'jumlah'=>$this->jmljurusan($th->id_jurusan,'2019'),
                'pencaker'=>$this->jmlpnckr($th->id_jurusan,'2019'),
                'kosong'=>$this->jmlkosong($th->id_jurusan,'2019'),
                'sesuai'=>$this->jmlsesuai($th->id_jurusan,'2019'),
            ];
            $th2020[] =[ 
                'tahun'=>'2020',
                'id_jurusan'=>$th->id_jurusan,
                'nama_jurusan'=>$th->nama_jurusan,
                'jumlah'=>$this->jmljurusan($th->id_jurusan,'2020'),
                'pencaker'=>$this->jmlpnckr($th->id_jurusan,'2020'),
                'kosong'=>$this->jmlkosong($th->id_jurusan,'2020'),
                'sesuai'=>$this->jmlsesuai($th->id_jurusan,'2020'),
            ];           
        }
        
        return view('Hubin/dashboard',['warna'=>$warna,'jurusan'=>$jurusan,'perusahaan'=>$perusahaan,'kelistrikan'=>$kelistrikan,'jmlthn'=>$jmlthn,'th2018'=>$th2018,'th2019'=>$th2019,'th2020'=>$th2020,'datatahun'=>$datatahun]);
    }
    public function jrsnprthn($tahun)
    {
        if ($tahun==0) {
            $data = DB::select('select count(penelusuran.nama_perusahaan)jumlah,
                count(if(sesuai_kompetensi="Y",sesuai_kompetensi,null))as kesesuaian,
                count(if(sesuai_kompetensi="T",sesuai_kompetensi,null))as tdksesuai, 
                count(if(kepuasan="Y", kepuasan,null))as kepuasan,
                count(if(kepuasan="T", kepuasan,null))as tdkpuas,
                count(if(pencaker="Y", pencaker,null))as pnckr,
                jurusan.id_jurusan,jurusan.nama_jurusan,alumni.tahun_lulus 
                from alumni join penelusuran on penelusuran.nisn=alumni.nisn 
                join jurusan on alumni.jurusan=jurusan.id_jurusan 
                where nama_perusahaan!="null" or pencaker="Y" group by nama_jurusan order by jumlah desc');
        }else{
            $data = DB::select('select count(penelusuran.nama_perusahaan)jumlah, count(if(sesuai_kompetensi="Y",sesuai_kompetensi,null))as kesesuaian, count(if(sesuai_kompetensi="T",sesuai_kompetensi,null))as tdksesuai, count(if(kepuasan="Y", kepuasan,null))as kepuasan, count(if(kepuasan="T", kepuasan,null))as tdkpuas, count(if(pencaker="Y", pencaker,null))as pnckr, jurusan.id_jurusan,jurusan.nama_jurusan from alumni join penelusuran on penelusuran.nisn=alumni.nisn join jurusan on alumni.jurusan=jurusan.id_jurusan where tahun_lulus="'.$tahun.'" group by nama_jurusan order by jumlah desc');
        }
        echo json_encode($data);
    }
    public function jmljurusan($jrsn,$thn)
    {
        $idjurusan = DB::select('select count(nama_jurusan)jumlah from penelusuran left join alumni on penelusuran.nisn=alumni.nisn left join jurusan on alumni.jurusan=jurusan.id_jurusan where pencaker!="Y" and pencaker!="B" and id_jurusan='.$jrsn.' and tahun_lulus="'.$thn.'"');
        foreach ($idjurusan as $k) {
            $jml= $k->jumlah;
        }
        return $jml;
    }
    public function jmlkosong($id,$thn)
    {
        $jrsn = DB::select('select count(*)-count(nama_perusahaan)kosong from penelusuran left join alumni on penelusuran.nisn=alumni.nisn left join jurusan on alumni.jurusan=jurusan.id_jurusan where pencaker is null and id_jurusan='.$id.' and tahun_lulus="'.$thn.'"');
        foreach ($jrsn as $k) {
            $ksg= $k->kosong;
        }
        return $ksg;
    }
    public function jmlsesuai($id,$thn)
    {
        $jrs = DB::select('select count(if(sesuai_kompetensi="Y",sesuai_kompetensi,null))as kesesuaian from penelusuran left join alumni on penelusuran.nisn=alumni.nisn left join jurusan on alumni.jurusan=jurusan.id_jurusan where id_jurusan='.$id.' and tahun_lulus="'.$thn.'"');
        foreach ($jrs as $k) {
            $kss= $k->kesesuaian;
        }
        return $kss;
    }
    public function jmlpnckr($id,$thn)
    {
        $pnckr = DB::select('select count(if(pencaker="Y",pencaker,null))as pencaker from penelusuran left join alumni on penelusuran.nisn=alumni.nisn left join jurusan on alumni.jurusan=jurusan.id_jurusan where id_jurusan='.$id.' and tahun_lulus="'.$thn.'"');
        foreach ($pnckr as $p) {
            $pc= $p->pencaker;
        }
        return $pc;
    }
    public function datapenelusuran(){
    	$penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
        ->join('alumni','alumni.nisn','=','users.nisn')
        ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
        ->orderBy('users.name')
        ->get();
        
        $jurusan = DB::table('jurusan')->whereRaw('id_jurusan != 6')->get();
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
        $jurusan = DB::table('jurusan')->whereRaw('id_jurusan != 6')->get();
        $warna = ['','oval','','','',''];
        $lulusan = alumni::select('tahun_lulus')->groupBy('tahun_lulus')->get();
        return view('Hubin/dataalumni',['alumni' => $alumni,'warna'=>$warna,'jurusan'=>$jurusan,'lulusan'=>$lulusan]);
    }
    public function datatahunlulus()
    {   
        $alumni = DB::select('select tahun_lulus from alumni group by tahun_lulus');
        foreach ($alumni as $a) {    
            $jmlllsn[] = [
                'tahun' => $a->tahun_lulus,
                'jumlah' => $this->gettahun($a->tahun_lulus)
            ];
        }
        $warna = ['','oval','','','',''];
        return view('Hubin/tahunlulus',['alumni'=>$alumni,'jmlllsn' => $jmlllsn,'warna'=>$warna]);
    }
    public function gettahun($thn)
    {
        $tahun = DB::select('select name, count(tahun_lulus)jumlah from alumni join users on alumni.nisn=users.nisn where tahun_lulus="'.$thn.'"');
        foreach ($tahun as $t) {
            $jml = $t->jumlah;
        }
        return $jml;
    }
    public function dataperusahaan()
    {
        $peru = DB::select('select nama_perusahaan, count(nama_perusahaan)as jumlah,count(if(sesuai_kompetensi="Y",sesuai_kompetensi,null))as kesesuaian, count(if(kepuasan="Y", kepuasan,null))as kepuasan,count(tahun_lulus)jml from penelusuran join alumni on penelusuran.nisn=alumni.nisn where nama_perusahaan!="null" group by nama_perusahaan order by jumlah desc');

        foreach ($peru as $pt) {
            $perusahaan[]=[
                'nama_perusahaan'=>$pt->nama_perusahaan,
                'jumlah'=>$pt->jumlah,
                'kesesuaian'=>$pt->kesesuaian,
                'kepuasan'=>$pt->kepuasan,
                'jml'=>$pt->jml,
                'status'=>$this->statusperu($pt->nama_perusahaan),
            ];
        }
        $jmltahun = DB::select('select nama_perusahaan, tahun_lulus from penelusuran join alumni on penelusuran.nisn=alumni.nisn where nama_perusahaan!="null" group by tahun_lulus');
        $allprshn = DB::select('select nama_perusahaan,tahun_lulus from penelusuran p join alumni a on p.nisn=a.nisn');
        $warna = ['','','','','','oval'];
        return view('Hubin/dataperusahaan',['perusahaan' => $perusahaan,'warna'=>$warna,'jmltahun'=>$jmltahun,'allprshn'=>$allprshn]);
    }
    public function statusperu($pt)
    {
        $jml="";
        $nmprshn = DB::select('select status from perusahaan where nama_per="'.$pt.'"');
        foreach ($nmprshn as $k) {
            $jml= $k->status;
        }
        return $jml;
    }
    public function editperusahaan(Request $request)
    {
        if ($request->mou == null) {
            perusahaan::where('nama_per',$request->namaperusahaan)->delete();
        }else{
            perusahaan::create([
                'nama_per' => $request->namaperusahaan,
                'status'   => $request->mou
            ]);
        }
        Session::flash('success', 'Berhasil Mengedit status perusahaan '.$request->namaperusahaan);
        return redirect('/dataperusahaan');
    }
    public function confidence($perusahaan)
    {
        $data = DB::select('select tahun_lulus from penelusuran p join alumni a on p.nisn=a.nisn where nama_perusahaan="'.$perusahaan.'" group by tahun_lulus;');
        $hsl = count($data);
        // echo json_encode($hsl);
        return $hsl;
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
    public function get($filename)
    {
       $file = "./data_file/berkas_lamaran/".$filename;
       return Response::download($file);
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
public function chathubin()
{
    $warna = ['','','','','',''];
    $history = DB::select('select name,foto,nisn from users u join pesan p on u.nisn=p.untuk or u.nisn=p.dari where p.dari='.Auth::user()->nisn.' or p.untuk='.Auth::user()->nisn.' group by name');
    return view('Hubin/chat2',['warna'=>$warna,'history'=>$history]);        
}

public function search2($id)
{
    $data = user::select('name','foto','nisn')->whereRaw('name LIKE "%'.$id.'%" limit 5')->get();
    echo json_encode($data);
}
public function kirimp2($nisn,$pesan)
{   
    $zona = time()+(60*60*7);
    DB::table('pesan')->insert([
        'id'    => Auth::user()->nisn,
        'dari'  => Auth::user()->nisn,
        'untuk' => $nisn,
        'isi'   => $pesan,
        'waktu' => gmdate('d-m-Y H:i:s',$zona)
    ]);
}
public function isichat2($nisn)
{
    $data = DB::select('select dari,isi,untuk,name,foto,waktu from pesan p join users u on p.dari=u.nisn where dari='.Auth::user()->nisn.' and untuk='.$nisn.' or dari='.$nisn.' and untuk='.Auth::user()->nisn.' order by waktu');
    echo json_encode($data);   
}
public function kirimemail(Request $request)
{
    $user = DB::table('users')->whereRaw('hak_akses!="2" and hak_akses!="3" and hak_akses!="4"')->get();
    foreach ($user as $u) {
        try{
            Mail::send('Hubin/kirimemail', array('email' => $u->email) , function($pesan) use($request){
                $user = DB::table('users')->whereRaw('hak_akses!="2" and hak_akses!="3" and hak_akses!="4"')->get();
                foreach ($user as $u) {
                 $pesan->to($u->email,$u->email)->subject('Pemberitahuan pendataan penelusuran alumni');
                 $pesan->from(env('MAIL_USERNAME','careerdevcenter.smkpasundan@gmail.com'),'CareerDevCenterSMKPasundan2Banjaran');
             }
         });

        }catch (Exception $e){
            return response (['status' => false,'errors' => $e->getMessage()]);
        }
    }
    Session::flash('success', 'Email telah dikirim ke seluruh alumni');
    return redirect('/hubin');
}
public function prosesalgo()
{
    $lulusan = alumni::select('tahun_lulus')->groupBy('tahun_lulus')->get();
    $dataset = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
    ->join('alumni','alumni.nisn','=','users.nisn')
    ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
    ->whereRaw('nama_perusahaan is not null')
    ->orderBy('users.name')
    ->get();
    $peru2018 =DB::select('select nama_perusahaan, count(nama_perusahaan)jumlah from penelusuran right join alumni on penelusuran.nisn=alumni.nisn where nama_perusahaan!="null" and tahun_lulus="2018" group by nama_perusahaan order by jumlah desc');
    $peru2019 =DB::select('select nama_perusahaan, count(nama_perusahaan)jumlah from penelusuran right join alumni on penelusuran.nisn=alumni.nisn where nama_perusahaan!="null" and tahun_lulus="2019" group by nama_perusahaan order by jumlah desc');
    $peru2020 =DB::select('select nama_perusahaan, count(nama_perusahaan)jumlah from penelusuran right join alumni on penelusuran.nisn=alumni.nisn where nama_perusahaan!="null" and tahun_lulus="2020" group by nama_perusahaan order by jumlah desc');
    $allperu = DB::select('select nama_perusahaan, count(nama_perusahaan)jumlah from penelusuran right join alumni on penelusuran.nisn=alumni.nisn where nama_perusahaan!="null" group by nama_perusahaan order by jumlah desc');
    $allperuasc = DB::select('select nama_perusahaan, count(nama_perusahaan)jumlah,tahun_lulus from penelusuran right join alumni on penelusuran.nisn=alumni.nisn where nama_perusahaan!="null" group by nama_perusahaan order by jumlah asc');
    $jmltahun = DB::select('select nama_perusahaan, tahun_lulus from penelusuran join alumni on penelusuran.nisn=alumni.nisn where nama_perusahaan!="null" group by tahun_lulus');
    $allperu1 = DB::select('select nama_perusahaan , count(nama_perusahaan)jumlah from penelusuran  where nama_perusahaan!="null" group by nama_perusahaan');
    $all2d = DB::select('select nama_perusahaan , count(nama_perusahaan)jumlah from penelusuran  where nama_perusahaan!="null" group by nama_perusahaan order by count(nama_perusahaan) desc');
    $hslallperu = DB::select('select nama_perusahaan, count(nama_perusahaan)jumlah from penelusuran right join alumni on penelusuran.nisn=alumni.nisn where nama_perusahaan!="null" group by nama_perusahaan order by jumlah desc limit 3');

    foreach ($allperu1 as $k) {
        $fp2018[]=[
         'tahun'=>'2018',
         'nama_perusahaan'=>$k->nama_perusahaan,
         'jumlah'=>$this->jumlahbekerja($k->nama_perusahaan,'2018'),
     ];
     $fp2019[]=[
         'tahun'=>'2019',
         'nama_perusahaan'=>$k->nama_perusahaan,
         'jumlah'=>$this->jumlahbekerja($k->nama_perusahaan,'2019'),
     ];
     $fp2020[]=[
         'tahun'=>'2020',
         'nama_perusahaan'=>$k->nama_perusahaan,
         'jumlah'=>$this->jumlahbekerja($k->nama_perusahaan,'2020'),
         'total'=>$this->jumlahbekerjatotal($k->nama_perusahaan),
     ];
 }
 foreach ($allperu as $a) {
    if($a->jumlah/count($jmltahun) >= 1){
        $hasil[] =[
            'nama_perusahaan' => $a->nama_perusahaan,
            'jumlah' => $a->jumlah,
            'suport' => $a->jumlah/count($jmltahun)
        ];
    }
}
foreach ($allperu as $a) {
       $hslfp2018[]=[
         'tahun'=>'2018',
         'nama_perusahaan'=>$a->nama_perusahaan,
         'jumlah'=>$this->jumlahbekerja($a->nama_perusahaan,'2018'),
     ];
     $hslfp2019[]=[
         'tahun'=>'2019',
         'nama_perusahaan'=>$a->nama_perusahaan,
         'jumlah'=>$this->jumlahbekerja($a->nama_perusahaan,'2019'),
     ];
     $hslfp2020[]=[
         'tahun'=>'2020',
         'nama_perusahaan'=>$a->nama_perusahaan,
         'jumlah'=>$this->jumlahbekerja($a->nama_perusahaan,'2020'),
         'total'=>$this->jumlahbekerjatotal($a->nama_perusahaan),
     ];
}
foreach ($allperuasc as $a) {
    if($a->jumlah/count($jmltahun) >= 1){
        $hasilasc[] =[
            'nama_perusahaan' => $a->nama_perusahaan,
            'jumlah' => $this->nama_pt_anak($a->nama_perusahaan,$a->jumlah,$a->tahun_lulus),
            'suport' => $a->jumlah
        ];
    }
}

$i=0;

foreach ($all2d as $a) {
    $j=0;
    foreach ($all2d as $b) {
        $jumlah=$b->jumlah;
        if ($a->jumlah<=$b->jumlah) {
            $jumlah=$a->jumlah;
        }
        $hasil2d[$i][$j] =[
            'nama_perusahaana' => $a->nama_perusahaan,
            'nama_perusahaanb' => $b->nama_perusahaan,
            'frekuensi' => $jumlah,
            'confidence'=> $this->confidence($a->nama_perusahaan),
        ];
        $j++;
    }
    $i++;
}

$warna = ['','','','','','oval'];
return view('Hubin/prosesalgo',['peru2018'=>$peru2018,'peru2019'=>$peru2019,'peru2020'=>$peru2020,'allperu'=>$allperu,'jmltahun'=>$jmltahun,'hasil'=>$hasil,'dataset'=>$dataset,'warna'=>$warna,'allperu1'=>$allperu1,'fp2018'=>$fp2018,'fp2019'=>$fp2019,'fp2020'=>$fp2020,'hasilasc'=>$hasilasc,'hasil2d'=>$hasil2d,'hslfp2018'=>$hslfp2018,'hslfp2019'=>$hslfp2019,'hslfp2020'=>$hslfp2020,'hslallperu'=>$hslallperu]);
}

public function nama_pt_anak($nama_perusahaan,$jumlah,$tahun){
    $ptpt='';
     $allperu1 = DB::select('select nama_perusahaan,count(nama_perusahaan) jumlah from penelusuran join alumni on penelusuran.nisn=alumni.nisn
        where nama_perusahaan<>"'.$nama_perusahaan.'"  group by nama_perusahaan order by jumlah desc');
     foreach ($allperu1 as $a) {
         if ($a->jumlah >= $jumlah) {
             $ptpt .=  $a->nama_perusahaan.', ';
         }
     }
    return $ptpt;
}


public function jumlahbekerja($p,$t)
{
    $namap = DB::select('select nama_perusahaan, count(nama_perusahaan)jumlah from penelusuran right join alumni on penelusuran.nisn=alumni.nisn where nama_perusahaan="'.$p.'" and tahun_lulus="'.$t.'"');
    foreach ($namap as $n) {
        $jumlah = $n->jumlah;
    }
    return $jumlah;
}
public function jumlahbekerjatotal($p)
{
    $namap = DB::select('select nama_perusahaan, count(nama_perusahaan)jumlah from penelusuran right join alumni on penelusuran.nisn=alumni.nisn where nama_perusahaan="'.$p.'"');
    foreach ($namap as $n) {
        $jumlah = $n->jumlah;
    }
    return $jumlah;
}
public function getperusahaan($tahun)
{
    $nmprshn = DB::select('select nama_perusahaan, count(nama_perusahaan)jumlah from penelusuran right join alumni on penelusuran.nisn=alumni.nisn where nama_perusahaan!="null" and tahun_lulus="'.$tahun.'" group by nama_perusahaan order by jumlah desc');
    foreach ($nmprshn as $k) {
        $jml= $k->nama_perusahaan;
    }
    return $jml;
}

}

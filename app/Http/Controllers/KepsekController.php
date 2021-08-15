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
class KepsekController extends Controller
{
	public function index()
	{
             $penelusuran = penelusuran::whereRaw('nama_perusahaan!="null" or nama_kampus!="null" or pencaker!="null"')->get();
             $sesuai = penelusuran::where('sesuai_kompetensi','Y')->get();
             $kesesuaian = penelusuran::whereRaw('sesuai_kompetensi="Y" or sesuai_kompetensi="T"')->get();
             $bekerja = penelusuran::where('pencaker','T')->get();
             $pencaker = penelusuran::where('pencaker','Y')->get();
             $kuliah = penelusuran::where('nama_perusahaan',null)->where('pencaker','B')->get();
             $tidakisi = penelusuran::where('nama_perusahaan',null)->where('nama_kampus',null)->where('pencaker',null)->get();
             $warna = ['oval','','',''];
             $countjurusan = DB::select('select count(penelusuran.nama_perusahaan)jumlah,
                    count(if(sesuai_kompetensi="Y",sesuai_kompetensi,null))as kesesuaian,
                    count(if(sesuai_kompetensi="T",sesuai_kompetensi,null))as tdksesuai, 
                    count(if(kepuasan="Y", kepuasan,null))as kepuasan,
                    count(if(kepuasan="T", kepuasan,null))as tdkpuas,
                    jurusan.id_jurusan,jurusan.nama_jurusan,alumni.tahun_lulus 
                    from alumni join penelusuran on penelusuran.nisn=alumni.nisn 
                    join jurusan on alumni.jurusan=jurusan.id_jurusan 
                    where nama_perusahaan!="null" group by nama_jurusan order by jumlah desc');
             return view('Kepsek/index',['penelusuran' => $penelusuran, 'sesuai' => $sesuai, 'bekerja' => $bekerja, 'pencaker' => $pencaker, 'kuliah' => $kuliah, 'kesesuaian' => $kesesuaian, 'tidakisi' => $tidakisi,'warna'=>$warna,'countjurusan'=> $countjurusan]);
        }
        public function datapenelusuran1(){
                $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
                ->join('alumni','alumni.nisn','=','users.nisn')
                ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
                ->orderBy('users.name')
                ->get();
                
                $jurusan = DB::table('jurusan')->get();
                $warna = ['','','oval',''];
                $lulusan = alumni::select('tahun_lulus')->groupBy('tahun_lulus')->get();
                $ket = 'Semua data Alumni';
                return view('Kepsek/datapenelusuran',['penelusuran' => $penelusuran,'warna'=>$warna,'jurusan'=>$jurusan,'lulusan'=>$lulusan,'ket'=>$ket]);
        }
        public function dataalumni1()
        {
                $alumni = alumni::join('users','alumni.nisn','=','users.nisn')
                ->join('penelusuran','alumni.nisn','=','penelusuran.nisn')
                ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
                ->orderBy('users.name')
                ->get();         
                $jurusan = DB::table('jurusan')->get();
                $warna = ['','oval','',''];
                $lulusan = alumni::select('tahun_lulus')->groupBy('tahun_lulus')->get();
                return view('Kepsek/dataalumni',['alumni' => $alumni,'warna'=>$warna,'jurusan'=>$jurusan,'lulusan'=>$lulusan]);
        }
        public function dataperusahaan1()
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
            $warna = ['','','','oval'];
            return view('Kepsek/dataperusahaan',['perusahaan' => $perusahaan,'warna'=>$warna]);
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
        public function databekerja1(){
        $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
        ->join('alumni','alumni.nisn','=','users.nisn')
        ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
        ->whereRaw('nama_perusahaan!="null"')
        ->orderBy('users.name')
        ->get();
        
        $jurusan = DB::table('jurusan')->get();
        $warna = ['','','oval',''];
        $lulusan = alumni::select('tahun_lulus')->groupBy('tahun_lulus')->get();
        $ket = 'Alumni yang bekerja';
        return view('Kepsek/datapenelusuran',['penelusuran' => $penelusuran,'warna'=>$warna,'jurusan'=>$jurusan,'lulusan'=>$lulusan,'ket'=>$ket]);
    }
    public function datapencaker1(){
        $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
        ->join('alumni','alumni.nisn','=','users.nisn')
        ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
        ->where('pencaker','Y')
        ->orderBy('users.name')
        ->get();
        
        $jurusan = DB::table('jurusan')->get();
        $warna = ['','','oval',''];
        $lulusan = alumni::select('tahun_lulus')->groupBy('tahun_lulus')->get();
        $ket = 'Alumni yang belum bekerja';
        return view('Kepsek/datapenelusuran',['penelusuran' => $penelusuran,'warna'=>$warna,'jurusan'=>$jurusan,'lulusan'=>$lulusan,'ket'=>$ket]);
    }
    public function datakuliah1(){
        $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
        ->join('alumni','alumni.nisn','=','users.nisn')
        ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
        ->whereRaw('nama_kampus!="null"')
        ->orderBy('users.name')
        ->get();
        
        $jurusan = DB::table('jurusan')->get();
        $warna = ['','','oval',''];
        $lulusan = alumni::select('tahun_lulus')->groupBy('tahun_lulus')->get();
        $ket = 'Alumni yang melanjutkan sekolah';
        return view('Kepsek/datapenelusuran',['penelusuran' => $penelusuran,'warna'=>$warna,'jurusan'=>$jurusan,'lulusan'=>$lulusan,'ket'=>$ket]);
    }
    public function datasesuai1(){
        $penelusuran = penelusuran::join('users','penelusuran.nisn','=','users.nisn')
        ->join('alumni','alumni.nisn','=','users.nisn')
        ->join('jurusan','alumni.jurusan','=','jurusan.id_jurusan')
        ->where('sesuai_kompetensi','Y')
        ->orderBy('users.name')
        ->get();
        
        $jurusan = DB::table('jurusan')->get();
        $warna = ['','','oval',''];
        $lulusan = alumni::select('tahun_lulus')->groupBy('tahun_lulus')->get();
        $ket = 'kesesuaian jurusan';
        return view('Kepsek/datapenelusuran',['penelusuran' => $penelusuran,'warna'=>$warna,'jurusan'=>$jurusan,'lulusan'=>$lulusan,'ket'=>$ket]);
    }
    public function dashboard()
    {
        $jurusan = DB::select('select jurusan.id_jurusan,jurusan.nama_jurusan,count(nama_jurusan)jumlah,alumni.tahun_lulus from penelusuran left join alumni on penelusuran.nisn=alumni.nisn left join jurusan on alumni.jurusan=jurusan.id_jurusan where nama_perusahaan!="null" group by nama_jurusan');
        $perusahaan = DB::select('select nama_perusahaan, count(nama_perusahaan)as jumlah,count(if(sesuai_kompetensi="Y",sesuai_kompetensi,null))as kesesuaian, count(if(kepuasan="Y", kepuasan,null))as kepuasan from penelusuran where nama_perusahaan!="null" group by nama_perusahaan');
        $kelistrikan = DB::select("select count(nama_perusahaan)jumlah,count(*)-count(nama_perusahaan)kosong,nama_jurusan,id_jurusan,tahun_lulus,count(if(sesuai_kompetensi='Y',sesuai_kompetensi,null))as kesesuaian,nama_perusahaan from penelusuran join alumni on penelusuran.nisn=alumni.nisn join jurusan on alumni.jurusan=jurusan.id_jurusan group by nama_jurusan");
        $jmlthn = DB::select('select tahun_lulus from alumni group by tahun_lulus');
        $alljrsn = DB::table('jurusan')->whereRaw('id_jurusan!=6')->get();

        $warna = ['oval','','',''];
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
        
        return view('Kepsek/dashboardkepsek',['warna'=>$warna,'jurusan'=>$jurusan,'perusahaan'=>$perusahaan,'kelistrikan'=>$kelistrikan,'jmlthn'=>$jmlthn,'th2018'=>$th2018,'th2019'=>$th2019,'th2020'=>$th2020,'datatahun'=>$datatahun]);
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
}

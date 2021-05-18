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
             $penelusuran = penelusuran::all();
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
            $perusahaan = DB::select('select nama_perusahaan, count(nama_perusahaan)as jumlah,
                count(if(sesuai_kompetensi="Y",sesuai_kompetensi,null))as kesesuaian,
                count(if(sesuai_kompetensi="T",sesuai_kompetensi,null))as tdksesuai, 
                count(if(kepuasan="Y", kepuasan,null))as kepuasan,
                count(if(kepuasan="T", kepuasan,null))as tdkpuas from penelusuran 
                where nama_perusahaan!="null" group by nama_perusahaan');
            $warna = ['','','','oval'];
            return view('Kepsek/dataperusahaan',['perusahaan' => $perusahaan,'warna'=>$warna]);
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
}

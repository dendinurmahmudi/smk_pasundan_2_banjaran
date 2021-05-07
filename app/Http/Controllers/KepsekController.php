<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alumni;
use App\penelusuran;
use App\perusahaan;
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
        return view('Kepsek/index',['penelusuran' => $penelusuran, 'sesuai' => $sesuai, 'bekerja' => $bekerja, 'pencaker' => $pencaker, 'kuliah' => $kuliah, 'kesesuaian' => $kesesuaian, 'tidakisi' => $tidakisi]);
	}
}

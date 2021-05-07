<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Hash;
use Session;
use Mail;
use App\User;

class AuthController extends Controller
{

	public function showFormLogin()
    {
        if (Auth::check()) { 

            if(auth()->user()->hak_akses=='1' && auth()->user()->status_aktif=='1'){
              return redirect()->route('alumni');	
          }
          if(auth()->user()->hak_akses=='2'){
              return redirect()->route('hubin');	
          }
          if(auth()->user()->hak_akses=='3'){
              return redirect()->route('kepsek');	
          }
          if(auth()->user()->hak_akses=='4'){
              return redirect()->route('admin');	
          }
      }

      return view('Auth/login');
  }

  public function login(Request $request)
  {
    $rules = [
        'nisn'                 => 'required|numeric',
        'password'             => 'required'
    ];

    $messages = [
        'nisn.required'        => 'Nisn wajib diisi',
        'nisn.numeric'         => 'Nisn hanya boleh angka',
        'password.required'    => 'Password wajib diisi'
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if($validator->fails()){
        return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    $data = [
        'nisn'     => $request->input('nisn'),
        'password'  => $request->input('password'),
    ];
    $pass = $request->input('password');
    $nisn = $request->input('nisn');
    $nisndb = DB::select('select nisn from users where nisn="'.$nisn.'"');
    $passdb = DB::table('users')->get();
    Auth::attempt($data);
    if (Auth::check()) { 
       if(auth()->user()->hak_akses=='1'){
          if (auth()->user()->status_aktif=='1') {
              return redirect()->route('alumni');
          }else{	
             Session::flash('error', 'Akun kamu belum di verifikasi, coba lagi nanti!');
             return redirect()->route('login');
         }
     }
     if(auth()->user()->hak_akses=='2'){
        return redirect()->route('hubin');	
    }
    if(auth()->user()->hak_akses=='3'){
        return redirect()->route('kepsek');	
    }
    if(auth()->user()->hak_akses=='4'){
        return redirect()->route('admin');	
    }
}else if($nisndb){
    Session::flash('error', 'Password salah');
    return redirect()->route('login');
}elseif ($pass) {
foreach ($passdb as $p) {
    if ($pass == password_verify($pass, $p->password)) {
    Session::flash('error', 'NISN tidak ditemukan');
    return redirect()->route('login');
    }
}
    Session::flash('error', 'Nisn dan password salah');
    return redirect()->route('login');
}
}

public function showFormRegister()
{
    $jurusan = DB::select('select * from jurusan where id_jurusan!=6');
    return view('Auth/register',['jurusan'=>$jurusan]);
}

public function register(Request $request)
{
    $rules = [
     'nisn'				     => 'required|numeric|unique:users,nisn',
     'name'                  => 'required|min:3|max:35',
     'email'                 => 'required|email|unique:users,email',
     'lulusan'               => 'required|numeric',
     'password'              => 'required|confirmed|min:6'
 ];

 $messages = [
     'nisn.required'         => 'NISN wajib diisi',
     'nisn.numeric'          => 'NISN harus angka',
     'nisn.unique'           => 'Nisn sudah terdaftar',
     'name.required'         => 'Nama Lengkap wajib diisi',
     'name.min'              => 'Nama lengkap minimal 3 karakter',
     'name.max'              => 'Nama lengkap maksimal 35 karakter',
     'lulusan.required'      => 'Lulusan wajib diisi',
     'lulusan.numeric'       => 'Lulusan hanya boleh angka',
     'email.required'        => 'Email wajib diisi',
     'email.email'           => 'Email tidak valid',
     'email.unique'          => 'Email sudah terdaftar',
     'password.required'     => 'Password wajib diisi',
     'password.min'          => 'Password minimal 6 karakter',
     'password.confirmed'    => 'Password tidak sama dengan konfirmasi password'
 ];

 $validator = Validator::make($request->all(), $rules, $messages);

 if($validator->fails()){
    return redirect()->back()->withErrors($validator)->withInput($request->all);
}
if ($request->jurusan==0) {
    Session::flash('gagal', 'Jurusan harus dipilih');
          return redirect()->route('register');
}else{
$user = new User;
$user->nisn = ucwords(strtolower($request->nisn));
$user->name = ucwords(strtolower($request->name));
$user->email = strtolower($request->email);
$user->hak_akses = '1';
$user->status_aktif = '2';
$user->foto = 'default.png';
$user->password = Hash::make($request->password);
$user->email_verified_at = \Carbon\Carbon::now();
$simpan = $user->save();
DB::table('alumni')->insert([
    'nisn'          => ucwords(strtolower($request->nisn)),
    'jurusan'       => $request->jurusan,
    'tahun_lulus'   => ucwords(strtolower($request->lulusan))
]);
DB::table('penelusuran')->insert([
    'nisn' =>ucwords(strtolower($request->nisn))
]);
if($simpan){
    Session::flash('success', 'Register berhasil! Silahkan tunggu akun anda sedang diverifikasi');
    return redirect()->route('login');
} else {
    Session::flash('errors', ['' => 'Register gagal! Silahkan ulangi beberapa saat lagi']);
    return redirect()->route('register');
}
}
}

public function logout()
{
        Auth::logout(); // menghapus session yang aktif
        return redirect()->route('login');
    }

    public function send(Request $request){

    	$rules = [
            'id'                 => 'required'
        ];

        $messages = [
            'id.required' 	     => 'Id wajib diisi'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
        $id = DB::table('users')->where('id',$request->id)->value('id');
    	//
        if ($request->id!=$id) {
          Session::flash('error', 'Id tidak ditemukan!');
          return redirect()->route('login');
      } else{
         $email = DB::table('users')->where('id',$request->id)->value('email');
         try{
            Mail::send('Auth/lupapass', array('email' => $email) , function($pesan) use($request){
             $email = DB::table('users')->where('id',$request->id)->value('email');
             $pesan->to($email,'Lupa password')->subject('Layanan Lupa password');
             $pesan->from(env('MAIL_USERNAME','careerdevcenter.smkpasundan@gmail.com'),'Layanan Lupa password');
         });
            Session::flash('success', 'Silahkan buka email anda, dan ikuti langkah-langkahnya!');
            return redirect()->route('login');
        }catch (Exception $e){
            return response (['status' => false,'errors' => $e->getMessage()]);
        }
    }
}
public function ubahpass()
{
 return view('Auth/gantipass');
}

}

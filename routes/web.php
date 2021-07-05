<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('');
// });

Route::get('/', 'AuthController@showFormLogin')->name('login');
Route::get('login', 'AuthController@showFormLogin')->name('login');
Route::post('login', 'AuthController@login');
Route::get('register', 'AuthController@showFormRegister')->name('register');
Route::post('register', 'AuthController@register');
Route::get('ubahpass', 'AuthController@ubahpass')->name('ubahpass');
Route::get('/logout', 'AuthController@logout')->name('logout');
Route::post('lupapass/send','AuthController@send');

Route::group(['middleware' => ['auth','CekLevel:1']], function () {
    Route::get('/alumni', 'AlumniController@index')->name('alumni');
    Route::get('/penelusuran', 'AlumniController@penelusuran')->name('penelusuran');
    Route::get('/profile1', 'AlumniController@profile')->name('profile');
    Route::post('tambahpenelusuran', 'AlumniController@tambahpenelusuran')->name('tamahpenelusuran');
    Route::post('updateprofile', 'AlumniController@updateprofile')->name('updateprofile');
    Route::post('updatepenelusuran', 'AlumniController@updatepenelusuran');
    Route::get('/cari/{id}', 'AlumniController@autocomplete');
    Route::get('/informasi','AlumniController@informasi')->name('informasi');
    Route::post('kirimlamaran', 'AlumniController@kirimlamaran')->name('kirimlamaran');
    Route::get('/apllylamaranalumni/{id}','AlumniController@applylamaran')->name('apllylamaranalumni');
    Route::get('/hapuslam/{id}','AlumniController@hapuslam');
    Route::post('/gantipass1','AlumniController@gantipass1');
    Route::get('/chat1','AlumniController@chatalumni1');
    Route::get('/search1/{id}', 'AlumniController@search1');
    Route::get('/kirimp1/{nisn}/{pesan}','AlumniController@kirimp');
    Route::get('/isichat1/{nisn}','AlumniController@isichat1');
});
Route::group(['middleware' => ['auth','CekLevel:2']], function () {
    Route::get('/hubin', 'HubinController@index')->name('hubin');
    Route::get('/datapenelusuran', 'HubinController@datapenelusuran')->name('datapenelusuran');
    Route::get('/dataalumni', 'HubinController@dataalumni')->name('dataalumni');
    Route::get('/dataperusahaan', 'HubinController@dataperusahaan')->name('dataperusahaan');
    Route::get('/addinformasi','HubinController@addinformasi')->name('addinformasi');
    Route::post('tambahinformasi', 'HubinController@tambahinformasi')->name('tambahinformasi');
    Route::post('editinformasi', 'HubinController@editinformasi')->name('editinformasi');
    Route::get('hapusinformasi/{id}','HubinController@hapusinformasi');
    Route::get('/datalamaran', 'HubinController@datalamaran')->name('datalamaran');
    Route::get('datapelamar/{id}', 'HubinController@datapelamar')->name('datapelamar');
    Route::get('/profile2', 'HubinController@profile');
    Route::post('/gantipass','HubinController@gantipass');
    Route::post('/alumniBy_jurusan_tahun','HubinController@alumniBy_jurusan_tahun');
    Route::post('/penelusuranBy_jurusan_tahun','HubinController@penelusuranBy_jurusan_tahun');
    Route::get('/dashboard','HubinController@dashboard')->name('dashboard');
    Route::get('/databekerja','HubinController@databekerja');
    Route::get('/datapencaker','HubinController@datapencaker');
    Route::get('/datakuliah','HubinController@datakuliah');
    Route::get('/datasesuai','HubinController@datasesuai');
    Route::get('/get/{file}/{id}','HubinController@getlamaran');
    Route::get('/databelumisi', 'HubinController@databelumisi');
    Route::get('/chat2','HubinController@chathubin');
    Route::get('/search2/{id}', 'HubinController@search2');
    Route::get('/kirimp2/{nisn}/{pesan}','HubinController@kirimp2');
    Route::get('/isichat2/{nisn}','HubinController@isichat2');
    Route::get('/kirimemail','HubinController@kirimemail');
    Route::get('/prosesalgo','HubinController@prosesalgo');
    Route::get('/jrsnprthn/{id}','HubinController@jrsnprthn');
    Route::post('/editperu','HubinController@editperusahaan');
});
Route::group(['middleware' => ['auth','CekLevel:3']], function () {
    Route::get('/kepsek', 'KepsekController@index')->name('kepsek');
    Route::get('/datapenelusuran1','KepsekController@datapenelusuran1');
    Route::get('/dataalumni1','KepsekController@dataalumni1');
    Route::get('/dataperusahaan1','KepsekController@dataperusahaan1');
    Route::get('/databekerja1','KepsekController@databekerja1');
    Route::get('/datapencaker1','KepsekController@datapencaker1');
    Route::get('/datakuliah1','KepsekController@datakuliah1');
    Route::get('/datasesuai1','KepsekController@datasesuai1');
});
Route::group(['middleware' => ['auth','CekLevel:4']], function () {
    Route::get('/admin', 'AdminController@index')->name('admin');
    Route::get('/datalumni/{id}', 'AdminController@dataalumni')->name('datalumni');
    Route::get('/datlamaran', 'AdminController@datalamaran')->name('datlamaran');
    Route::get('/datpengguna', 'AdminController@datapengguna')->name('datpengguna');
    Route::get('/datpenelusuran', 'AdminController@datapenelusuran')->name('datpenelusuran');
    Route::get('/datperusahaan', 'AdminController@dataperusahaan')->name('datperusahaan');
    Route::get('/datajurusan','AdminController@datajurusan')->name('datajurusan');
    Route::get('/hapusdata/{id}/{jrsn}','AdminController@hapusdata')->name('hapusdata');
    Route::get('/hapusdatap/{id}','AdminController@hapusdatap')->name('hapusdatap');
    Route::post('/editpengguna','AdminController@editpengguna')->name('editpengguna');
    Route::get('/profile4', 'AdminController@profile');
    Route::post('/editalumni1/{id}','AdminController@editalumni1');
    Route::post('/gantipass2','AdminController@gantipass2');
    Route::post('/editprofileadmin','AdminController@editprofileadmin');
    Route::post('/alumniBy_tahun','AdminController@alumniBy_tahun');
    Route::post('/penelusuranBy_jurusan_tahun1','AdminController@penelusuranBy_jurusan_tahun1');
    Route::post('/tambahjurusan','AdminController@tambahjurusan');
    Route::get('/hapusjurusan/{id}','AdminController@hapusjurusan');
    Route::post('/editjurusan','AdminController@editjurusan');
    Route::post('/tambahalumni','AdminController@tambahalumni');
    Route::get('/resetpass/{id}','AdminController@resetpass');
    Route::get('/chat4','AdminController@chatadmin');
    Route::get('/search/{id}', 'AdminController@search');
    Route::get('/kirimp/{nisn}/{pesan}','AdminController@kirimp');
    Route::get('/isichat/{nisn}','AdminController@isichat');
    Route::get('/conf/{perusahaan}','AdminController@confidence');
    Route::get('/prshn/{id}','AdminController@prshn');
    Route::get('/verifikasi/{id}','AdminController@verifikasi');
    Route::post('/editperusahaan','AdminController@editperusahaan');
    
});
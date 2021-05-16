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
    Route::get('/daftarperusahaan','AlumniController@daftarperusahaan')->name('daftarperusahaan');
    Route::get('/hapuslam/{id}','AlumniController@hapuslam');
    Route::post('/gantipass1','AlumniController@gantipass1');
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
    
});
Route::group(['middleware' => ['auth','CekLevel:3']], function () {
    Route::get('/kepsek', 'KepsekController@index')->name('kepsek');
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

});
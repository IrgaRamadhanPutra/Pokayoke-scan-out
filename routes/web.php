<?php

use App\Http\Controllers\HomeController;
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



Route::get('home', function () {
    return view('pages.index');
});

Route::group(['middleware' => 'auth'], function () {

    //dashboard

    Route::get('/', 'HomeController@index');
    // Rouste::controller(HomeController)->group(function () {
    // });
    //pokayoke delivery ADM
    // Route::get('/view', 'ScanController@index')->name('view');
    Route::get('/getscan', 'ScanController@index')->name('get_scan');
    Route::get('/validasi', 'ScanController@validasi')->name('validasi');
    Route::post('/getEkanbanAdmoutSp1', 'ScanController@getEkanbanAdmoutSp1')->name('getEkanbanAdmoutSp1');


    // scan out export adm
    Route::get('/index_adm_export', 'ScanAdmExportController@index')->name('index');
    Route::get('/validasi_gohin', 'ScanAdmExportController@validasi_gohin')->name('validasi_gohin');
    Route::get('/getEkanbanAdmoutSp1Export', 'ScanAdmExportController@getEkanbanAdmoutSp1Export')->name('getEkanbanAdmoutSp1Export');


    //chek dn_no ADM
    Route::get('/getdn', 'DnController@index')->name('get_dn');
    Route::get('/tampil', 'DnController@tampil')->name('tampil');

    //Toyota scan
    Route::get('/gettoyota', 'ToyotaController@index')->name('get_toyota');
    Route::get('/validasitoyota', 'ToyotaController@validasitoyota')->name('validasitoyota');
    Route::post('/getEkanbanAdmoutSp6', 'ToyotaController@getEkanbanAdmoutSp6')->name('getEkanbanAdmoutSp6');

    //check dn_no Ekspor Toyota
    Route::get('/check_dn', 'DnToyotaContoller@index');
    Route::get('/getcek_dn', 'DnToyotaContoller@getcek_dn')->name('getcek_dn');

    //scan Reguler Toyota
    Route::get('/scan_reguler', 'ToyotaRegulerController@index');

    //check dn Reguler Toyota
    // Route::get('/dn_reguler', 'DnToyotaRegulerController@index');

    //Yamaha Scan
    Route::get('/getscanyamaha', 'ScanYamahaController@index');
    Route::get('/validasiyamaha', 'ScanYamahaController@validasi_yamaha')->name('validasi_yamaha');
    Route::post('/getEkanban', 'ScanYamahaController@getEkanban')->name('getEkanban');

    //check dn_no YAMAHA
    // Route::get('/getindexDNYamaha', 'DnYamahaController@getindex');
    Route::get('/getindex_yamaha', 'DnYamahaController@getindex');
    Route::get('/tampil_yamaha', 'DnYamahaController@tampil_yamaha')->name('tampil_yamaha');
    Route::get('/GetDnYamaha', 'DnYamahaController@GetDnYamaha')->name('GetDnYamaha');
});
//auth
Route::get('/auth', 'LoginController@login')->name('login');
Route::post('/postlogin', 'LoginController@postlogin')->name('postlogin');
Route::get('/logout', 'LoginController@logout');

// Route::get('/home', 'HomeController@index');

<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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




Route::get('/', function(){
	return view('Login.login');
})->name('/')->middleware('guest');

Route::get('/home',  function(){
		
        return view('plantilla');
})->middleware('auth')->name('home');



Route::get('/exitoso', function(){
	return view('Cambio');
})->name('/exitoso');

Route::post('password/email', 'LoginController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');


Route::post('/ingresar', 'LoginController@ingresar');
Route::post('/logout', 'LoginController@logout')->middleware('auth');

Route::get('/recuperar',function(){
	return view('Login.recuperar');
})->middleware('guest');


Route::get('/register', 'LoginController@registration');
Route::post('/registerform', 'LoginController@customRegistration');


Route::resource('/cliente','ClienteController')->except('show')->middleware('auth');
Route::get('cliente/consultar','ClienteController@consulta_data')->middleware('auth');

Route::resource('/producto','ProductoController')->except('show')->middleware('sup.admin');
Route::get('producto/consultar','ProductoController@consulta_data')->middleware('sup.admin');
Route::get('producto/info/{id}','ProductoController@consultar')->middleware('sup.admin');

Route::resource('/formapago','FormapagoController')->except('show')->middleware('auth');
Route::get('formapago/consultar','FormapagoController@consulta_data')->middleware('auth');

Route::resource('/ventas','VentasController')->except('show')->middleware('sup.admin');
Route::get('ventas/consultar/{vendedor}/{estado}/{fec1}/{fec2}/{checked}','VentasController@consulta_data')->middleware('sup.admin');
Route::get('ventas/info/{id}','VentasController@consultar')->middleware('sup.admin');
Route::get('ventas/imprimir/{id}','VentasController@imprimir')->middleware('sup.admin');
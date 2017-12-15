<?php

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

/*Route::get('/', function () {
    return view('inicio');
});*/

/*Route::get('clientes', function () {
    return view('clientes');
});*/

Route::get('/', function () {
    //return view('welcome');
    return view('home');

})->name('home');

// nosotros, nombre url
Route::get('nosotros', function () {
    return view('about');
    //darle nombre a la ruta
})->name('about');

Route::get('contacto', function () {
    return view('contact');
})->name('contact');

Route::get('servicio', function () {
    return view('service');
})->name('service');


//Route::post('causas', array('uses' =>'CausesController@addCause'))

Route::post('messages', function(){

	//enviar un correo al dueño de la pagina

	$data = request()->all();

	Mail::send("emails.message", $data, function($message) use ($data){
		$message->from($data['email'], $data['name'])
		->to('eidepozo@gmail.com', 'Elliot')
		->subject($data['subject']);
	});
	//var_dump(request()->all());

	//responder al usuario
	return back()->with('flash', $data['name'] . ', Tu mensaje ha sido recibido');
})->name('messages');


Route::get('administracion', 'HomeController@adini')->name('adini');
Route::get('verclientes', 'HomeController@adclient')->name('adclient');
Route::get('crearclientes', 'HomeController@createclient')->name('createclient');
Route::get('causas', 'HomeController@cause')->name('cause');

//Aplicar un middleware a un conjunto de rutas
Route::group(['middleware' => 'admin', 'namespace' => 'Admin'], function(){
	Route::get('/usuarios', 'TestController@index')->name('adusers');
});


/*Route::get('clientes', function () {
    return view('clientes');
})->name('clientes');*/

Auth::routes();
//la ruta home es resuelta por HomeController@index
Route::get('/home', 'HomeController@index')->name('home');

//nani
Route::get('/verclientes','ClientsController@showClients')->name('adclient');
Route::get('/causas','CausesController@showCauses')->name('cause');

Route::post('/crearclientes', array('uses' =>'Clients@agregarMaterial'));

/*
//--LOAD THE VIEW--//
Route::get('/verclientes', function () {
    $clients = Client::all();
    return view('adclient')->with('clients', $clients);
});

//--CREATE a link--//
Route::post('/crearclientes', function (Request $request) {
    $client = Client::create($request->all());
    return Response::json($client);
});

//--GET LINK TO EDIT--//
Route::get('/crearclientes/{client_id?}', function ($client_id) {
    $client = Client::find($client_id);
    return Response::json($client);
});

//--UPDATE a link--//
Route::put('/crearclientes/{client_id?}', function (Request $request, $client_id) {
    $client = Client::find($client_id);
    $client->nombre = $request->nombre;
    $client->rut = $request->rut;
    $client->direccion = $request->direccion;
    $client->telefono = $request->telefono;
    $client->save();
    return Response::json($client);
});

//--DELETE a link--//
Route::delete('/crearclientes/{client_id?}', function ($client_id) {
    $client = Client::destroy($client_id);
    return Response::json($client);
});*/

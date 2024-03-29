<?php

namespace App\Http\Controllers; //+ccontroller

use App\Client;
use App\Cause;
use App\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Session;
use DB;
class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //$clientes = Client::orderBy('nombre')->get();
      $clientes = Client::select(
          DB::raw("CONCAT(nombre,' ',apellido) AS name"),'rut','created_at')
          ->orderBy('created_at','DESC')
          ->pluck('name', 'rut'); //el segundo es el valor que esta asociado a cada opcion
      $cli = $clientes;
      $causa = null;
      try{
        $cli = Client::orderBy('created_at','DESC')->first();
        $causa = Cause::where('client_rut',$cli->rut)->first();
      }catch(\Exception $e){
        $cli = array(
          'id'=>'',
          'nombre'=>' ',
          'apellido' => '',
          'rut' => '',
          'direccion' => '',
          'correo' => '',
          'telefono' =>''
        );
        $cli =(object)$cli;
        $clientes = $cli;
      }
      /*if(!is_null($cli)){
        //obtenemos el primer cliente y mostramos su info
        $cli = Client::orderBy('created_at','DESC')->first();
        $causa = Cause::where('client_rut',$cli->rut)->first();
      }else{
        $cli = array(
          'id'=>'',
          'nombre'=>' ',
          'apellido' => '',
          'rut' => '',
          'direccion' => '',
          'correo' => '',
          'telefono' =>''
        );
        $cli =(object)$cli;
        $clientes = $cli;
      }*/

      //si el cliente no ha hecho Causas entonces retorna una causa genérica
      if($causa==null){
        $causa = array(
          'nombre' => 'Nombre de Causa',
          'tipo' => 'Tipo de Causa',
          'resumen' => 'Resumen',
          'abogado' => 'Nombre de Abogado'
        );
        $causa = (object)$causa;
      }

      return view('adclient',compact('clientes','cli','causa'));
    }

    /*
    * return view with client information & cause information
    */
    public function infoclients(Request $req)
    {
      $data = $req->all();
      $clientes = Client::select(
          DB::raw("CONCAT(nombre,' ',apellido) AS name"),'rut','created_at')
          ->orderBy('created_at','DESC')
          ->pluck('name', 'rut');

      $cli = Client::where('rut', $data['rut'])->firstOrFail();
      if($cli==null) return redirect()->back();
      $causa = Cause::where('client_rut',$cli->rut)->first();
      //si el cliente no registra causa, envia una causa genérica
      if($causa==null){
        $causa = array(
          'nombre' => ' ',
          'tipo' => ' ',
          'resumen' => ' ',
          'abogado' => ' '
        );
        $causa = (object)$causa;
      }
      return view('adclient',compact('clientes','cli','causa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('createclient');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [  //aqui tengo la validacion que soy gilo
        'nombre' => 'required',
        'apellido' => 'required',
        'rut' => 'required|unique:clients|integer',
        'correo' => 'email',
      ]);
      Client::create($request->all());
      Session::flash('flash_message', 'Se ha creado exitosamente un cliente.');
      return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function show($id)
    {
      $client = Article::find($id);
      return view('articles.show',compact('article'));
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $req)
    {
        $id = $req->all()['id'];
        $cli = Client::find($id);
        if($cli!=null)
        {
          return view('editclient',compact('cli'));
        }else {
          return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $task = Client::findOrFail($id);

      $this->validate($request, [
          'nombre' => 'required',
          'apellido' => 'required',
          'rut' => 'required|unique:clients|integer',
          'correo'=> 'email',
      ]);

      $input = $request->all();
      $cli = Client::find($id);
      $causas = Cause::where('client_rut',$cli->rut)->get();

      DB::statement('SET FOREIGN_KEY_CHECKS=0');
      foreach ($causas as $causa) {
        $causa->client_rut = $input['rut'];
        $causa->save();
      }
      $task->fill($input)->save();
      DB::statement('SET FOREIGN_KEY_CHECKS=1');

      Session::flash('flash_message', 'Cliente editado exitosamente.');

      return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $req)
    {
        $id = $req->all()['id'];
        $cli = Client::find($id);
        if($cli!=null){
          $causas = Cause::where('client_rut',$cli->rut)->get();
          foreach ($causas as $causa) {
            $docs = Document::where('idcausa',$causa->id)->get();
            foreach ($docs as $doc) {
              Storage::delete('public/'.$doc->nombre);
              $doc->delete();
            }
            $causa->delete();
          }
          $cli->delete();
          Session::flash('flash_message', 'Se ha borrado exitosamente un cliente, sus causas y documentos asociados.');
        }

        return redirect()->back();
    }
}

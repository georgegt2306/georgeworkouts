<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use App\Models\Cliente;
use App\Models\Formapago;
use Validator;
use Input;

class ClienteController extends Controller
{
   public function index(){

      $formapago=Formapago::whereNull('deleted_at')->get();

      return view('Cliente.index', compact('formapago'));

   }

   public function consulta_data(){
      $userid = \Auth::id();
      
      $result=Cliente::join('formapago','formapago.id','=','clientes.formapago')
      ->select('clientes.*', 'formapago.nombre as forma_pago')
      ->whereNull('clientes.deleted_at')
      ->orderBy('clientes.codigo')
      ->get();

      $titulos = [];
      $titulos[] = array('title' => '');
      $titulos[] = array('title' => 'Acciones');
      $titulos[] = array('title' => 'CI');
      $titulos[] = array('title' => 'Nombre');
      $titulos[] = array('title' => 'Forma de Pago');
      $titulos[] = array('title' => 'Teléfono');
      $titulos[] = array('title' => 'Estado');

      $jsonenv=[];
      
        foreach ($result as $res) {
   
         $boton_up=' <button  title="editar" class="btn btn-secondary" name="editar" onclick="mostrarmodal('.$res->codigo.');"><i class="fa fa-edit"></i> </button>';
    
         $boton_elim=' <button title="eliminar" class="btn btn-danger" name="eliminar" onclick="elim('.$res->codigo.');"><i class="fa fa-trash"></i> </button>';
   
         $button= $boton_up.''.$boton_elim;

         $imagen='<img src="'.asset('dist/img/user.png').'" width="30" heigth="30">';

         if(is_null($res->fecha_ini)){
            $estado='<p style="color:green; font-weight:bold"> Activo </p>';
         }else{
            if(date('Ymd') > date( "Ymd", strtotime($res->fecha_fin) )  ){
               $estado='<p style="color:red; font-weight:bold"> Caducado </p>';
            }else{
               $estado='<p style="color:green; font-weight:bold"> Activo </p>';
            }
   
         }

         $jsonenvtemp = [$imagen, $button, $res->identificacion,$res->nombre, $res->forma_pago,$res->celular, $estado];

          array_push($jsonenv, $jsonenvtemp);
        }

       return response()->json(["sms"=> $jsonenv, "titulos"=>$titulos]);   
   }

   public function store(Request $request){
      $userid = \Auth::id();

      try {
         DB::beginTransaction();
            
         if($request->formapago==1){
                     $id_cliente=Cliente::insertGetId([
                        'identificacion' => $request->ci_ruc,
                        'nombre' => $request->nombre,
                        'celular' => $request->celular,
                        'formapago' => $request->formapago,
                        'updated_at' =>now(),
                        'created_at' =>now()
                     ]);
         }else{
            $id_cliente=Cliente::insertGetId([
               'identificacion' => $request->ci_ruc,
               'nombre' => $request->nombre,
               'celular' => $request->celular,
               'formapago' => $request->formapago,
               'fecha_ini' => $request->fecha_ini,
               'fecha_fin' => $request->fecha_fin,
               'updated_at' =>now(),
               'created_at' =>now()
            ]);           
         }


         DB::commit();
         
         return response()->json(["sms"=>true, "mensaje"=>"Se creo correctamente"]);

      }catch(\Exception $e){
         DB::rollBack();
         return response()->json(["sms"=>false,"mensaje"=>$e->getMessage()]);           
      }
   }

   public function edit($id){
      $result_edit=Cliente::where('codigo',$id)->first();
      $formapago_edit=Formapago::whereNull('deleted_at')->get();
      return view('Cliente.edit', compact('result_edit','id','formapago_edit'));
   }

   public function update($id, Request $request){
   
      try {
         DB::beginTransaction();
         if($request->formapago==1){
            Cliente::where('codigo', $id)->update([
                        'identificacion' => $request->ci_ruc_edit,
                        'nombre' => $request->nombre_edit,
                        'celular' => $request->celular_edit,
                        'formapago' => $request->formapago_edit,
            ]);
                 
                    
         }else{
             Cliente::where('codigo', $id)->update([
               'identificacion' => $request->ci_ruc_edit,
               'nombre' => $request->nombre_edit,
               'celular' => $request->celular_edit,
               'formapago' => $request->formapago_edit,
               'fecha_ini' => $request->fecha_ini_edit,
               'fecha_fin' => $request->fecha_fin_edit,
            ]);           
         }
         DB::commit();
         return response()->json(["sms"=>true, "mensaje"=>"Se edito correctamente"]);
      }catch(\Exception $e){
         DB::rollBack();
         return response()->json(["sms"=>false,"mensaje"=>$e->getMessage()]);           
      }
     
   }
   public function destroy($id){

      try 
          {
            DB::beginTransaction();

            User::where('codigo', $id)->update([
               'updated_at' =>now(),
               'deleted_at' =>now(),
            ]);

       DB::commit();
        
        return response()->json(["sms"=>true,"mensaje"=>"Se elimino correctamente"]);

      }catch(\Exception $e) 
      {
        DB::rollBack();
        return response()->json(["sms"=>false,"mensaje"=>$e->getMessage()]);                 
      }
   }
}

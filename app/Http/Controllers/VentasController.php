<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Local;
use App\Models\Vend_local;
use App\Models\Estado;
use App\Models\Ventas;
use App\Models\Detalle_venta;
use DB;

class VentasController extends Controller
{
    public function index(){
        $userid = \Auth::id();
        $comboestado=Estado::select('id','nombre')->get();

        $local_per= Local::where("id_supervisor", $userid)
                  ->select("id")
                  ->whereNull("deleted_at")
                  ->first();

        $combovend=User::join('vend_local', 'user.id','=','vend_local.id_vendedor')
            ->select('user.id as id_vend', 'user.nombre as nombre_vend' , 'user.apellido as apellido_vend')
            ->where('vend_local.id_local', $local_per->id)
            ->whereNull('user.deleted_at')
            ->orderBy('user.id')
            ->get();

        return view('Ventas.index',compact('comboestado', 'combovend'));
    }


    public function consulta_data($vendedor, $estado, $fec1, $fec2, $checked){
        $userid = \Auth::id();
        $local_per= Local::where("id_supervisor", $userid)
                  ->select("id")
                  ->whereNull("deleted_at")
                  ->first();

        $sQuery="SELECT * from ventas where id_local='".$local_per->id."' and deleted_at is null";

        if (strcmp($checked,'false')==0){ 
            $sQuery.=" and fecha between  '".date("d/m/Y", strtotime($fec1))."' and '".date("d/m/Y", strtotime($fec2))."'"; 
        }
        if(strcmp($vendedor,'S')!=0){
                $sQuery.=" and  id_vendedor = '".$vendedor."' "; 
        }
        if(strcmp($estado,'S')!=0){
                $sQuery.=" and  id_estado = '".$estado."' "; 
        }
      

        $result=DB::select($sQuery);

        $titulos = [];
        $titulos[] = array('title' => '');
        $titulos[] = array('title' => 'Acciones');
        $titulos[] = array('title' => 'Estado');
        $titulos[] = array('title' => 'Fecha');
        $titulos[] = array('title' => 'Cédula/RUC');
        $titulos[] = array('title' => 'Cliente');
        $titulos[] = array('title' => 'Vendedor');


        $jsonenv=[];
      
        foreach ($result as $res) {

            if (strcmp($res->id_estado,'1')==0) {
                $val_estado="INGRESADO";
            }elseif (strcmp($res->id_estado,'2')==0) {
                $val_estado="PROCESANDO";
            }else{
                $val_estado="ENTREGADO";
            }
   
         $boton_cons=' <button title="consultar_modal" class="btn btn-info" name="consultar_modal" onclick="mostrarconsul('.$res->id.');"><i class="fa fa-search"></i> </button>'; 
          
         $boton_up=' <button  title="editar" class="btn btn-success" name="editar" onclick="mostrarmodal('.$res->id.');"><i class="fa fa-edit"></i> </button>';
    
         $boton_elim=' <button title="eliminar" class="btn btn-danger" name="eliminar" onclick="elim('.$res->id.');"><i class="fa fa-trash"></i> </button>';
   
         $button= $boton_cons.''.$boton_up.''.$boton_elim;

         $imagen='<img src="'.asset('images/ventas.png').'" width="50" height="50"  >';

         $jsonenvtemp = [$imagen,$button,$val_estado,$res->created_at,$res->ci_ruc_cliente,$res->nombre_cliente.' '.$res->apellido_cliente, $res->nombre_vendedor.' '.$res->apellido_vendedor];

          array_push($jsonenv, $jsonenvtemp);
        }

       return response()->json(["sms"=> $jsonenv, "titulos"=>$titulos]);   
   }    

    public function consultar($id){

       $det_venta=Detalle_venta::where('id_venta', $id)->get();

       $cab_venta=Ventas::where('id', $id)->first();

       return view("Ventas.consultar", compact('det_venta','cab_venta','id'));
    }

    public function imprimir($id){

       $det_venta=Detalle_venta::where('id_venta', $id)->get();

       $cab_venta=Ventas::where('id', $id)->first();
        $invoice = "Reporte";
        $view =  \View::make('Ventas.imprimir', compact( 'det_venta','cab_venta','id'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('mediaA4', 'portrait');
        $pdf->loadHTML($view);
          
        return $pdf->stream('Reporte_de_gestion');  

    }

    public function edit($id){
        $comboestado_edit=Estado::select('id','nombre')->get();
        $result_edit=Ventas::where('id',$id)->select('id','id_estado','fecha')->first();      
       
        return view('Ventas.edit', compact('result_edit','comboestado_edit'));
    }

    public function update(Request $request){
        $userid = \Auth::id(); 


        try {
          DB::beginTransaction();
         
          $cons_insp_cab= Ventas::where('id', '=', $request->idunic)
          ->update(['id_estado'=>$request->estado_edit,
              'user_updated' => $userid]);

            DB::commit();
                
            return response()->json(["sms"=>true,"mensaje"=>"Se edito correctamente"]);               
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(["sms"=>false,"mensaje"=>$e->getMessage()]);                 
        }
    }
   public function destroy($id){
      $userid = \Auth::id();
      try 
          {
            DB::beginTransaction();

            Ventas::where('id', $id)->update([
               'updated_at' =>now(),
               'deleted_at' =>now(),
               'user_updated' => $userid
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

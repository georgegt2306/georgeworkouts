<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use App\Models\Formapago;
use Validator;
use Input;

class FormapagoController extends Controller
{
    public function index(){

        return view('Formapago.index');
      
   }
   public function consulta_data(){
        $userid = \Auth::id();



            $result=Formapago::whereNull('deleted_at')
                ->orderBy('id')
                ->get();
      

          $titulos = [];
          $titulos[] = array('title' => 'Acciones');
          $titulos[] = array('title' => 'Nombre');
          $titulos[] = array('title' => 'Precio');


          $jsonenv=[];
      
        foreach ($result as $res) {
  
         $boton_up=' <button  title="editar" class="btn btn-success" name="editar" onclick="mostrarmodal('.$res->id.');"><i class="fa fa-edit"></i> </button>';
    
         $boton_elim=' <button title="eliminar" class="btn btn-danger" name="eliminar" onclick="elim('.$res->id.');"><i class="fa fa-trash"></i> </button>';

    

         
         $button= $boton_up.''.$boton_elim;

         $jsonenvtemp = [$button,$res->nombre, '$ '.$res->precio];

          array_push($jsonenv, $jsonenvtemp);
        }

       return response()->json(["sms"=> $jsonenv, "titulos"=>$titulos]);   
   }

    public function store(Request $request){
        $userid = \Auth::id();
        
        try {
            DB::beginTransaction();

            $id=Formapago::insertGetId(
            [ 'nombre'=>$request->nombre,
              'precio'=>$request->precio,
              'created_at'=> now()

            ]);
            

            DB::commit();
                
            return response()->json(["sms"=>true,"mensaje"=>"Se creo correctamente"]);                    
        }catch(\Exception $e){

            DB::rollBack();
            return response()->json(["sms"=>false,"mensaje"=>$e->getMessage()]);                 
        }
    }

    public function edit($id){
        $result_edit=Promocion::where('id',$id)->first();      
       
        return view('Promociones.edit', compact('result_edit'));
    }

    public function update(Request $request){
        $userid = \Auth::id(); 
        $path=$request->imagenanterior;

        if($archivo=$request->file('imagen_edit')){
            if(file_exists('images/promociones/'.$request->idunic.'.png')){
                unlink('images/promociones/'.$request->idunic.'.png'); 
            } 
            $path= asset('images/promociones/'.$request->idunic.'.png');
            $archivo->move('images/promociones', $request->idunic.'.png');
        } 

        if($request->url_edit != ''){
            if(file_exists('images/promociones/'.$request->idunic.'.png')){
                unlink('images/promociones/'.$request->idunic.'.png'); 
            } 
            $path=$request->url_edit;
        }

        try {
          DB::beginTransaction();
         
          $cons_insp_cab= Promocion::where('id', '=', $request->idunic)
          ->update(['updated_at' =>now(), 
              'nombre'=>$request->nombre_edit,
              'descripcion'=>$request->descripcion_edit,
              'fecha_ini'=>$request->fecha_ini_edit,
              'fecha_fin'=>$request->fecha_fin_edit,
              'precio'=>$request->precio_edit,
              'url_imagen' =>$path==null?'https://pasarelamercy.online/images/promocion.png':$path,
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
        try {

            DB::beginTransaction();

                Promocion::where('id', $id)->update([
                   'updated_at' =>now(),
                   'deleted_at' =>now(),
                   'user_updated' => $userid
                ]);

            DB::commit();
        
            return response()->json(["sms"=>true,"mensaje"=>"Se elimino correctamente"]);

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(["sms"=>false,"mensaje"=>$e->getMessage()]);                 
      }
    }    

}

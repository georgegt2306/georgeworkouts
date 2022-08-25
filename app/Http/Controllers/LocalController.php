<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Local;
use App\Models\User;
use App\Models\Vend_local;
use App\Models\Producto;
use Validator;
use Input;

class LocalController extends Controller
{
    public function index(){

     $supervisor= User::where('id_tipo','2')
                  ->select('id', 'nombre')
                  ->whereNull('deleted_at')
                  ->get();
    
    $lisup=[];

    foreach ($supervisor as $sup) {
        $local= Local::where('id_supervisor', $sup->id)
                ->select('id_supervisor')
                ->whereNull('deleted_at')
                ->count();


         if($local!=1){
            array_push($lisup, [$sup->id, $sup->nombre]);
         }     

    }

    
    return view('Local.index',compact('lisup'));
   }
   public function consulta_data(){

      $result=Local::join('user','local.id_supervisor','=','user.id')
            ->select('local.*', 'user.nombre as nombre_super')
            ->whereNull('local.deleted_at')
            ->orderBy('local.id')
            ->get();
      
      $titulos = [];
      $titulos[] = array('title' => '');
      $titulos[] = array('title' => 'Acciones');
      $titulos[] = array('title' => 'Dueño');
      $titulos[] = array('title' => 'Ruc');
      $titulos[] = array('title' => 'Nombre');
      $titulos[] = array('title' => 'Teléfono');
      $titulos[] = array('title' => 'Direccion');
      $titulos[] = array('title' => 'Coordenadas');


      $jsonenv=[];
      
        foreach ($result as $res) {
          
         $boton_up=' <button  title="editar" class="btn btn-success" name="editar" onclick="mostrarmodal('.$res->id.');"><i class="fa fa-edit"></i> </button>';
    
         $boton_elim=' <button title="eliminar" class="btn btn-danger" name="eliminar" onclick="elim('.$res->id.');"><i class="fa fa-trash"></i> </button>';


        

         $time = date("H:i:s");
         $imagen='<img src="'.$res->url_image.'?time='.$time.'" width="50" height="50" >';
   
         $button= $boton_up.''.$boton_elim;

         $jsonenvtemp = [$imagen,$button,$res->nombre_super,$res->ruc,$res->nombre,$res->telefono,$res->direccion, $res->latitud.'-'.$res->longitud];

          array_push($jsonenv, $jsonenvtemp);
        }

       return response()->json(["sms"=> $jsonenv, "titulos"=>$titulos]);   
   }

    public function store(Request $request){
        $userid = \Auth::id();
        $v = Validator::make($request->all(),[
              'ruc'=>"required|unique:local,ruc",
            ]);

        if($v->fails()){
          $mensajedereturn=strtoupper($v->errors()->first('ruc'));

          return response()->json(["sms"=>false ,"mensaje" => $mensajedereturn]);     
        }
    
        $local= Local::where('id_supervisor', $request->superv)
                    ->whereNull('deleted_at')
                    ->count();

         if($local==1){
            return response()->json(["sms"=>false ,"mensaje" => "Supervisor ya tiene local"]);
         }  

        try {
            DB::beginTransaction();

            $id=Local::insertGetId(
            [ 'ruc'=>$request->ruc,
              'id_supervisor'=>$request->superv,
              'nombre'=>$request->nombre,
              'descripcion'=>$request->descripcion,
              'telefono'=>$request->telefono,
              'direccion'=>$request->direccion,
              'latitud'=>$request->latitud,
              'longitud'=>$request->longitud,
              'url_image'=>'',
              'updated_at' =>now(),
              'created_at' =>now(),
              'id_admin' => $userid,
              'user_updated' => $userid

            ]);
            
            $id2=$id.'.png';

            if($archivo=$request->file('file')){
                $path= asset('images/local/'.$id2);
                $archivo->move('images/local', $id2);
            }

            else{
                $path=$request->url;
            }

            Local::where('id', $id)
              ->update(['url_image' => $path==null?'https://pasarelamercy.online/images/local.png':$path]);


            DB::commit();
                
            return response()->json(["sms"=>true,"mensaje"=>"Se creo correctamente"]);                    
        }catch(\Exception $e){

            DB::rollBack();
            return response()->json(["sms"=>false,"mensaje"=>$e->getMessage()]);                 
        }
    }
    public function edit($id){
        $result_edit=Local::where('id',$id)->first();
        $supervisor= User::where('id_tipo','2')
                  ->select('id', 'nombre')
                  ->whereNull('deleted_at')
                  ->get();

        $lisup_edit=[];
        foreach ($supervisor as $sup) {
        $local= Local::where('id_supervisor', $sup->id)
                ->select('id_supervisor')
                ->whereNull('deleted_at')
                ->count();

        if ($sup->id == $result_edit->id_supervisor) {
             array_push($lisup_edit, [$sup->id, $sup->nombre]);
        }

         if($local!=1){
            array_push($lisup_edit, [$sup->id, $sup->nombre]);
         }     

        }      
       
      return view('Local.edit', compact('result_edit','lisup_edit'));
    }

    public function update(Request $request){
        $userid = \Auth::id(); 
        $path=$request->imagenanterior;


        if ($request->id_anterior != $request->superv_edit) {
            $local= Local::where('id_supervisor', $request->superv_edit)
                        ->whereNull('deleted_at')
                        ->count();

            if($local==1){
                return response()->json(["sms"=>false ,"mensaje" => "Supervisor ya tiene local"]);
            }   
        }
       
        
        if($archivo=$request->file('imagen_edit')){
          if(file_exists('images/local/'.$request->idunic.'.png')){
            unlink('images/local/'.$request->idunic.'.png'); 
          } 
            $path= asset('images/local/'.$request->idunic.'.png');
            $archivo->move('images/local', $request->idunic.'.png');
        } 

        if($request->url_edit != ''){
          if(file_exists('images/local/'.$request->idunic.'.png')){
           unlink('images/local/'.$request->idunic.'.png'); 
          } 
            $path=$request->url_edit;
        }

        try {
          DB::beginTransaction();
         
          $cons_insp_cab= Local::where('id', '=', $request->idunic)
          ->update(['updated_at' =>now(), 
                    'id_supervisor'=>$request->superv_edit,
                    'nombre'=>$request->nombre_edit,
                    'direccion'=>$request->direccion_edit,
                    'telefono'=>$request->telefono_edit,
                    'descripcion'=>$request->descripcion_edit,
                    'latitud'=>$request->latitud_edit,
                    'longitud'=>$request->longitud_edit,
                    'url_image' =>$path==null?'https://pasarelamercy.online/images/local.png':$path,
                    'id_admin' => $userid,
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

        $tien_vend= Vend_local::where("id_local", $id)
                ->whereNull('deleted_at')
                ->count();

        $tien_pro= Producto::where("id_local",$id)
                ->whereNull('deleted_at')
                ->count();
         if($tien_vend>0){
            return response()->json(["sms"=>false ,"mensaje" => "Este local cuenta con vendedores activos"]);
         }  
         if($tien_pro>0){
            return response()->json(["sms"=>false ,"mensaje" => "Este local cuenta con prodcutos activos"]);
         }  

        try {

            DB::beginTransaction();

            Local::where('id', $id)->update([
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

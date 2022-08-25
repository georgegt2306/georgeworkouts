<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Local;
use Validator;
use Input;

class ProductoController extends Controller
{
    public function index(){

        $categoria= Categoria::select('id','nombre')
                ->where('id_parent','>','1')
                ->whereNull('deleted_at')->get();


         return view('Producto.index', compact('categoria'));
    }

    public function consulta_data(){
        $userid = \Auth::id();
          $local_per= Local::where("id_supervisor", $userid)
              ->select("id")
              ->whereNull("deleted_at")
              ->first();


          $result=Producto::join('categoria','producto.id_categoria','=','categoria.id')
                ->select('producto.*', 'categoria.nombre as nombre_categoria')
                ->where("id_local", $local_per->id)
                ->whereNull('producto.deleted_at')
                ->orderBy('producto.id')
                ->get();
      

          $titulos = [];
          $titulos[] = array('title' => '');
          $titulos[] = array('title' => 'Acciones');
          $titulos[] = array('title' => 'Nombre');
          $titulos[] = array('title' => 'Categoria');
          $titulos[] = array('title' => 'Costo');
          $titulos[] = array('title' => 'Precio');
          $titulos[] = array('title' => 'Existencia');

          $jsonenv=[];
      
        foreach ($result as $res) {

         $boton_cons=' <button title="consultar" class="btn btn-info" name="consultar" onclick="mostrarconsul('.$res->id.');"><i class="fa fa-search"></i> </button>';
  
         $boton_up=' <button  title="editar" class="btn btn-success" name="editar" onclick="mostrarmodal('.$res->id.');"><i class="fa fa-edit"></i> </button>';
    
         $boton_elim=' <button title="eliminar" class="btn btn-danger" name="eliminar" onclick="elim('.$res->id.');"><i class="fa fa-trash"></i> </button>';

   
         $button= $boton_cons.''.$boton_up.''.$boton_elim;

         $jsonenvtemp = ['',$button,$res->nombre,$res->nombre_categoria,$res->costo,$res->precio,$res->existencia];

          array_push($jsonenv, $jsonenvtemp);
        }

       return response()->json(["sms"=> $jsonenv, "titulos"=>$titulos]);   
   }

    public function store(Request $request){
        $userid = \Auth::id();
        $local_per= Local::where("id_supervisor", $userid)
              ->select("id")
              ->whereNull("deleted_at")
              ->first();
        
        try {
            DB::beginTransaction();

            $id=Producto::insertGetId(
            [ 'nombre'=>$request->nombre,
              'descripcion'=>$request->descripcion,
              'id_categoria'=>$request->categoria,
              'costo'=>$request->costo,
              'precio'=>$request->precio,
              'unidad'=>$request->unidad,
              'existencia'=>$request->existencia,
              'descuento'=>$request->descuento,
              'tasa_iva'=>$request->iva,
              'url_imagen'=>'',
              'updated_at' =>now(),
              'created_at' =>now(),
              'id_local' => $local_per->id,
              'user_updated' => $userid

            ]);
            
            $id2=$id.'.png';

            if($archivo=$request->file('file')){
                $path= asset('images/productos/'.$id2);
                $archivo->move('images/productos', $id2);
            }

            else{
                $path=$request->url;
            }

            Producto::where('id', $id)
              ->update(['url_imagen' => $path==null?'https://pasarelamercy.online/images/producto.png':$path]);


            DB::commit();
                
            return response()->json(["sms"=>true,"mensaje"=>"Se creo correctamente"]);                    
        }catch(\Exception $e){

            DB::rollBack();
            return response()->json(["sms"=>false,"mensaje"=>$e->getMessage()]);                 
        }
    }

    public function consultar($id){
       $trae_prod=Producto::join('categoria','producto.id_categoria','=','categoria.id')
                          ->select('producto.*', 'categoria.nombre as nombrecate')
                          ->where('producto.id', $id)->first();

       return view("Producto.consultar", compact('trae_prod'));
    }

    public function edit($id){
        $result_edit=Producto::where('id',$id)->first();      
       
        return view('Producto.edit', compact('result_edit'));
    }

    public function update(Request $request){
        $userid = \Auth::id(); 
        $path=$request->imagenanterior;

        if($archivo=$request->file('imagen_edit')){
            if(file_exists('images/productos/'.$request->idunic.'.png')){
                unlink('images/productos/'.$request->idunic.'.png'); 
            } 
            $path= asset('images/productos/'.$request->idunic.'.png');
            $archivo->move('images/productos', $request->idunic.'.png');
        } 

        if($request->url_edit != ''){
            if(file_exists('images/productos/'.$request->idunic.'.png')){
                unlink('images/productos/'.$request->idunic.'.png'); 
            } 
            $path=$request->url_edit;
        }

        try {
          DB::beginTransaction();
         
          $cons_insp_cab= Producto::where('id', '=', $request->idunic)
          ->update(['updated_at' =>now(), 
              'nombre'=>$request->nombre_edit,
              'descripcion'=>$request->descripcion_edit,
              'costo'=>$request->costo_edit,
              'precio'=>$request->precio_edit,
              'unidad'=>$request->unidad_edit,
              'existencia'=>$request->existencia_edit,
              'descuento'=>$request->descuento_edit,
              'tasa_iva'=>$request->iva_edit,
              'url_imagen' =>$path==null?'https://pasarelamercy.online/images/producto.png':$path,
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

                Producto::where('id', $id)->update([
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

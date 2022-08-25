<style>
#divPadre {
  display: flex;
  justify-content: center;
  align-items: center;
}
@media only screen and (max-width: 915px) {
  #imagencons {
    width: 120px;
    height: 120px;
  }
}	

@media only screen and (max-width: 700px) {
  #imagencons {
    width: 150px;
    height: 120px;
  }
}	
</style>	
	<div class="modal-header">
	  
	    <h4 class="modal-title">Consultar</h4>
	    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">   
		<div class="row">
			<div class="col-md-4" id="divPadre" >
				 <div class="form-group row">
                   
				     <img src="{{$trae_prod->url_imagen}}" alt="imagen_pro" id="imagencons" width="200" height="200"  style="border: 2px black solid;" onerror="this.src='{{asset('images/producto.png')}}'" >
				    </div>
			</div>	
            <div class="col-md-7">
            	<div class="form-group row">
                  <label for="nombre" class="col-form-label col-sm-4">Nombre:</label>
                  <div class="col-sm-8">
                      <input class="form-control" type="text" value="{{$trae_prod->nombre}}" disabled>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="descripcion" class="col-form-label col-sm-4">Descripción:</label>
                  <div class="col-sm-8">
                      <textarea class="form-control"  rows="3" disabled >{{$trae_prod->descripcion}}</textarea>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="categoria" class="col-form-label col-sm-4">Categoría:</label>
                  <div class="col-sm-8">
						<input class="form-control" type="text" value="{{$trae_prod->nombrecate}}" disabled>
                  </div>
                </div>  

                <div class="form-group row">
                    <label for="costo" class="col-form-label col-sm-4">Costo:</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" value="{{$trae_prod->costo}}" disabled>
                    </div>     
                </div> 

                <div class="form-group row">
                  <label for="precio" class="col-form-label col-sm-4">Precio:</label>
                  <div class="col-sm-8">
                        <input class="form-control" type="text" value="{{$trae_prod->precio}}" disabled>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="unidad" class="col-form-label col-sm-4">Unidad:</label>
                  <div class="col-sm-8">
                        <input class="form-control" type="text" value="{{$trae_prod->unidad}}" disabled>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="existencia" class="col-form-label col-sm-4">Existencia:</label>
                  <div class="col-sm-8">
                        <input class="form-control" type="text" value="{{$trae_prod->existencia}}" disabled>

                  </div>
                </div>

                <div class="form-group row">
                  <label for="descuento" class="col-form-label col-sm-4">Descuento:</label>
                  <div class="col-sm-8">
                        <input class="form-control" type="text" value="{{$trae_prod->descuento}}" disabled>
                  </div>
                </div>

                <div class="form-group row">
					<label for="iva" class="col-form-label col-sm-4">Iva:</label>
					<div class="col-sm-8">
					    <input class="form-control" type="text" value="{{$trae_prod->tasa_iva}}" disabled>
					</div>
                </div>


            </div>
            </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>

 <script>
 	    remove_cursor_wait();
    $('#modale_cons').modal();
    $('button[name=consultar]').attr('disabled',false);
 </script>   
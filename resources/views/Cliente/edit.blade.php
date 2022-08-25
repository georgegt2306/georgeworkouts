<form  class="needs-validation" id="edit_vendedor" autocomplete="off" novalidate>
   @csrf 
   {{ method_field('PUT') }}
    <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Editar</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              


                <div class="form-group row">
                <label for="nombre_edit" class="col-form-label col-sm-3">Nombre:</label>
                  <div class="col-sm-7">
                   <input  class="form-control" type="text" name="nombre_edit" id="nombre_edit" value="{{$result_edit->nombre}}"  required maxlength="50"> 
                   <div class="invalid-feedback">Ingrese Nombre.</div> 
                  </div>
                </div>
  
                <div class="form-group row">
                <label for="nombre" class="col-form-label col-sm-3">Nombre:</label>
                  <div class="col-sm-7">
                   <input  class="form-control" type="text" name="nombre" id="nombre" required > 
                   <div class="invalid-feedback" onkeypress="return soloLetras(event)">Ingrese Nombre.</div> 
                  </div>
                </div>
                <div class="form-group row">
                  <label for="telefono" class="col-form-label col-sm-3">Forma de Pago:</label>
                  <div class="col-sm-7">
                      <select class="form-control" name="formapago" id="formapago">
                        @foreach($formapago as $fp)
                        <option value="{{$fp->id}}" >{{$fp->nombre}}</option>
                        @endforeach
                      </select>
                     <div class="invalid-feedback">Ingrese Teléfono.</div> 
                  </div>
                </div>

                <div class="form-group row">
                  <label for="celular" class="col-form-label col-sm-3">Celular:</label>
                  <div class="col-sm-7">
                  <input  class="form-control" type="text" name="celular" id="celular" onkeypress="return justNumbers(event);" > 
                     <div class="invalid-feedback">Ingrese Celular.</div> 
                  </div>
                </div>

                 <div class="form-group row">
                    <label for="nombre" class="col-form-label col-sm-3">Duración:</label>
                  <div class="col-sm-7">
                    <input class="form-control" type="text" name="rango" id="rango" >
                  </div>
                  <input class="form-control" type="hidden" name="fecha_ini" id="fecha_ini" value="{{ now()->format('Ymd') }}" >


                  <input class="form-control" type="hidden"  name="fecha_fin" id="fecha_fin" value="{{ now()->format('Ymd') }}">
                </div>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" >Guardar</button>
            </div>
</form>
<script type="text/javascript">

	  remove_cursor_wait();
	  $('#modale').modal();
	  $('button[name=editar]').attr('disabled',false);

    var form2=document.getElementById('edit_vendedor');


    form2.addEventListener('submit', (event) => {
     event.preventDefault();
      if (!form2.checkValidity()) {
        event.stopPropagation();
      }else {
        const edit_sup = new FormData(form2); 
            $.ajax({
                url:"{{asset('')}}vendedor/{{$id}}",
                type: 'POST',
                dataType: 'json',
                contentType: false,
                processData: false,
                data: edit_sup,
                success:function(res){
                    if(res.sms){
                         consultar_tabla(); 
                         $('#modale').modal('hide');
                         toastr.success(res.mensaje);
                         
                    }
                    else{               
                        Swal.fire({
                            closeOnClickOutside:false,
                            title: res.mensaje,
                            icon: "error",
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                   }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    if (errorThrown=='Unauthorized') {
                      location.reload();
                    }
                }
            });   
        }
        form2.classList.add('was-validated');
    }, false);

</script>
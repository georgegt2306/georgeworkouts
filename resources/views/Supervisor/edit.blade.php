<form  class="needs-validation" id="edit_supervisor" autocomplete="off" novalidate>
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
                  <label for="ci_ruc_edit" class="col-form-label col-sm-3">Cédula o Ruc:</label>
                  <div class="col-sm-7">
                   <input  class="form-control" type="text" value="{{$result_edit->ci_ruc}}" name="ci_ruc_edit" id="ci_ruc_edit" onkeypress="return justNumbers(event);" required pattern="[0-9]{10}|[0-9]{13}" maxlength="13">  
                   <div class="invalid-feedback">Ingrese Cédula o Ruc.</div> 
                    <span id="mensaje"></span>
                  </div>
                  <div class="col-sm-1" id="ced_as" style="display:none">
                    <p style="color: red;font-size:25px ;" >*</p>
                   </div>
                </div>

                <div class="form-group row">
                <label for="nombre_edit" class="col-form-label col-sm-3">Nombre:</label>
                  <div class="col-sm-7">
                   <input  class="form-control" type="text" name="nombre_edit" id="nombre_edit" value="{{$result_edit->nombre}}"  onkeypress="return soloLetras(event)" required maxlength="50"> 
                   <div class="invalid-feedback" >Ingrese Nombre.</div> 
                  </div>
                </div>
     
                <div class="form-group row">
                  <label for="apellido_edit" class="col-form-label col-sm-3">Apellido:</label>
                    <div class="col-sm-7">
                     <input class="form-control" type="text" value="{{$result_edit->apellido}}" name="apellido_edit" id="apellido_edit" onkeypress="return soloLetras(event)" required maxlength="50"> 
                     <div class="invalid-feedback" >Ingrese Apellido.</div> 
                    </div>
                </div>

                <div class="form-group row">
                  <label for="direccion_edit" class="col-form-label col-sm-3">Dirección:</label>
                  <div class="col-sm-7">
                    <textarea class="form-control" name="direccion_edit" id="direccion_edit" cols="30" rows="3" required maxlength="1000">{{$result_edit->direccion}}</textarea>  
                     <div class="invalid-feedback">Ingrese Dirección.</div> 
                  </div>
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

    var form2=document.getElementById('edit_supervisor');


    form2.addEventListener('submit', (event) => {
     event.preventDefault();
      if (!form2.checkValidity()) {
        event.stopPropagation();
      }else {
        const edit_sup = new FormData(form2); 
            $.ajax({
                url:"{{asset('')}}supervisor/{{$id}}",
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
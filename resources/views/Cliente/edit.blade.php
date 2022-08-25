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
                <label for="ci_ruc_edit" class="col-form-label col-sm-3">Ci_Ruc:</label>
                  <div class="col-sm-7">
                   <input  class="form-control" type="text" name="ci_ruc_edit" id="ci_ruc_edit" value="{{$result_edit->identificacion}}"  required pattern="[0-9]{10}|[0-9]{13}"> 
                   <div class="invalid-feedback">Ingrese Cédula.</div> 
                  </div>
                </div>
  
                <div class="form-group row">
                <label for="nombre_edit" class="col-form-label col-sm-3">Nombre:</label>
                  <div class="col-sm-7">
                   <input  class="form-control" type="text" name="nombre_edit" id="nombre_edit"  value="{{$result_edit->nombre}}" required > 
                   <div class="invalid-feedback" onkeypress="return soloLetras(event)">Ingrese Nombre.</div> 
                  </div>
                </div>

                <div class="form-group row">
                  <label for="celular_edit" class="col-form-label col-sm-3">Celular:</label>
                  <div class="col-sm-7">
                  <input  class="form-control" type="text" name="celular_edit" id="celular_edit"  value="{{$result_edit->celular}}" onkeypress="return justNumbers(event);" required> 
                     <div class="invalid-feedback">Ingrese Celular.</div> 
                  </div>
                </div>


                <div class="form-group row">
                  <label for="telefono" class="col-form-label col-sm-3">Forma de Pago:</label>
                  <div class="col-sm-7">
                      <select class="form-control" name="formapago_edit" id="formapago_edit">
                        @foreach($formapago_edit as $fp_edit)
                        <option value="{{$fp_edit->id}}" >{{$fp_edit->nombre}}</option>
                        @endforeach
                      </select>
                     
                  </div>
                </div>

                <div class="form-group row">
                    <label for="rango_edit" class="col-form-label col-sm-3">Duración:</label>
                  <div class="col-sm-8">
                  <input class="form-control" type="text" name="rango_edit" id="rango_edit" value="{{date('d/m/Y',strtotime($result_edit->fecha_ini))}} - {{date('d/m/Y',strtotime($result_edit->fecha_fin))}}" >
                  </div>
                  <input class="form-control" type="hidden" name="fecha_ini_edit" id="fecha_ini_edit" value="{{$result_edit->fecha_ini}}">
 
                  <input class="form-control" type="hidden"  name="fecha_fin_edit" id="fecha_fin_edit" value="{{$result_edit->fecha_fin}}">
                </div>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" >Guardar</button>
            </div>
</form>
<script type="text/javascript">
    $('#formapago_edit').val({{$result_edit->formapago}});
    $('#formapago_edit').select2({
      theme: 'bootstrap4'
    })
	  remove_cursor_wait();
	  $('#modale').modal();
	  $('button[name=editar]').attr('disabled',false);

        $('input[name="rango_edit"]').daterangepicker({
         drops: 'up',
        opens: 'right',
        "locale": {
          "format": "DD/MM/YYYY",
          "separator": " - ",
          "applyLabel": "Aceptar",
          "cancelLabel": "Cancelar",
          "fromLabel": "Desde",
          "toLabel": "Hasta",
          "customRangeLabel": "Custom",
          "weekLabel": "S",
          "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
          ],
          "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
          ],
          "firstDay": 1
        }
      }, function(start, end, label) {
        $('#fecha_ini_edit').val(start.format('YYYYMMDD'));
        $('#fecha_fin_edit').val(end.format('YYYYMMDD'));
      });

    var form2=document.getElementById('edit_vendedor');


    form2.addEventListener('submit', (event) => {
     event.preventDefault();
      if (!form2.checkValidity()) {
        event.stopPropagation();
      }else {
        const edit_sup = new FormData(form2); 
            $.ajax({
                url:"{{asset('')}}cliente/{{$id}}",
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
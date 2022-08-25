    <form  class="needs-validation" id="edit_promocion" autocomplete="off" novalidate>
       @csrf 
       {{ method_field('PUT') }}
        <div class="modal-header">
            <h4 class="modal-title">Editar</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">   
            <div class="col-md-12">
                <input class="form-control" type="hidden" name="idunic" id="idunic" readonly="readonly"  value="{{$result_edit->id}}">


                <div class="form-group row">
                    <label for="nombre_edit" class="col-form-label col-sm-3">Nombre:</label>
                  <div class="col-sm-8">
                    <input class="form-control" type="text" name="nombre_edit" id="nombre_edit"  value="{{$result_edit->nombre}}" required maxlength="100">
                     <div class="invalid-feedback">Ingrese Nombre.</div> 
                  </div>
                </div>

                <div class="form-group row">
                  <label for="descripcion_edit" class="col-form-label col-sm-3">Descripción:</label>
                  <div class="col-sm-8">
                      <textarea class="form-control"  name="descripcion_edit" id="descripcion_edit" required  maxlength="1000">{{$result_edit->descripcion}}</textarea>

                      <div class="invalid-feedback">Ingrese Descripción.</div> 
                  </div>                  
                </div>                

                <div class="form-group row">
                    <label for="precio_edit" class="col-form-label col-sm-3">Precio:</label>
                      <div class="col-sm-8">
                        <input class="form-control" type="text" name="precio_edit" id="precio_edit"  value="{{$result_edit->precio}}" onkeypress="return Limitante(event,this);" required pattern="[0-9]{1,4}([.]{1}?([0-9]{1,2})?)?">
                      </div>
                    <div class="invalid-feedback">Ingrese Precio.</div>   
                </div>


                <div class="form-group row">
                    <label for="nombre" class="col-form-label col-sm-3">Seleccione:</label>
                  <div class="col-sm-4">

                      <input type="checkbox" value="3" id="3"  /> Imagen<br/>
                      <input type="checkbox" value="4"  id="4" /> Url <br/>

                  </div>
                </div>


                <div id="habilitar_imagen_edit" style="display: none;">             
                <div class="form-group row">
                <label for="nombre" class="col-form-label col-sm-3">Imagen:</label>
                  <div class="col-sm-4">
                   <label for="imagen_edit" class="btn btn-info"> <i class="fas fa-upload"></i></label>
                    <input type="file" id="imagen_edit"  name="imagen_edit" style='display: none;' accept="image/*" />
                  </div> 
                    <div class="col-sm-4" id="imagePreview_edit">
     
                    </div>
                </div>
                </div> 


                <div id="habilitar_url_edit" style="display: none;">
                 <div class="form-group row">
                  <label for="url_edit" class="col-form-label col-sm-3">Url:</label>
                  <div class="col-sm-8 input-group mb-3">
                  <input class="form-control" type="text" name="url_edit" id="url_edit" placeholder="URL"  maxlength="1000" >
                  <div class="input-group-append" >
                    <span class="input-group-text" onclick="mostrarUrl();" style="cursor:pointer;"><i class="fas fa-check"></i></span>
                  </div> 
                  </div>
                   <div class="col-sm-12" id="imagePreviewUrl_edit" align="center">
                      
                    </div>
                 </div>
                 </div> 
                  <div class="form-group row">
                    <label for="rango_edit" class="col-form-label col-sm-3">Tiempo:</label>
                  <div class="col-sm-8">
                  <input class="form-control" type="text" name="rango_edit" id="rango_edit" value="{{date('d/m/Y',strtotime($result_edit->fecha_ini))}} - {{date('d/m/Y',strtotime($result_edit->fecha_fin))}}" >
                  </div>
                  <input class="form-control" type="hidden" name="fecha_ini_edit" id="fecha_ini_edit" value="{{$result_edit->fecha_ini}}">
 
                  <input class="form-control" type="hidden"  name="fecha_fin_edit" id="fecha_fin_edit" value="{{$result_edit->fecha_fin}}">
                </div>


                <input type="hidden" name="imagenanterior" id="imagenanterior" value="{{$result_edit->url_imagen}}">

                 <input type="hidden" name="validar_edit" id="validar_edit" value="">
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

    $(document).ready(function() {

        function filePreview2(input){
          if (input.files && input.files[0]) {
            var reader = new FileReader();
             reader.onload = function(e){
              $('#imagePreview_edit').html("<img src='"+e.target.result+"' width='150' heigth='150'>");
             }
             reader.readAsDataURL(input.files[0]);
          }
        }
        $('#imagen_edit').change(function(){
          filePreview2(this);
        })
        
        $('input[type=checkbox]#3').on('click', function(){
        $('#url_edit').val('');
        $('#imagePreviewUrl_edit').html('');
        $('#habilitar_url_edit').css({'display':'none'});
        $('#habilitar_imagen_edit').css({'display':'block'});

        $('input[type=checkbox]#4').prop('checked',false);
        $(this).prop('checked', true);

        });

        $('input[type=checkbox]#4').on('click', function(){
        $('#imagen_edit').val('');
        $('#imagePreview_edit').html('');
        $('#habilitar_url_edit').css({'display':'block'});
        $('#habilitar_imagen_edit').css({'display':'none'});
        $('input[type=checkbox]#3').prop('checked',false);
        $(this).prop('checked', true);
    	});

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
       
        function mostrarUrl(){
            var infourl = $("#url_edit").val();
            $('#imagePreviewUrl_edit').html("<img src='"+infourl+"' width='150' heigth='150' onerror=errorurl(); >");
            $("#validar_edit").val('correcto');
        }

        function errorurl(){
             $('#imagePreviewUrl_edit').html("<b style='color:red;'>Imagen no encontrada</b>");
             $("#url_edit").val('');
             $("#validar_edit").val('incorrecto');
        }

    });


    


    var form2=document.getElementById('edit_promocion');

    form2.addEventListener('submit', (event) => {
     event.preventDefault();
      if (!form2.checkValidity()) {
        event.stopPropagation();
      }else {
        const edit_sup = new FormData(form2); 
            $.ajax({
                url:"{{asset('')}}promociones/{{$result_edit->id}}",
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







    function Limitante2(evt, input) {
            var key = window.Event ? evt.which : evt.keyCode;
            var chark = String.fromCharCode(key);
            var tempValue = input.value + chark;
 
 
            if (key==46 || (key >= 48 && key <= 57)  ) {
                if (filter2(tempValue) === false) {
                    return false;
                } else {
                    return true;
                }
            } else {
                if (key == 8 || key == 13 || key == 0 || key == 188) {
                    return true;
                }  else {
                    return false;
                }
            }
        }


        function filter2(_val_) {
            var regexp = /^[0-9]{1,2}([.]{1}?([0-9]{1,2})?)?$/;

            if (regexp.test(_val_) === true) {
                return true;
            } else {
                return false;
            }

        }

</script>
<form  class="needs-validation" id="edit_local" autocomplete="off" novalidate>
   @csrf 
   {{ method_field('PUT') }}
    <div class="modal-header">
  
    <h4 class="modal-title">Editar</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">   
            <div class="col-md-12">

<input class="form-control" type="hidden" name="idunic" id="idunic" readonly="readonly"  value="{{$result_edit->id}}">

<input class="form-control" type="hidden" name="id_anterior" id="id_anterior" readonly="readonly"  value="{{$result_edit->id_supervisor}}">

                <div class="form-group row">
                    <label for="nombre_edit" class="col-form-label col-sm-3">Nombre:</label>
                  <div class="col-sm-8">
                    <input class="form-control" type="text" name="nombre_edit" id="nombre_edit"  value="{{$result_edit->nombre}}" required maxlength="100">
                     <div class="invalid-feedback">Ingrese Nombre.</div> 
                  </div>
                </div>

                <div class="form-group row">
                  <label for="superv_edit" class="col-form-label col-sm-3">Supervisor:</label>
                  <div class="col-sm-8">
                    <select id="superv_edit" name="superv_edit" class="form-control select2"  style="width:100%" >
                       @for($j=0;$j<sizeof($lisup_edit);$j++)
                          <option value="{{$lisup_edit[$j][0]}}">{{$lisup_edit[$j][1]}}</option> 
                       @endfor                     
                    </select>
                  </div>
                </div> 
                <div class="form-group row">
                  <label for="descripcion_edit" class="col-form-label col-sm-3">Descripción:</label>
                  <div class="col-sm-8">
                      <input class="form-control" type="text"  placeholder="Descripción" name="descripcion_edit" id="descripcion_edit"  value="{{$result_edit->descripcion}}" required  maxlength="1000">
                      <div class="invalid-feedback">Ingrese Descripción.</div> 
                  </div>                  
                </div>                

                <div class="form-group row">
                    <label for="telefono_edit" class="col-form-label col-sm-3">Teléfono:</label>
                  <div class="col-sm-8">
                  <input class="form-control" type="text" name="telefono_edit" id="telefono_edit"  value="{{$result_edit->telefono}}"onkeypress="return justNumbers(event);" required maxlength="10">
                  </div>
                </div>
                <div class="form-group row">
                    <label for="direccion_edit" class="col-form-label col-sm-3">Direccion:</label>
                  <div class="col-sm-8">
                  <input class="form-control" type="text" name="direccion_edit" id="direccion_edit"  value="{{$result_edit->direccion}}" required maxlength="1000">
                  </div>
                </div>

                <p style="text-align: center;font-weight: bold;font-size: 17px;">-- Coordenadas --</p>

                <div class="form-group" >
                  <div class="d-flex justify-content-center">
                    <div class="col-md-10" >
                      
                        <input type="text" name="autocomplete_edit" id="autocomplete_edit" class="form-control" />
                        <div id="mapid_edit"></div>
                     
                    </div>
                  </div>
                    <input type="hidden" name="latitud_edit" id="latitud_edit" value="{{ $result_edit->latitud }}">
                    <input type="hidden" name="longitud_edit" id="longitud_edit" value="{{ $result_edit->longitud }}">
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

                <input type="hidden" name="imagenanterior" id="imagenanterior" value="{{$result_edit->url_image}}">

                <input type="hidden" name="validar_edit" id="validar_edit" value="">
            </div>

    </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" >Guardar</button>
            </div>
</form>

<script type="text/javascript">



    $('#superv_edit').val({{$result_edit->id_supervisor}});
        $('#superv_edit').select2({
      theme: 'bootstrap4'
    })
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

        const myLatLng2=new google.maps.LatLng({{ $result_edit->latitud }},{{ $result_edit->longitud }});

        const options_edit = {
            mapTypeControl: true,
            center:myLatLng2,
            zoom: 18,
            gestureHandling: 'greedy',
        }

        var map_edit= document.getElementById('mapid_edit');

        const mapa_edit= new google.maps.Map(map_edit,options_edit);
        mapa_edit.setTilt(45);

        const marcado= new google.maps.Marker({
          position: myLatLng2,
          draggable: true,
          map: mapa_edit
        });
        var contentString = '<div><b>Coord. X:</b>'+ {{ $result_edit->latitud }} +'</div><div><b>Coord. Y:</b>'+ {{ $result_edit->longitud }}+'</div>';

        var informacion = new google.maps.InfoWindow({
            content: contentString
        });


        function smoothZoom (map, max, cnt) {
            if (cnt >= max) {
                return;
            }
            else {
                z = google.maps.event.addListener(mapa, 'zoom_changed', function(event){
                    google.maps.event.removeListener(z);
                    smoothZoom(map, max, cnt + 1);
                });
                setTimeout(function(){map.setZoom(cnt)}, 80); 
            }
        }        

        marcado.addListener('click',function(){
            informacion.open(mapa_edit,marcado);
             mapa_edit.setCenter(marcado.getPosition());
             smoothZoom(mapa_edit, 17, mapa_edit.getZoom());
        });

        var autocomplete=document.getElementById('autocomplete_edit');
        const search= new google.maps.places.Autocomplete(autocomplete);
        search.bindTo("bounds",mapa_edit);

  ///////////////////////////////////////////////////////
    search.addListener('place_changed', function(){
        informacion.close();
        marcado.setVisible(false);
        var place= search.getPlace();

        if(!place.geometry.viewport){
          window.alert("Error al mostrar el lugar");
          return;
        }else  {
          mapa_edit.setCenter(place.geometry.location);
          mapa_edit.setZoom(20);
        }
        marcado.setPosition(place.geometry.location);
        marcado.setVisible(true);

        $('#latitud_edit').val(place.geometry.location.lat());
        $('#longitud_edit').val(place.geometry.location.lng());
        informacion.setContent('<div><b>Coord. X:</b>'+ place.geometry.location.lat() +'</div><div><b>Coord. Y:</b>'+ place.geometry.location.lng()+'</div>');


      })
    /////////////////////////////////////////////////////////////////////////////
        marcado.addListener("dragend", function (ev) {
              var valorx = ev.latLng.lat();
              var valory = ev.latLng.lng();

               informacion.setContent('<div><b>Coord. X:</b>'+ valorx +'</div><div><b>Coord. Y:</b>'+ valory +'</div>');
                $('#latitud_edit').val(valorx);
                $('#longitud_edit').val(valory);
        });

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
    


    var form2=document.getElementById('edit_local');

    form2.addEventListener('submit', (event) => {
     event.preventDefault();
      if (!form2.checkValidity()) {
        event.stopPropagation();
      }else {
        const edit_sup = new FormData(form2); 
            $.ajax({
                url:"{{asset('')}}local/{{$result_edit->id}}",
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
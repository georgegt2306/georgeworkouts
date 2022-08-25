@extends('plantilla')
@section('content')

<style type="text/css">
#mapid {
    height: 300px;
    width: 100%;
}

#mapid_edit {
    height: 300px;
    width: 100%;
}
.pac-container {
    z-index: 1051 !important;
}
</style>

<section class="content" style="margin-top: 15px;">
    <div class="row"> 
        <div class="col-md-12">
          <div class="card">
              <div class="card-header">
                <h2 class="card-title">Locales</h2>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                
              @if(sizeof($lisup)==0)
                  <button  type="button" title="Nuevo"  class="btn btn-primary" style="margin-bottom: 10px" disabled>Nuevo</button>  <span style="color:red">¡ NECESITA CREAR SUPERVISOR !</span>
              @else
                <button  type="button" title="Nuevo"  class="btn btn-primary" style="margin-bottom: 10px" data-toggle="modal" data-target="#modalcreate">Nuevo</button>   
               @endif  
                <div id="contenedor_principal" class="col-md-12" >



                </div>
               
              </div>
            </div>
          </div>
        </div>  
</section>




 <div class="modal fade" id="modalcreate" tabindex="-1" role="dialog" aria-labelledby="modalcreateTitle" aria-hidden="true"     data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
          <div class="modal-content">
            <form class="needs-validation" id="crear_local" autocomplete="off"  novalidate>
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Nuevo</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">            
           
                <div class="form-group row">
                  <label for="ruc" class="col-form-label col-sm-3">RUC:</label>
                  <div class="col-sm-8">
                    <input class="form-control" type="text" placeholder="RUC" name="ruc" id="ruc"  onkeypress="return justNumbers(event);" required pattern="|[0-9]{13}" maxlength="13">
                     <div class="invalid-feedback">Ingrese RUC.</div> 
                  </div>
                </div>                
                <div class="form-group row">
                  <label for="nombre" class="col-form-label col-sm-3">Nombre:</label>
                  <div class="col-sm-8">
                      <input class="form-control" type="text"  placeholder="Nombre" name="nombre" id="nombre" required maxlength="150">
                      <div class="invalid-feedback">Ingrese Nombre.</div> 
                  </div>
                </div>
                <div class="form-group row">
                  <label for="superv" class="col-form-label col-sm-3">Supervisor:</label>
                  <div class="col-sm-8">
                    <select id="superv" name="superv" class="form-control"  style="width:100%">
                       @for($i=0;$i<sizeof($lisup);$i++)
                          <option value="{{$lisup[$i][0]}}">{{$lisup[$i][1]}}</option> 
                       @endfor                     
                    </select>
                  </div>
                </div>    

                <div class="form-group row">
                  <label for="descripcion" class="col-form-label col-sm-3">Descripción:</label>
                  <div class="col-sm-8">
                      <input class="form-control" type="text"  placeholder="Descripción" name="descripcion" id="descripcion" required  maxlength="1000">
                      <div class="invalid-feedback">Ingrese Descripción.</div> 
                  </div>
                </div>
                <div class="form-group row">
                    <label for="telefono" class="col-form-label col-sm-3">Teléfono:</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="tel" placeholder="Teléfono" name="telefono" id="telefono" onkeypress="return justNumbers(event);" required  maxlength="10" >
                            <div class="invalid-feedback">Ingrese teléfono.</div> 
                        </div>
                        
                </div>                
                <div class="form-group row">
                  <label for="direccion" class="col-form-label col-sm-3">Dirección:</label>
                  <div class="col-sm-8">
                    <input class="form-control" type="text" placeholder="Dirección" name="direccion" id="direccion" required  maxlength="1000">
                    <div class="invalid-feedback">Ingrese direccion.</div> 
                  </div>
                </div>

                <p style="text-align: center;font-weight: bold;font-size: 17px;">-- Coordenadas --</p>

                <div class="form-group" >
                  <div class="d-flex justify-content-center">
                    <div class="col-md-10" >
                      
                        <input type="text" name="autocomplete" id="autocomplete" class="form-control">
                        <div id="mapid"></div>
                     
                    </div>
                  </div>
                    <input type="hidden" name="latitud" id="latitud">
                    <input type="hidden" name="longitud" id="longitud">
                </div>

                <div class="form-group row">
                      <label for="nombre" class="col-form-label col-sm-3">Seleccione:</label>
                    <div class="col-sm-4">
                        <input type="checkbox" value="1" id="1"  /> Imagen<br/>
                        <input type="checkbox" value="2"  id="2" /> Url <br/>
                    </div>
                </div>

                <div id="habilitar_imagen" style="display: none;">             
                <div class="form-group row">
                    <label for="nombre" class="col-form-label col-sm-3">Imagen:</label>
                  <div class="col-sm-4">
                    <label for="file" class="btn btn-info"> <i class="fas fa-upload"></i></label>
                    <input type="file" name="file" id="file" style='display: none;' accept="image/*" />
                  </div>
                    <div class="col-sm-4" id="imagePreview">
                    
                    </div>
                </div>
                </div> 

                <input type="hidden" name="validar" id="validar" value="">
                  
                 <div id="habilitar_url" style="display: none;">
                 <div class="form-group row">
                  <label for="url" class="col-form-label col-sm-3">Url:</label>
                  <div class="col-sm-8 input-group mb-3">
                  <input class="form-control" type="text" name="url" id="url" placeholder="URL"  maxlength="1000" >
                  <div class="input-group-append" >
                    <span class="input-group-text" onclick="mostrarUrl();" style="cursor:pointer;"><i class="fas fa-check"></i></span>
                  </div> 
                  </div>
                   <div class="col-sm-12" id="imagePreviewUrl" align="center">
                      
                    </div>
                 </div>
                 </div> 


              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" >Guardar</button>
            </div>
        </form>
          </div>
        </div>
      </div>


      <div class="modal fade" id="modale" tabindex="-1" role="dialog" aria-labelledby="modaleditTitle" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
       <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
          <div class="modal-content" id="vistamodal_edit">               
          </div>
       </div>
      </div>

  @stop
  @section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDPvCzKd8wSAV2oEFkmSXd7kjGivjVEZ2E&libraries=places"></script>
  <script type="text/javascript">

    $('#superv').select2({
      theme: 'bootstrap4'
    })

class Localizacion{
  constructor(callback){
    if(navigator.geolocation){
      navigator.geolocation.getCurrentPosition((position)=>{
              this.latitude =position.coords.latitude;
              this.longitude=position.coords.longitude;
              callback();
      });    
    } else{
        alert("tu navegador no soporta geolocation")
    }
  } 
}


  const ubicacion = new Localizacion(()=>{
  const myLatLng={lat: ubicacion.latitude, lng: ubicacion.longitude};

        $('#latitud').val(ubicacion.latitude);
        $('#longitud').val(ubicacion.longitude);

  const options = {
    mapTypeControl: true,
    center:myLatLng,
    zoom: 18,
    gestureHandling: 'greedy',
  }

  var map= document.getElementById('mapid');

  const mapa= new google.maps.Map(map,options);
  mapa.setTilt(45);


  const marcado= new google.maps.Marker({
      position: myLatLng,
      draggable: true,
      map: mapa
  });

  var contentString = '<div><b>Coord. X:</b>'+ ubicacion.latitude +'</div><div><b>Coord. Y:</b>'+ ubicacion.longitude+'</div>';

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
    informacion.open(mapa,marcado);
     mapa.setCenter(marcado.getPosition());
     smoothZoom(mapa, 17, mapa.getZoom());
  });


  var autocomplete=document.getElementById('autocomplete');
  const search= new google.maps.places.Autocomplete(autocomplete);
  search.bindTo("bounds",mapa);

  ///////////////////////////////////////////////////////
    search.addListener('place_changed', function(){
        informacion.close();
        marcado.setVisible(false);
        var place= search.getPlace();

        if(!place.geometry.viewport){
          window.alert("Error al mostrar el lugar");
          return;
        }else  {
          mapa.setCenter(place.geometry.location);
          mapa.setZoom(20);
        }
        marcado.setPosition(place.geometry.location);
        marcado.setVisible(true);

        $('#latitud').val(place.geometry.location.lat());
        $('#longitud').val(place.geometry.location.lng());
        informacion.setContent('<div><b>Coord. X:</b>'+ place.geometry.location.lat() +'</div><div><b>Coord. Y:</b>'+ place.geometry.location.lng()+'</div>');


      })
    /////////////////////////////////////////////////////////////////////////////
        marcado.addListener("dragend", function (ev) {
              var valorx = ev.latLng.lat();
              var valory = ev.latLng.lng();

               informacion.setContent('<div><b>Coord. X:</b>'+ valorx +'</div><div><b>Coord. Y:</b>'+ valory +'</div>');
                $('#latitud').val(valorx);
                $('#longitud').val(valory);
        });

});


    function consultar_tabla(){  
        $("#contenedor_principal").html("<div style='text-align:center'><img src='{{asset('/dist/img/espera.gif')}}' style='pointer-events:none' width='300'  height='200' /></div>");


         var qw = '<table id="Local" class="table display responsive table-bordered table-striped" style="width:100%">';  
      
        cursor_wait();
        $.get("{{asset('')}}local/consultar").then((data)=> {
            $('#contenedor_principal').html(qw);
            $("#Local").DataTable({
                "language": {
                    "lengthMenu": "Mostrar _MENU_ Registros",
                    "zeroRecords": "No hay registros...",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrados de _MAX_ registros totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Sigue",
                        "previous": "Previo"
                    },
                },
                columnDefs: [
                  { width: 40, targets: 0 },
                  { width: 80, targets: 1 }
                ],
                "responsive": true,
                columns:data.titulos,
                data:data.sms
            });
                     remove_cursor_wait();
        });
    }

    consultar_tabla();


   (function(){
    function filePreview(input){
      if (input.files && input.files[0]) {
        var reader = new FileReader();
         reader.onload = function(e){
          $('#imagePreview').html("<img src='"+e.target.result+"' width='150' heigth='150' >");
         }
         reader.readAsDataURL(input.files[0]);
      }
    }
    $('#file').change(function(){
      filePreview(this);
   
    })
  })();



  $(document).ready(function() {
    $('input[type=checkbox]#1').on('click', function(){
      $('#url').val('');
      $('#validado').val('');
      $('#imagePreviewUrl').html('');
      $('#habilitar_url').css({'display':'none'});
      $('#habilitar_imagen').css({'display':'block'});

      $('input[type=checkbox]#2').prop('checked',false);
      $(this).prop('checked', true);

    });

    $('input[type=checkbox]#2').on('click', function(){
      $('#file').val('');
      $('#imagePreview').html('');
      $('#habilitar_url').css({'display':'block'});
      $('#habilitar_imagen').css({'display':'none'});
      $('input[type=checkbox]#1').prop('checked',false);
      $(this).prop('checked', true);
    });
  });


  function mostrarUrl(){
    var infourl = $("#url").val();
    $('#imagePreviewUrl').html("<img src='"+infourl+"' width='150' heigth='150' onerror=errorurl(); >");
    $("#validar").val('correcto');

  }

  function errorurl(){
     $('#imagePreviewUrl').html("<b style='color:red;'>Imagen no encontrada</b>");
     $("#url").val('');
     $("#validar").val('incorrecto');
  }





    var form=document.getElementById('crear_local');
    
    form.addEventListener('submit', (event) => {
    event.preventDefault();
      if (!form.checkValidity()) {
        event.stopPropagation();
        form.classList.add('was-validated');
      }else {
        const crear_sup = new FormData(form); 
            $.ajax({
                url:"{{asset('')}}local",
                headers :{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                dataType: 'json',
                contentType: false,
                processData: false,
                data: crear_sup,
                success:function(res){
                    if(res.sms){
                         consultar_tabla();
                         $('#modalcreate').modal('hide');
                         $("#modalcreate input").val("");
                         $("#modalcreate textarea").val("");
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
            form.classList.remove('was-validated');   
        }
        
    }, false);


    function mostrarmodal(id){
        cursor_wait();
        $('button[name=editar]').attr('disabled',true);
        $("#vistamodal_edit").load("{{asset('')}}local/"+id+"/edit");
    }


    function elim(id){
      Swal.fire({
        closeOnClickOutside:false,
        title: "Aviso !",
        text: "Desea eliminar este registro ? ",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.value) {
            $.ajax({
            url:"{{asset('')}}local/"+id,
            headers :{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'DELETE',
            dataType: 'json',
            success:function(res){
              if(res.sms){
                  consultar_tabla();
                   toastr.success(res.mensaje); 
              }else{
                 Swal.fire({
                  closeOnClickOutside:false,
                  title: res.mensaje,
                  icon: "error",
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'OK',
               });
              }
            }
          })   
            }
      })
    }

  </script>

  @endsection
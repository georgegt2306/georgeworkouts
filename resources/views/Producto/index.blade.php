@extends('plantilla')
@section('content')


<section class="content" style="margin-top: 15px;">
    <div class="row"> 
        <div class="col-md-12">
          <div class="card">
              <div class="card-header">
                <h2 class="card-title">Productos</h2>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                

                <button  type="button" title="Nuevo"  class="btn btn-primary" style="margin-bottom: 10px" data-toggle="modal" data-target="#modalcreate">Nuevo</button>   
              
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
            <form class="needs-validation" id="crear_prodcuto" autocomplete="off"  novalidate>
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Nuevo</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
            <div class="modal-body">               
                
                <div class="form-group row">
                  <label for="nombre" class="col-form-label col-sm-3">Nombre:</label>
                  <div class="col-sm-8">
                      <input class="form-control" type="text"  placeholder="Nombre" name="nombre" id="nombre" required maxlength="150">
                      <div class="invalid-feedback">Ingrese Nombre.</div> 
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
                  <label for="categoria" class="col-form-label col-sm-3">Categoría:</label>
                    <div class="col-sm-8">
                      <select id="categoria" name="categoria" class="form-control"  style="width:100%">
                         @foreach($categoria as $categ)
                            <option value="{{$categ->id}}">{{$categ->nombre}}</option> 
                         @endforeach                     
                      </select>
                    </div>
                </div>  

                <div class="form-group row">
                    <label for="costo" class="col-form-label col-sm-3">Costo:</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" placeholder="Costo" name="costo" id="costo" onkeypress="return Lim_index(event,this);" required pattern="[0-9]{1,4}([.]{1}?([0-9]{1,2})?)?">
                        <div class="invalid-feedback">Ingrese Costo.</div> 
                    </div>     
                </div>

                <div class="form-group row">
                  <label for="precio" class="col-form-label col-sm-3">Precio:</label>
                  <div class="col-sm-8">
                      <input class="form-control" type="text" placeholder="Precio" name="precio" id="precio" onkeypress="return Lim_index(event,this);" required pattern="[0-9]{1,4}([.]{1}?([0-9]{1,2})?)?">
                    <div class="invalid-feedback">Ingrese Precio.</div> 
                  </div>
                </div>

                <div class="form-group row">
                  <label for="unidad" class="col-form-label col-sm-3">Unidad:</label>
                  <div class="col-sm-8">
                      <input class="form-control" type="text" placeholder="Unidad" name="unidad" id="unidad" required maxlength="45">

                      <div class="invalid-feedback">Ingrese Unidad.</div> 
                  </div>
                </div>

                <div class="form-group row">
                  <label for="existencia" class="col-form-label col-sm-3">Existencia:</label>
                  <div class="col-sm-8">
                      <input class="form-control" type="text" placeholder="Existencia" name="existencia" id="existencia" required maxlength="11" onkeypress="return justNumbers(event);">
                    <div class="invalid-feedback">Ingrese Existencia.</div> 
                  </div>
                </div>

                <div class="form-group row">
                  <label for="descuento" class="col-form-label col-sm-3">Descuento:</label>
                  <div class="col-sm-8">
                      <input class="form-control" type="text" placeholder="Descuento" name="descuento" id="descuento" onkeypress="return Lim_index2(event,this);" required pattern="[0-9]{1,2}([.]{1}?([0-9]{1,2})?)?">
                    <div class="invalid-feedback">Ingrese Descuento.</div> 
                  </div>
                </div>

                <div class="form-group row">
                    <label for="iva" class="col-form-label col-sm-3">Iva:</label>
                    <div class="col-sm-8">
                      <input class="form-control" type="text" placeholder="Iva" name="iva" id="iva" onkeypress="return Lim_index2(event,this);" required pattern="[0-9]{1,2}([.]{1}?([0-9]{1,2})?)?">
                      <div class="invalid-feedback">Ingrese Iva.</div> 
                    </div>
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


      <div class="modal fade" id="modale_cons" tabindex="-1" role="dialog" aria-labelledby="modaleditTitle" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
       <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
          <div class="modal-content" id="vistamodal_cons">               
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
  <script type="text/javascript">

    $('#categoria').select2({
      theme: 'bootstrap4'
    })

  function consultar_tabla(){  
        $("#contenedor_principal").html("<div style='text-align:center'><img src='{{asset('/dist/img/espera.gif')}}' style='pointer-events:none' width='300'  height='200' /></div>");


         var qw = '<table id="Producto" class="table display responsive table-bordered table-striped" style="width:100%">';  
      
        cursor_wait();
        $.get("{{asset('')}}producto/consultar").then((data)=> {
            $('#contenedor_principal').html(qw);
            $("#Producto").DataTable({
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
                  { width: 170, targets: 1 }
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



    var form=document.getElementById('crear_prodcuto');
    
    form.addEventListener('submit', (event) => {
      event.preventDefault();
      if (!form.checkValidity()) {
        event.stopPropagation();
         form.classList.add('was-validated');
      }else {
        const crear_sup = new FormData(form); 
            $.ajax({
                url:"{{asset('')}}producto",
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


    function mostrarconsul(id){
        cursor_wait();
        $('button[name=consultar]').attr('disabled',true);
        $("#vistamodal_cons").load("{{asset('')}}producto/info/"+id);
    }


    function mostrarmodal(id){
        cursor_wait();
        $('button[name=editar]').attr('disabled',true);
        $("#vistamodal_edit").load("{{asset('')}}producto/"+id+"/edit");
    }

    function Lim_index(evt, input) {
            var key = window.Event ? evt.which : evt.keyCode;
            var chark = String.fromCharCode(key);
            var tempValue = input.value + chark;
 

            if (key==46 || (key >= 48 && key <= 57)  ) {
                if (filter_index(tempValue) === false) {
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


        function filter_index(_val_) {
            var regexp = /^[0-9]{1,4}([.]{1}?([0-9]{1,2})?)?$/;

            if (regexp.test(_val_) === true) {
                return true;
            } else {
                return false;
            }

        }



    function Lim_index2(evt, input) {
            var key = window.Event ? evt.which : evt.keyCode;
            var chark = String.fromCharCode(key);
            var tempValue = input.value + chark;
 
 
            if (key==46 || (key >= 48 && key <= 57)  ) {
                if (filter_index2(tempValue) === false) {
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


        function filter_index2(_val_) {
            var regexp = /^[0-9]{1,2}([.]{1}?([0-9]{1,2})?)?$/;

            if (regexp.test(_val_) === true) {
                return true;
            } else {
                return false;
            }

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
            url:"{{asset('')}}producto/"+id,
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
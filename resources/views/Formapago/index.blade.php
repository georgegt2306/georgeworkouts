@extends('plantilla')
@section('content')


<section class="content" style="margin-top: 15px;">
    <div class="row"> 
        <div class="col-md-12">
          <div class="card">
              <div class="card-header text-white bg-dark">
                <h2 class="card-title">Forma de Pago</h2>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                

                <button  type="button" title="Nuevo"  class="btn btn-dark" style="margin-bottom: 10px" data-toggle="modal" data-target="#modalcreate">Nuevo</button>   
              
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
            <form class="needs-validation" id="crear_promociones" autocomplete="off"  novalidate>
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
                  <label for="precio" class="col-form-label col-sm-3">Precio:</label>
                  <div class="col-sm-8">
                      <input class="form-control" type="text" placeholder="Precio" name="precio" id="precio" onkeypress="return Limitante(event,this);" required pattern="[0-9]{1,4}([.]{1}?([0-9]{1,2})?)?">
                    <div class="invalid-feedback">Ingrese Precio.</div> 
                  </div>
                </div>

               
                 <!-- <div class="form-group row">
                    <label for="nombre" class="col-form-label col-sm-3">Tiempo de Promo:</label>
                  <div class="col-sm-8">
                  <input class="form-control" type="text" name="rango" id="rango" >
                  </div>
                  <input class="form-control" type="hidden" name="fecha_ini" id="fecha_ini" value="{{ now()->format('Ymd') }}" >


                  <input class="form-control" type="hidden"  name="fecha_fin" id="fecha_fin" value="{{ now()->format('Ymd') }}">
                </div> -->
              
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
  <script type="text/javascript">


// $('input[name="rango"]').daterangepicker({
//     drops: 'up',
//     opens: 'right',
//     "locale": {
//       "format": "DD/MM/YYYY",
//       "separator": " - ",
//       "applyLabel": "Aceptar",
//       "cancelLabel": "Cancelar",
//       "fromLabel": "Desde",
//       "toLabel": "Hasta",
//       "customRangeLabel": "Custom",
//       "weekLabel": "S",
//       "daysOfWeek": [
//         "Do",
//         "Lu",
//         "Ma",
//         "Mi",
//         "Ju",
//         "Vi",
//         "Sa"
//       ],
//       "monthNames": [
//         "Enero",
//         "Febrero",
//         "Marzo",
//         "Abril",
//         "Mayo",
//         "Junio",
//         "Julio",
//         "Agosto",
//         "Septiembre",
//         "Octubre",
//         "Noviembre",
//         "Diciembre"
//       ],
//       "firstDay": 1
//     }
//   }, function(start, end, label) {
//     $('#fecha_ini').val(start.format('YYYYMMDD'));
//     $('#fecha_fin').val(end.format('YYYYMMDD'));
//   });

  function consultar_tabla(){  
        $("#contenedor_principal").html("<div style='text-align:center'><img src='{{asset('/dist/img/espera.gif')}}' style='pointer-events:none' width='300'  height='200' /></div>");


         var qw = '<table id="Promociones" class="table display responsive table-bordered table-striped" style="width:100%">';  
      
        cursor_wait();
        $.get("{{asset('')}}formapago/consultar").then((data)=> {
            $('#contenedor_principal').html(qw);
            $("#Promociones").DataTable({
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
                  { width: 100, targets: 0 }
                ],
                "responsive": true,
                columns:data.titulos,
                data:data.sms
              });
                     remove_cursor_wait();
            });
        }

    consultar_tabla();




    var form=document.getElementById('crear_promociones');
    
    form.addEventListener('submit', (event) => {
      event.preventDefault();
      if (!form.checkValidity()) {
        event.stopPropagation();
        form.classList.add('was-validated');
      }else {
        const crear_sup = new FormData(form); 
            $.ajax({
                url:"{{asset('')}}formapago",
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
        $("#vistamodal_edit").load("{{asset('')}}promociones/"+id+"/edit");
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
            url:"{{asset('')}}promociones/"+id,
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


    function Limitante(evt, input) {
            var key = window.Event ? evt.which : evt.keyCode;
            var chark = String.fromCharCode(key);
            var tempValue = input.value + chark;
 

            if (key==46 || (key >= 48 && key <= 57)  ) {
                if (filter(tempValue) === false) {
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


        function filter(_val_) {
            var regexp = /^[0-9]{1,4}([.]{1}?([0-9]{1,2})?)?$/;

            if (regexp.test(_val_) === true) {
                return true;
            } else {
                return false;
            }

        }

  </script>

  @endsection
@extends('plantilla')
@section('content')
<section class="content" style="margin-top: 15px;">
<div class="row">
    <div class="col-md-12">
     <div class="card">
        <div class="card-header">
            <h2 class="card-title">FILTRO</h2>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
        </div>
        <div class="card-body">   
            <div class="row">
                <div class="col-md-4" >
                   <div class="form-group row">
                        <label  class="col-form-label col-xs-3">Fecha:</label>  
                            <div class="col-sm-9">
                                <div class="form-check">
                                <input  type="checkbox" class="form-check-input" id="ctodos" name="ctodos">
                                <input type="text" class="form-control" id="fec3_rango" name="fec3_rango" >
                                </div>
                            </div>
                            <input type="hidden" name="fec3_desde" id="fec3_desde" value="{{ now()->format('Ymd') }}">
                            <input type="hidden" name="fec3_hasta" id="fec3_hasta" value="{{ now()->format('Ymd') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group row">
                      <label  class="col-form-label col-xs-3">Estado:</label> 
                       <div class="col-sm-8">
                        <select class="form-control" id="comboes" name="comboes" style="width:100%">
                            <option selected value="S">TODOS</option>
                            @foreach($comboestado as $cb_est)
                                <option value="{{$cb_est->id}}">{{$cb_est->nombre}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                </div>

                <div class="col-md-3">
                 <div class="form-group row">
                      <label  class="col-form-label col-xs-3">Vend.:</label> 
                       <div class="col-sm-8">
                        <select class="form-control" id="combovend" name="combovend" style="width:100%">
                            <option selected value="S">TODOS</option>
                            @foreach($combovend as $cb_ven)
                                <option value="{{$cb_ven->id_vend}}">{{$cb_ven->nombre_vend}}  {{$cb_ven->apellido_vend}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" title="Consultar"  id="consultar"  name="consultar" class="btn btn-primary" onclick="Consultar();" data-toggle="tooltip">Consultar</button>
                </div>

            </div>
      </div>      
</div>
</div>
</div>

<div class="row">
<div class="col-md-12">
 <div class="card">
                <div class="card-body">

                 <div id="contenedor_principal" class="col-md-12" >

                 </div>
                </div>
</div>
</div>
</div>

</section>
      <div class="modal fade" id="modale_cons" tabindex="-1" role="dialog" aria-labelledby="modalconsTitle" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
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
    $('#comboes').select2({
      theme: 'bootstrap4'
    })
    $('#combovend').select2({
      theme: 'bootstrap4'
    })
    $( document ).ready(function() {
        $('#fec3_rango').daterangepicker({
            drops: 'down',
            opens: 'right',
            startDate: new Date(), 
            endDate: new Date(),
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
          },function(start, end, label) {
            $('#fec3_desde').val(start.format('YYYYMMDD'));
            $('#fec3_hasta').val(end.format('YYYYMMDD'));
          });
    });

    $('#ctodos').change(function(){
        if($('#ctodos').is(":checked")){
        document.getElementById("fec3_rango").readOnly = true;
        }else{
            document.getElementById("fec3_rango").readOnly = false;
        }
    })

    function mostrarconsul(id){
        cursor_wait();
        $('button[name=consultar_modal]').attr('disabled',true);
        $("#vistamodal_cons").load("{{asset('')}}ventas/info/"+id);
    }
    function mostrarmodal(id){
        cursor_wait();
        $('button[name=editar]').attr('disabled',true);
        $("#vistamodal_edit").load("{{asset('')}}ventas/"+id+"/edit");
    }

    function Consultar(){
        var vendedor= $("#combovend").val();
        var estado= $("#comboes").val();
        var checked=document.getElementById('ctodos').checked;
        var fec1= $('#fec3_desde').val();
        var fec2 = $('#fec3_hasta').val();
        
        $('button[name=consultar]').attr('disabled',true);


        $("#contenedor_principal").html("<div style='text-align:center'><img src='{{asset('/dist/img/espera.gif')}}' style='pointer-events:none' width='300'  height='200' /></div>");

        var qw = '<table id="Ventas" class="table display responsive table-bordered table-striped" style="width:100%">';  
      
            cursor_wait();
            $.get("{{asset('')}}ventas/consultar/"+vendedor+"/"+estado+"/"+fec1+"/"+fec2+"/"+checked).then((data)=> {
                $('#contenedor_principal').html(qw);
                $("#Ventas").DataTable({
                                   "dom": "<'row'<'col-md-4'B><'col-md-4'i><'col-md-4'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
                   buttons: [ 
                      { extend: 'excel', footer: true, title: 'Gestion_pedidos', text:"<img src='{{asset('/dist/img/exportar.png')}}' width='30' height='30'/>",       exportOptions: {
                          columns: [2,3,4,5,6]
                        }
                      },     

                   ],
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
                      { width: 130, targets: 1 }
                    ],

                    "responsive": true,
                    columns:data.titulos,
                    data:data.sms
                });
                $('button[name=consultar]').attr('disabled',false);
                remove_cursor_wait();
            });
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
            url:"{{asset('')}}ventas/"+id,
            headers :{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'DELETE',
            dataType: 'json',
            success:function(res){
              if(res.sms){
                  Consultar();
                   toastr.success(res.mensaje); 
              }else{
                 Swal.fire({
                  closeOnClickOutside:false,
                  title: "Error al Eliminar",
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

	<div class="modal-header">
	  
	    <h4 class="modal-title">Consultar</h4> 
	    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
      <div class="card collapsed-card">
      <div class="card-header">
          <h2 class="card-title">Cabecera</h2>

              <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-plus"></i>
                  </button>
              </div>
      </div>
        <div class="card-body">
          <div class="row">
             <div class="col-md-4">
               <label>ID Pedido:</label>
               {{$cab_venta->id}}
             </div>


             <div class="col-md-4">
               <label>Estado:</label>
               @if(strcmp($cab_venta->id_estado,'1')==0)
               INGRESADO
               @elseif(strcmp($cab_venta->id_estado,'2')==0)
               PROCESANDO
               @else
               ENTREGADO
               @endif
             </div>

              <div class="col-md-4">
               <label>Fecha:</label>
               {{$cab_venta->fecha}}
             </div>

           </div>


            <div class="row">
             <div class="col-md-4">
               <label>Dirección:</label>
                {{$cab_venta->direccion_cliente}}
             </div>

             <div class="col-md-4">
               <label>Cedula Cliente:</label>
               {{$cab_venta->ci_ruc_cliente}}
             </div>

             <div class="col-md-4">
               <label>Cliente:</label>
                {{$cab_venta->nombre_cliente}} {{$cab_venta->apellido_cliente}}
             </div>
           </div>
        </div>
      </div> 
        <button class="btn btn-primary" style="margin-bottom: 10px;" onclick="Imprimir('{{$id}}')"> Imprimir </button>
        <table id="det_venta" class="table display responsive table-bordered table-striped" style="width:100%">
            <thead>
              <tr>
                <th>...</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Costo</th>
                <th>Precio</th>
              </tr>
            </thead>
            <tbody>
              @foreach($det_venta as $det)
              <tr>      
                  <td><img src="{{$det->url_image}}"  width="50" height="50"></td>
                  <td>{{$det->nombre}}</td>
                  <td>{{$det->cantidad}}</td>
                  <td>{{$det->costo}}</td>
                  <td>{{$det->precio}}</td>
                
              </tr>
              @endforeach
            </tbody>  
          </table> 
                     

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>

 <script>
 	  remove_cursor_wait();
    $('#modale_cons').modal();
    $('button[name=consultar_modal]').attr('disabled',false);

    $(document).ready(function() {
      $("#det_venta").DataTable({
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
                      ],
                      "responsive": true
                  });
       });

    function Imprimir(id){
      window.open("{{asset('')}}ventas/imprimir/"+id);
    }
 </script>   
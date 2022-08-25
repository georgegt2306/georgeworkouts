<!DOCTYPE html>
<html >
    <link rel="icon" href="{{ asset('dist/img/LOGO.png')}}">
  <head>
    <title>Reporte</title>

    <link rel="stylesheet" href="{{ asset('/dist/css/consolidadocss.css') }}" media="all" />
  </head>
  <body>
    <header class="clearfix">
    <table style="border: 0;margin-bottom:15px">
        <tr>
	        <td valign="top" style="width: 95%"><h1 style="margin: 0">Reporte</h1></td> 
	        <td valign="bottom" style=" margin: 0"><img  src="{{ asset('/dist/img/LOGO.png')}}"  width="100" height="50"  style="margin:0" /></td>
        </tr>
    </table>

      <div id="company">
        <div>Emitido: {{date("Y-m-d H:i:s")}}</div>
        <div>Usuario: {{ Auth::user()->nombre }}</div>
      </div>

      <div id="project">
      <div>Pedido: {{$id}} -  @if($cab_venta->id_estado=='1')
                Ingresado
            @elseif($cab_venta->estado=='2')
                Procesando
            @elseif($cab_venta->estado=='3')
                Entregado
            @endif </div>

        <div>Cliente - RUC/Cédula: {{$cab_venta->nombre_cliente}} - {{$cab_venta->ci_ruc_cliente}}</div>
        <div>Correo: {{$cab_venta->email_cliente}}</div>
        <div>Dirección: {{$cab_venta->direccion_cliente}}</div>
      </div>
    </header>
    
    <main>
      <table>
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Descuento</th>
            <th>Precio</th>
          </tr>
        </thead>
        <tbody>
         @foreach ($det_venta as $dt_ve)
         <tr>
         <td> {{$dt_ve->nombre}}</td>
          <td>{{$dt_ve->descripcion}}</td>
          <td> {{$dt_ve->cantidad}}</td>
          <td> $  {{number_format($dt_ve->descuento, 2)}}</td>
         <td> $  {{number_format($dt_ve->precio, 2)}}</td>
         </tr>
         @endforeach


          <tr>
            <td colspan="4" class="grand total">Subtotal</td>
            <td class="grand total">$  {{number_format($cab_venta->subtotal, 2)}}</td>
          </tr>
           <tr>
            <td colspan="4" class="grand total">Descuento</td>
            <td class="grand total">$  {{$cab_venta->descuento}}</td>
          </tr>
           <tr>
            <td colspan="4" class="grand total">IVA</td>
            <td class="grand total">$  {{$cab_venta->iva}}</td>
          </tr>
           <tr>
            <td colspan="4" class="grand total">Total</td>
            <td class="grand total">$  {{number_format($cab_venta->total, 2)}}</td>
          </tr>
      </tbody>
      </table>
    
    
      

    </main>

  </body>
</html>
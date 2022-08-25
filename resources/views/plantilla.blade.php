<!DOCTYPE html>
<html>
    <link rel="icon" href="{{ asset('/dist/img/LOGO.png')}}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>George Workouts</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/dist/css/cursor.css')}}">
    <link rel="stylesheet" href="{{ asset('/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/plugins/daterangepicker/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css')}}">
    <link href="{{ asset('/plugins/ionicons.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.1/css/fixedHeader.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.5.5/css/colReorder.bootstrap4.min.css">
    



    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
<div class="wrapper">
    @include('include.header')
    @include('include.sidebar')
    <div class="content-wrapper">
        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
        @yield('content')      
    </div>
</div>
</body>
<!-- jQuery -->
    <script src="{{ asset('/plugins/jQuery/jquery.min.js')}}"></script>
    <script src="{{ asset('/dist/js/adminlte.js')}}"></script>
    <script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{asset('/plugins/sweetalert2.js')}}"></script>
    <script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{ asset('/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.1/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
 

        




    <script src="{{ asset('/dist/js/cursor.js') }}"></script>
    @yield('script')
    
    <script type="text/javascript">

    function cerrar(){
     Swal.fire({    title: " ! Aviso !",
                    text: "Esta seguro que desea Salir?",
                    imageUrl: '{{asset('/dist/img/LOGO.png')}}',
                    imageWidth: 200,
                    imageHeight: 200,
                    imageAlt: 'Custom image',
                    width:400,
                    height:400,
                    animation: true,
                    background:'white',
                    showCancelButton: true,
                    confirmButtonColor: 'black',
                    cancelButtonColor: '#CFCFC7',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.value==true) { 
                $.ajax({
                url:"{{asset('')}}logout",
                headers :{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                dataType: 'json',
                contentType: false,
                processData: false,
                success:function(res){
                 if(res.sms==true){
                        window.location = "{{asset('')}}";
                 }else{
                     console.log(res.mensaje);
                 }
               },
               error: function(XMLHttpRequest, textStatus, errorThrown) {
                  if (errorThrown=='Unauthorized') {
                    location.reload();
                  }
                }
       });  
            }
         });
    }   


  function soloLetras(e) {
    var key = e.keyCode || e.which,
      tecla = String.fromCharCode(key).toLowerCase(),
      letras = " áéíóúabcdefghijklmnñopqrstuvwxyz",
      especiales = [8, 37, 39, 46],
      tecla_especial = false;

    for (var i in especiales) {
      if (key == especiales[i]) {
        tecla_especial = true;
        break;
      }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
      return false;
    }
  }

      toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": true,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": true,
      "onclick": null,
      "showDuration": "500",
      "hideDuration": "1000",
      "timeOut": "2000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }


    function justNumbers(e){
      var keynum = window.event ? window.event.keyCode : e.which;
      if ((keynum == 8) || (keynum == 46))
      return true;
          
      return /\d/.test(String.fromCharCode(keynum));
    }
    </script>
    
</html>
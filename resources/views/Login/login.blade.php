<!DOCTYPE html>
<html>
<link rel="icon" href="{{ asset('/dist/img/LOGO.png')}}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
    name="viewport">
<style type="text/css">


body {
    margin: 0;
    padding: 0;
    background: url("{{asset('dist/img/fondo.jpg')}}")  center top;
    background-size: 100% 100%;
    font-family: sans-serif;
    height: 10vh;

    }
  .login-box {
      background: #fff;     
      width: 420px;
      height: 300px;
      padding: 10px 10px 20px 10px;     
      opacity: 0.95; 
      padding: 10px 10px 20px 10px;
      border-radius:20px ;
      top: 50%;
      left: 75%;
      position: absolute;
      transform: translate(-50%, -50%);
      box-sizing: border-box;  
  }
.login-box .avatar {
  width: 100px;
  height: 100px;
  position: absolute;
  top: -70px;
  left: calc(50% - 50px);
}


  @media screen and (max-width: 1000px) {
body {
    margin: 0;
    padding: 0;
    background: black;

    background-size: 100% 100%;
    font-family: sans-serif;
    height: 10vh;

    }
      .login-box {
        background: #fff;
        border-radius:20px ;
        width: 400px;
        height: 300px
        display: block;
        border-radius:20px ;
        top:50%;
        left: 50%;
        position: absolute;
      
    }
    .login-box .avatar {
        display: block;
        width: 100px;
        height: 100px;
        
        position: absolute;
        top: -70px;
        left: calc(50% - 50px);
      }
  }





.login-box a {
  display: inline-block;
  color: black;
  transition: all ease-in-out 1s;
}

.login-box a:after {
  content: '';
  width: 0px;
  height: 1px;
  display: block;
  background: black;
  transition: 1s;
}

.login-box a:hover:after {
    width: 100%;
    text-decoration: underline;
}



  #olvidecon{
    font-family: 'Roboto'; 
    
  }
  #olvidecon:hover{
    color: black;
    font-weight: bold;
  }
  

  #loginmercy{
    font-family: 'Roboto'; 
    background-color: black;
    color: white; 
    transition: all ease-in-out 1s; 
  }

  #loginmercy:hover{
   background-color: #93948F;
   border: 2px black solid;
 }

#loginmercy:after {
  content: '';
  width: 0px;
  height: 1px;
  display: block;
  background: black;
  transition: 1s;
}

#loginmercy:hover:after {
    width: 100%;
    background: white;
    text-decoration: underline;
}
</style>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>George Workouts</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{ asset('/plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css')}}">
  <link href="{{ asset('/plugins/ionicons.css')}}">
  <!-- Theme style -->
<link rel="stylesheet" href="{{ asset('/dist/css/adminlte.min.css')}}">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">

</head> 
<body >
<div class="login-box"  style="background-color:#CFCFC7; border: black solid 1px">
  <img src="{{ asset('/dist/img/LOGO.png')}}"  class="avatar" />
  <!-- /.login-logo -->
   <div style="padding: 40px">

        <div class="input-group mb-3">
          <input type="email" class="form-control" id="email1" placeholder="Email" autocomplete="off">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" id="password1" placeholder="Password" autocomplete="off">
          <div class="input-group-append">
            <div class="input-group-text"  onclick="mostrarPassword();">
              <span class="fa fa-eye-slash icon"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12" style="display: block !important;margin: 0 !important">
            
            <button type="button" class="btn  btn-block" id="loginmercy" onclick="ingresar();" > Iniciar sesión </button>
          
          </div>
          <!-- /.col -->  
        </div>
         <div class="col-md-12" ></br>
          <a href="{{asset('/recuperar')}}" id="olvidecon"> Olvide contraseña</a>
      </div>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('/plugins/jQuery/jquery.min.js')}}"></script>
<script src="{{ asset('/dist/js/adminlte.min.js')}}"></script>
<script src="{{asset('/plugins/sweetalert2.js')}}"></script>
<script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>

<script type="text/javascript">
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



  function mostrarPassword(){
    var cambio = document.getElementById("password1");
    if(cambio.type == "password"){
      cambio.type = "text";
      $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
    }else{
      cambio.type = "password";
      $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }
  } 


  document.body.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
      ingresar();
    }
  });

  function ingresar(){
     var email1 = document.getElementById('email1').value;
     var password1 = document.getElementById('password1').value;
     var expresion = /^[a-z][\w.-]+@\w[\w.-]+\.[\w.-]*[a-z][a-z]$/i;
      
      if (!expresion.test(email1)){
        
        toastr.error("Formato de email incorrecto");
         setTimeout(function(){ $("#email1").val(""); 
            document.getElementById("email1").focus();
          }, 500);
        
        
      }
      else if (password1=='') {
          toastr.error("Ingrese Contraseña");

           setTimeout(function(){ 
              document.getElementById("password1").focus();
            }, 500);
      }else {
        var datos = new FormData();
        datos.append("email", email1);
        datos.append("password", password1);

         $.ajax({
              url:"{{asset('')}}ingresar",
              headers :{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              type: 'POST',
              dataType: 'json',
              contentType: false,
              processData: false,
              data: datos,
              success:function(res){
               if(res.sms==true){
                     // var pathname = window.location.pathname;
                      window.location = "{{asset('')}}home";
               }else{
                  toastr.error(res.mensaje);
                  
               }
             },
             error: function(XMLHttpRequest, textStatus, errorThrown) {
                if (errorThrown=='Unauthorized') {
                  location.reload();
                }
              }
         });   
      }

  


  }
</script>

</body>
</html>

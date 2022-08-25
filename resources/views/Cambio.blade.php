<!DOCTYPE html>
<html>
<link rel="icon" href="{{ asset('/dist/img/LOGO.png')}}">
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
      width: 500px !important;
      height: 150px;
      opacity: 0.95; 
      padding: 10px 10px 20px 10px;
      border-radius:20px ;
      top: 50%;
      left: 50%;
      position: absolute;
      transform: translate(-50%, -50%);
      box-sizing: border-box;  
      background-color: #59B259;
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
    background-color: #3D5C9D !important;
    background: none;

    background-size: 100% 100%;
    font-family: sans-serif;
    height: 10vh;

    }
      .login-box {
        background: #fff;
        border-radius:20px ;
        width: 400px;
        height: 200px
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



}




</style>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Pasaje Comercial Mercy</title>
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
<div class="login-box" >
  <img src="{{ asset('/dist/img/LOGO.png')}}"  class="avatar" />
  <!-- /.login-logo -->
   <div style="padding: 40px">

   	<h2> CAMBIO EXITOSO <i class="fa fa-check"></i></h2>
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('/plugins/jQuery/jquery.min.js')}}"></script>
<script src="{{ asset('/dist/js/adminlte.min.js')}}"></script>
<script src="{{asset('/plugins/sweetalert2.js')}}"></script>


</body>
</html>

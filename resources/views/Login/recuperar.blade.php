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
      width: 420px;
      height: 300px;
      padding: 10px 10px 20px 10px;     
      opacity: 0.95; 
      padding: 10px 10px 20px 10px;
      border-radius:20px ;
      top: 50%;
      left: 50%;
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



  .login-box button[name="submit"] {
  background:#ADD368;
  border-radius:10px;
  padding:12px;
  color: black;
  font-weight: bold;
  border-color: white;
  }

.login-box button[name="submit"]:hover {
  cursor: pointer;
  background: #B7EF51;
  color: black;
  border-color: white;
  border-radius:10px;
 
}


.login-box button[name="submit"]:after {
  content: '';
  width: 0%;
  height: 2px;
  display: block;
  background: white;
  transition: 0.7s;
}

.login-box button[name="submit"]:hover:after {
    background: black;
    width: 100%;
    text-decoration: underline;
}

.login-box a {
  display: inline-block;
  color: #5F88CA;
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
    font-weight: bold;
  }
  

  #recuperarcontra{
    font-family: 'Roboto'; 
    font-weight: bold;
    background-color: #2C5884;
    color: white; 
    transition: all ease-in-out 1s; 
  }

  #recuperarcontra:hover{
   background-color: #5F88CA;
   border: 2px black solid;
 }


#recuperarcontra:after {
  content: '';
  width: 0px;
  height: 1px;
  display: block;
  background: black;
  transition: 1s;
}

#recuperarcontra:hover:after {
    width: 100%;
    background: white;
    text-decoration: underline;
}

#titulo_h5{
  margin-bottom: 40px;
  font-weight: bold;
  color: #415B6F;  
}
</style>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Pasaje Comercial Mercy</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{ asset('/plugins/fontawesome-free/css/all.min.css')}}">
  <link href="{{ asset('/plugins/ionicons.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/dist/css/adminlte.min.css')}}">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">

</head> 
<body >
<div class="login-box" >
  <img src="{{ asset('/dist/img/LOGO.png')}}" class="avatar">
  <!-- /.login-logo -->
  <div style="padding: 40px">
    <h5 id="titulo_h5">RECUPERAR CONTRASEÑA</h5>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
     <form method="POST" action="{{ route('password.email') }}">
     @csrf
        <div class="input-group mb-3">
          <input type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus> 
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
                                        @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
        </div>
        
        <div class="row">
          <div class="col-md-12" style="display: block !important;margin: 0 !important">
            <button type="submit" class="btn  btn-block" id="recuperarcontra"> Enviar </button>
          
          </div>
          <!-- /.col -->  
        </div>
      </form>
       <div class="col-md-12" ></br>
          <a href="{{asset('/')}}" id="olvidecon">Regresar</a>
      </div>
    </div>
</div>
<!-- jQuery -->
<script src="{{ asset('/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('/dist/js/adminlte.min.js')}}"></script>
<script src="{{asset('/plugins/sweetalert2.js')}}"></script>

</body>
</html>

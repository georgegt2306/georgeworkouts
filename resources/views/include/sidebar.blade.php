<aside class="main-sidebar sidebar-ligth-primary elevation-4" style="background-color: white">
    <!-- Brand Logo -->
    <a href="{{ asset('/home')}}" class="brand-link" >
      <img src="{{ asset('/dist/img/LOGO.png')}}"  width="50" height="40" >
      <span class="brand-text font-weight-dark" style="font-family:'Roboto';color: black;font-weight: bold;">&nbsp George Workouts</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
               Opciones
                <i class="fas fa-angle-left right"></i>
                {{-- <span class="badge badge-danger right">3</span> --}}
              </p>
            </a>
             <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{asset('/formapago')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Forma Pago</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{asset('/cliente')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Clientes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{asset('/producto')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inventario</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{asset('/ventas')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ventas</p>
                </a>
              </li>  
                     
            </ul>
          </li>
         

          

         
          
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
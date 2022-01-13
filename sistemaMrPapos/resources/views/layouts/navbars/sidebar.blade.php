<div class="sidebar" data-color="azulso" data-background-color="bg-dark" >
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="{{ route('home') }}" class="simple-text logo-normal"> 
      {{ __('Mr. Papos') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p class="fontcolorsidebar">{{ __('Principal') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'usuarios' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('usuariosList') }}">
          <i class="material-icons">account_box</i>
            <p class="fontcolorsidebar">{{ __('Usuarios') }}</p>
        </a>
      </li>

      <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
          <i><img style="width:25px" src="{{ asset('img/laravel.svg') }}"></i>
          <p class="fontcolorsidebar">{{ __('Menu Desplegable') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="laravelExample">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="#">
                <span class="sidebar-mini fontcolorsidebar"> OP </span>
                <span class="sidebar-normal fontcolorsidebar">{{ __('Opcion 1') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="#">
                <span class="sidebar-mini fontcolorsidebar"> OP </span>
                <span class="sidebar-normal fontcolorsidebar"> {{ __('Opcion 2') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item{{ $activePage == 'ventas' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('listVentas') }}">
          <i class="material-icons">content_paste</i>
            <p class="fontcolorsidebar">{{ __('Ventas') }}</p>
        </a>
      </li>
      <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#inventarioMenu" aria-expanded="true">
        <i class="material-icons">inventory_2</i>
          <p class="fontcolorsidebar">{{ __('Inventario') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="inventarioMenu">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'productos' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('calzadoList') }}"> 
              <i class="material-icons">grid_view</i>
                <span class="sidebar-normal fontcolorsidebar">{{ __('Productos') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'reabastecer' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('calzadoListReabastecer') }}">
              <i class="material-icons">archive</i>
                <span class="sidebar-normal fontcolorsidebar"> {{ __('Reabastecimiento') }} </span>
              </a>
            </li>

            <li class="nav-item{{ $activePage == 'proveedores' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('obtenerProveedores') }}">
              <i class="material-icons">local_shipping</i>
                <span class="sidebar-normal fontcolorsidebar"> {{ __('Proveedores') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item{{ $activePage == 'formulario' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('listPedidos') }}">
          <i class="material-icons">bubble_chart</i>
          <p class="fontcolorsidebar">{{ __('Pedidos') }}</p>
        </a>
      </li>


     

      <!--li class="nav-item{{ $activePage == 'notifications' ? ' active' : '' }}">
        <a class="nav-link" href="#">
          <i class="material-icons">notifications</i>
          <p>{{ __('Notifications') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
        <a class="nav-link" href="#">
          <i class="material-icons">language</i>
          <p>{{ __('RTL Support') }}</p>
        </a>
      </li-->
    </ul>
  </div>
</div>

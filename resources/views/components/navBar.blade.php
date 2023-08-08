  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item">
        {{-- <button type="button" class="btn btn-sm nav-link text-info">{{ \Auth::user()->balance->balance }} downloads left</button> --}}
      </li>

      <li class="nav-item">
        <!-- Authentication -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm nav-link">
                LogOut
                <i class="ml-1 fas fa-power-off"></i>
            </button>
        </form>
      </li>
{{--      <li class="nav-item">--}}
{{--        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">--}}
{{--          <i class="fas fa-th-large"></i>--}}
{{--        </a>--}}
{{--      </li>--}}
    </ul>

  </nav>
  <!-- /.navbar -->

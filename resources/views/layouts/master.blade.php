@include('components.header')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{$page_info['title']}}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                @foreach ($page_info['breadCrumb'] as $key => $item)
                    <li class="breadcrumb-item @if( array_key_last($page_info['breadCrumb']) == $key ) active @endif">
                        @if( array_key_last($page_info['breadCrumb']) != $key )
                            <a href="#">{{$item}}</a>
                            @else
                            {{$item}}
                        @endif
                    </li>
                @endforeach
              {{-- <li class="breadcrumb-item active">Starter Page</li> --}}
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-12">
                @include('components.flash-message')
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content pb-4">
      <div class="container-fluid">
        @yield('content')
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@include('components.footer')

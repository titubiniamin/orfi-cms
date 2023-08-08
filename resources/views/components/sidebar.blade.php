<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link ml-md-3">
        <img src="{{asset('dist/img/orfi-main.png')}}" alt="Orfi Logo" class="brand-image" style="">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="{{route('dashboard')}}" class="d-block text-capitalize">Hi, {{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-flat" data-widget="treeview" role="menu"
                data-accordion="false">
                {{--             @include('components.sidebar-Button.sidebar-button',['name' => 'Balance','url'=> 'dashboard','icon' => 'fas fa-wallet' ])--}}
                @include('components.sidebar-Button.sidebar-button',['name' => 'Subject','url'=> 'subject','icon' => 'fas fa-university' ])
                @include('components.sidebar-Button.sidebar-button',['name' => 'Tag','url'=> 'tag','icon' => 'fas fa-tag' ])
                @include('components.sidebar-Button.sidebar-button',['name' => 'Book','url'=> 'book','icon' => 'fas fa-book' ])
                @include('components.sidebar-Button.sidebar-button',['name' => 'Annotation','url'=> 'annotation','icon' => 'fas fa-highlighter' ])
                @include('components.sidebar-Button.sidebar-button',['name' => 'Search','url'=> 'screenshot','icon' => 'fas fa-search' ])

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

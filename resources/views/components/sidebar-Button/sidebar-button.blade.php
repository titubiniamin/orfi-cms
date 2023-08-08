<li class="nav-item">
    <a href="{{ route($url.'.index') }}" class="nav-link @if(in_array($url,explode("/", url()->current()))) active @endif">
        <i class="nav-icon {{$icon}}"></i>
        <p>
        {{$name}}
        {{-- <span class="right badge badge-danger">New</span> --}}
        </p>
    </a>
</li>

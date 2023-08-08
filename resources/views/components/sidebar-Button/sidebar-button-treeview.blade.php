
@php
    $existing = explode("/", url()->current());
@endphp
<li class="nav-item has-treeview
    @foreach($existing as $key => $value)
        @if(in_array($value,$link_list)) menu-open @endif
    @endforeach
">
    <a href="#" class="nav-link
    @foreach($existing as $key => $value)
        @if(in_array($value,$link_list)) active @endif
    @endforeach">

        <i class="nav-icon {{ $icon }}"></i>
        <p>
        {{$name}}
        <i class="right fas fa-angle-left"></i>
        </p>

    </a>

    <ul class="nav nav-treeview">
        @foreach ($links as $link)
            @include('partials.sidebar-button.sidebar-button',['name' => $link['name'],'url'=> $link['url'],'icon' => $link['icon'] ])
        @endforeach
    </ul>

</li>

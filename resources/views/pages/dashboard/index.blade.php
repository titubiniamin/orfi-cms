@extends('layouts.master')
@section('content')
    {{-- <ul id="myUL">
        <li>
            <span class="caret">Beverages</span>
            <ul class="nested">
                <li>Water</li>
                <li>Coffee</li>
                <li>
                    <span class="caret">Tea</span>
                    <ul class="nested">
                        <li>Black Tea</li>
                        <li>White Tea</li>
                        <li><span class="caret">Green Tea</span>
                        <ul class="nested">
                            <li>Sencha</li>
                            <li>Gyokuro</li>
                            <li>Matcha</li>
                            <li>Pi Lo Chun</li>
                        </ul>
                        </li>
                    </ul>

                </li>
            </ul>

        </li>
    </ul> --}}

    {{-- <ul id="myUL">
        $list
    </ul> --}}

    {{-- @include('components.tables.table-user',['route_name'=>'allUser']) --}}
@endsection

@push('css')
    <link rel="stylesheet" href="{{asset('/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/treeview/style.css')}}">

@endpush
@push('js')
    <script src="{{asset('plugins/treeview/js.js')}}"></script>
@endpush

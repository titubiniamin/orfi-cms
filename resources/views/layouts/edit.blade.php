@extends('layouts.master')
@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit {{ $page_info['title'] }}</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    @yield('form')
</div>
@endsection

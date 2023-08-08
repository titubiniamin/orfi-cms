@extends('layouts.master')
@section('content')
    @include('components.tables.table-book',['route_name'=>'allBooks'])
@endsection

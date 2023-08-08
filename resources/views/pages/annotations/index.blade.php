@extends('layouts.master')
@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">List of Books</h3>
            <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                    <a class="nav-link active" href="{{route('book.create')}}">+ Add Book</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-footer bg-white">
            <div class="row mailbox-attachments d-flex align-items-stretch clearfix">
                @foreach ($books as $book)
                    <div class="col-md-3 p-1">
                        <span class="mailbox-attachment-icon border border-secondary"><i class="far fa-file-pdf"></i></span>
                        <div class="mailbox-attachment-info border border-secondary">
                            <a href="{{route('annotation.edit',$book->id)}}" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> {{$book->name}}</a>
                            <span class="mailbox-attachment-size clearfix mt-1 ">
                                <span>50% annotated</span>
                                <a href="{{route('annotation.edit',$book->id)}}" class="btn btn-default btn-sm float-right"><i class="fas fas fa-highlighter"></i></a>
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- /.card-footer -->
        <div class="card-footer">

            <div class="card-tools float-right">
                {{ $books->links() }}
            </div>

        </div>
        <!-- /.card-footer -->
    </div>
@endsection


@push('css')
<link rel="stylesheet" href="{{asset('/plugins/fontawesome-free/css/all.min.css')}}">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="{{asset('/dist/css/adminlte.min.css')}}">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@endpush

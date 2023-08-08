@extends('layouts.master')
@section('content')
    {{-- <div class="container-fluid"> --}}
        <div class="row">
        <div class="col-md-3">
            <a href="{{route('annotation.index')}}" class="btn btn-primary btn-block mb-3">Books List</a>

            <div class="card">
            <div class="card-header">
                <h3 class="card-title">Actions</h3>

                <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="fas fa-upload"></i> Publish
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="far fa-file-alt"></i> Drafts
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="fas fa-filter"></i> Junk
                    <span class="badge bg-warning float-right">65 pages</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="far fa-trash-alt"></i> Trash
                    </a>
                </li>
                </ul>
            </div>
            <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tools</h3>

                <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-project-diagram"></i> Diagram</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-question"></i> Question</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-comment-dots"></i> Answer</a>
                </li>
                </ul>
            </div>
            <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        Annotated {{$book->name}}<br>
                    </h3>

                    <div class="card-tools">
                        {{-- <a href="#" class="btn btn-tool prev-page" data-toggle="tooltip" title="Previous"><i class="fas fa-chevron-left"></i></a>
                        <span class="page-info">
                            Page <span id="page-num"></span> of <span id="page-count"></span>
                        </span>
                        <a href="#" class="btn btn-tool next-page" data-toggle="tooltip" title="Next"><i class="fas fa-chevron-right"></i></a> --}}
                        <div class="toolbar">
                            <button class="cursor" type="button" title="Cursor" data-tooltype="cursor">➚</button>
                            <div class="spacer"></div>
                            <button class="rectangle" type="button" title="Rectangle" data-tooltype="area">&nbsp;</button>
                            <button class="highlight" type="button" title="Highlight" data-tooltype="highlight">&nbsp;</button>
                            <div class="spacer"></div>
                            <button class="text" type="button" title="Text Tool" data-tooltype="text"></button>
                            <select class="text-size"></select>
                            <div class="text-color"></div>
                            <div class="spacer"></div>
                            <button class="pen" type="button" title="Pen Tool" data-tooltype="draw">✎</button>
                            <select class="pen-size"></select>
                            <div class="pen-color"></div>
                        </div>
                    </div>

                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                        <div class="mailbox-controls with-border text-center p-0 m-0">
                            <!-- <canvas class="mailbox-read-message" pdf_location="{{asset('storage/'.$book->book)}}" id="pdf-render"> -->
                        <div>
                        {{-- <div class="toolbar">
                            <button class="cursor" type="button" title="Cursor" data-tooltype="cursor">➚</button>
                            <div class="spacer"></div>
                            <button class="rectangle" type="button" title="Rectangle" data-tooltype="area">&nbsp;</button>
                            <button class="highlight" type="button" title="Highlight" data-tooltype="highlight">&nbsp;</button>
                            <div class="spacer"></div>
                            <button class="text" type="button" title="Text Tool" data-tooltype="text"></button>
                            <select class="text-size"></select>
                            <div class="text-color"></div>
                            <div class="spacer"></div>
                            <button class="pen" type="button" title="Pen Tool" data-tooltype="draw">✎</button>
                            <select class="pen-size"></select>
                            <div class="pen-color"></div>

                            <!-- <div class="spacer"></div>

                            <button class="comment" type="button" title="Comment" data-tooltype="point">🗨</button>

                            <div class="spacer"></div>

                            <select class="scale">
                                <option value=".5">50%</option>
                                <option value="1">100%</option>
                                <option value="1.33">133%</option>
                                <option value="1.5">150%</option>
                                <option value="2">200%</option>
                            </select>

                            <a href="javascript://" class="rotate-ccw" title="Rotate Counter Clockwise">⟲</a>
                            <a href="javascript://" class="rotate-cw" title="Rotate Clockwise">⟳</a>

                            <div class="spacer"></div>

                            <a href="javascript://" class="clear" title="Clear">×</a> -->

                        </div> --}}
                        <div id="content-wrapper">
                            <div id="viewer" pdf_location="{{asset('storage/'.$book->book)}}" class="pdfViewer"></div>
                        </div>

                        <!-- /.mailbox-read-message -->
                    </div>
                    <div class="card-footer mt-5">
                        <button type="button" class="btn btn-default"><i class="far fa-trash-alt"></i> Delete</button>
                        <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
                    </div>
                    <!-- /.card-footer -->
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('/shared/toolbar.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('/shared/pdf_viewer.css')}}"/>
<style type="text/css">
    body {
    background-color: #eee;
    font-family: sans-serif;
    margin: 0;
    }

    .pdfViewer .canvasWrapper {
    box-shadow: 0 0 3px #bbb;
    }
    .pdfViewer .page {
    margin-bottom: 10px;
    }

    .annotationLayer {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    }

    #content-wrapper {
    position: relative;
    top: 35px;
    left: 0;
    right: 250px;
    bottom: 0;
    height: 1000px;
    /* max-height: 90vh; */
    overflow: auto;
    }

    #comment-wrapper {
    position: relative;
    top: 35px;
    right: 0;
    bottom: 0;
    overflow: auto;
    width: 250px;
    background: #eaeaea;
    border-left: 1px solid #d0d0d0;
    }
    #comment-wrapper h4 {
    margin: 10px;
    }
    #comment-wrapper .comment-list {
    font-size: 12px;
    position: absolute;
    top: 38px;
    left: 0;
    right: 0;
    bottom: 0;
    }
    #comment-wrapper .comment-list-item {
    border-bottom: 1px solid #d0d0d0;
    padding: 10px;
    }
    #comment-wrapper .comment-list-container {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 47px;
    overflow: auto;
    }
    #comment-wrapper .comment-list-form {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    padding: 10px;
    }
    #comment-wrapper .comment-list-form input {
    padding: 5px;
    width: 100%;
    }
    .pdfViewer .page {
    border-image: none;
    }
</style>
<link rel="stylesheet" href="{{asset('/plugins/fontawesome-free/css/all.min.css')}}">
<link rel="stylesheet" href="{{asset('/plugins/pdf/css/main.css')}}">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="{{asset('/dist/css/adminlte.min.css')}}">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@endpush

@push('js')
<script src="{{asset('/shared/pdf.js')}}"></script>
<script src="{{asset('/shared/pdf_viewer.js')}}"></script>
{{-- <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script> --}}
{{-- <script src="{{asset('/plugins/pdf/js/pdfAnnotate.js')}}"></script> --}}
{{-- <script src="{{asset('/plugins/pdf/js/pdf_viewer.js.map')}}"></script> --}}
{{-- <script src="{{asset('/plugins/pdf/js/pdf_viewer.js')}}"></script> --}}
{{-- <script src="{{asset('/plugins/pdf/js/main.js')}}"></script> --}}
{{-- <script src="{{asset('pdf.js/node_modules/pdfjs-dist/web/pdf_viewer.js')}}"></script> --}}
{{-- <script src="{{asset('/plugins/pdf/js/annotation.js')}}"></script> --}}
@endpush

@extends('layouts.annotation')
@section('toolbar')

    <div class="top-bar">

        <button class="btn" id="prev-page">
        <i class="fas fa-arrow-circle-left"></i> Prev Page
        </button>
        <span class="page-info">
            <span id="page-num"></span> of <span id="page-count"></span>
        </span>
        <button class="btn" id="next-page">
        Next Page <i class="fas fa-arrow-circle-right"></i>
        </button>
        <form action="" id="page_search" style="">
            <input type="number" name="pageNum"/>
            <button type="submit">go to page</button>
        </form>
    </div>

@endsection

@section('annotationsbar')

{{-- <a id="line" data-action-name="line" type="button" class="action-button ml-0 btn"><i class="fas fa-edit"></i> Line </a> --}}
    {{-- <div class="btn-group d-flex justify-content-around">
        <a id="rect" data-action-name="rect" type="button" class="action-button btn"><i class="far fa-square"></i> </a>
    </div>
    <div id="images"></div> --}}

@endsection

@section('pdf')
    <canvas id="pdf-render" data-book-id={{$book->id}} data-page-number="" style="width: 100%;"></canvas>
@endsection

@push('css')
    <link rel="stylesheet" href="{{asset('/plugins/annotations/css/main.js')}}" />
@endpush

@push('js')

    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
    <script src="{{asset('/plugins/annotations/js/pdfv1.js?v=13')}}"></script>
    <script src="{{asset('plugins/annotations/js/crud1.js?v=12')}}"></script>
    <script src="{{asset('plugins/annotations/js/main.js?v=15')}}"></script>

@endpush

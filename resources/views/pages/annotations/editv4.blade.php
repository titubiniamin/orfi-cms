@extends('layouts.annotation')
@php
    $images = [
        'img/mrcarsonsanford-page-0.png',
        'img/mrcarsonsanford-page-1.png',
    ]
@endphp
@section('toolbar')
    <a class="prev" onclick="plusSlides(-1)">❮</a>
    <a class="next" onclick="plusSlides(1)">❯</a>
@endsection

@section('annotationsbar')

    <div class="btn-group d-flex justify-content-around">
        <a id="line" type="button" class="ml-0 btn"><i class="fas fa-edit"></i> Line </a>
        <a id="rect" type="button" class="btn"><i class="far fa-square"></i> Rect </a>
    </div>

@endsection

@section('pdf')

<div class="">
    @foreach ($images as $key => $image)
        @include('components.annotations.image',[
            'src' => asset($image),
            'id'  => strtolower(str_replace([" ","."], "", $book->name)).'-'. strtolower(str_replace([" ","."], "", $book->subject->name)).'-'.$key
        ])
    @endforeach

  {{-- <div class="row">
    <div class="column">
      <img class="demo cursor" src="{{asset('img/img_woods.jpg')}}" style="width:100%" onclick="currentSlide(1)" alt="The Woods">
    </div>
    <div class="column">
      <img class="demo cursor" src="{{asset('img/img_5terre.jpg')}}" style="width:100%" onclick="currentSlide(2)" alt="Cinque Terre">
    </div>
    <div class="column">
      <img class="demo cursor" src="{{asset('img/img_mountains.jpg')}}" style="width:100%" onclick="currentSlide(3)" alt="Mountains and fjords">
    </div>
    <div class="column">
      <img class="demo cursor" src="{{asset('img/img_lights.jpg')}}" style="width:100%" onclick="currentSlide(4)" alt="Northern Lights">
    </div>
    <div class="column">
      <img class="demo cursor" src="{{asset('img/img_nature.jpg')}}" style="width:100%" onclick="currentSlide(5)" alt="Nature and sunrise">
    </div>
    <div class="column">
      <img class="demo cursor" src="{{asset('img/img_snow.jpg')}}" style="width:100%" onclick="currentSlide(6)" alt="Snowy Mountains">
    </div>
  </div> --}}

</div>

@endsection

@push('css')
    <link rel="stylesheet" href="{{asset('/plugins/slider/css/main.css')}}" />
    <script>
        function loadImageOnCanvas(id) {

            var imageID = 'image-'+id,
                canvasID = 'canvas-'+id,
                img = document.getElementById(imageID),
                canvas = document.getElementById(canvasID);

            canvas.height = img.height;
            canvas.width = img.width;

            var ctx = canvas.getContext("2d");
            ctx.drawImage(img, 0, 0);

        }
    </script>
@endpush

@push('js')
    <script src="{{asset('/plugins/slider/js/main.js')}}"></script>
    <script src="{{asset('/plugins/canvas/main.js')}}"></script>
@endpush

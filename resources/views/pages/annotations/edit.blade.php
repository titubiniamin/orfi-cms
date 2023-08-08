@extends('layouts.annotation')
@section('toolbar')
    <a class="prev" onclick="plusSlides(-1)">❮</a>
    <a class="next" onclick="plusSlides(1)">❯</a>
@endsection
@section('annotationsbar')

    <div class="btn-group d-flex justify-content-around">
        <a id="line" data-action-name="line" type="button" class="action-button ml-0 btn"><i class="fas fa-edit"></i> Line </a>
        <a id="rect" data-action-name="rect" type="button" class="action-button btn"><i class="far fa-square"></i> Rect </a>
    </div>

@endsection
@section('pdf')

    @foreach ($book->screenshots as $key => $screenshot)
        <div class="mySlides">
            <img src={{asset('storage/'.$screenshot->screen_shot_location)}} id="canvas_{{str_replace([" ",'.'],"",$book->name)}}_{{str_replace([" ",'.'],"",$book->subject->name)}}_image_{{$key}}" style="display: none">
            <canvas
                class="canvas"
                id="canvas_{{ str_replace([" ",'.'],"",$book->name)}}_{{ str_replace([" ",'.'],"",$book->subject->name) }}_{{$key}}"
                data-book="{{$book->name}}"
                data-book-id="{{$book->id}}"
                data-page-id="{{$screenshot->id}}"
                data-subject="{{$book->subject->name}}"
                data-key="{{$key}}"
                data-image-src="{{ asset('storage/'.$screenshot->screen_shot_location)}}"
                data-image-id="canvas_{{str_replace([" ",'.'],"",$book->name)}}_{{str_replace([" ",'.'],"",$book->subject->name)}}_image_{{$key}}"
            ></canvas>

        </div>
    @endforeach

@endsection

@push('js')
<script src="{{ asset('/plugins/canvas/crud.js') }}"></script>
<script src="{{ asset('/plugins/canvas/rect.js') }}"></script>
<script src="{{asset('/plugins/slider/js/main.js')}}"></script>
@endpush

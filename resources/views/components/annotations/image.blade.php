<div class="mySlides">
    <img src={{asset($src)}} id="image-{{$id}}" style="display:none">
    <canvas id="canvas-{{$id}}" style=""></canvas>
    <script>
        var id = "{{ "$id" }}";
        loadImageOnCanvas(id)
    </script>
</div>

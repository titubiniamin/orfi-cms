<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        div, body, svg {
            margin: 0;
            display: inline-block;
        }
    </style>
</head>
<body>

    <div id="svg">
        <svg width="150" height="150" xmlns="http://www.w3.org/2000/svg">
          <g fill="none" stroke-width="2.2" transform="translate(75,75)">
          <circle r="10" stroke="hsl(10,75%,75%)"/>
          <circle r="15" stroke="hsl(10,75%,75%)"/>
          <circle r="20" stroke="hsl(40,75%,75%)"/>
          <circle r="25" stroke="hsl(70,75%,75%)"/>
          <circle r="30" stroke="hsl(100,75%,75%)"/>
          <circle r="35" stroke="hsl(130,75%,75%)"/>
          <circle r="40" stroke="hsl(160,75%,75%)"/>
          <circle r="45" stroke="hsl(190,75%,75%)"/>
          </g>
        </svg>
    </div>

    <div>
        <button>>></button>
    </div>

    <canvas width="150" height="150" id="copy"></canvas>
    <img id="img" src="" alt="" srcset="">

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

    function senddata(base64code) {
        // console.log(base64code);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:'/ss/take',
            type: 'POST',  // http method
            data: { base64code: base64code },  // data to submit
            success: function (data, status, xhr) { // after success your get data
                console.log(data);
                // $('p').append('status: ' + status + ', data: ' + data);
            },
            // error: function (jqXhr, textStatus, errorMessage) { // if any error come then
            //         $('p').append('Error' + errorMessage);
            // }
        });
    }

    document.querySelector('button').onclick = function () {
        var data = document.querySelector('div#svg').innerHTML;
        var img = new Image();
        img.src = 'data:image/svg+xml;base64,' + btoa(data);
        img.onload = function() {
            let canvas = document.querySelector('canvas#copy');
            canvas.getContext('2d').drawImage(img, 0, 0);
            var image = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");  // here is the most important part because if you dont replace you will get a DOM 18 exception.
            let imagePreview = document.getElementById('img');
            imagePreview.setAttribute('src',canvas.toDataURL());
            // console.log(canvas.toDataURL("image/png"));
            senddata(canvas.toDataURL("image/png"));
            // console.log(canvas.toDataURL().replace("image/png", "image/octet-stream"));
            // // window.location.href=image; // it will save locally
            // // window.open(
            // //     canvas.toDataURL("image/png").replace("image/png", "image/octet-stream")
            // // )
        }

    }


</script>
</html>

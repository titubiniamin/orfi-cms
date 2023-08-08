@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">{{$page_info['title']}}</h3>

      <div class="card-tools">
        <ul class="nav nav-pills ml-auto">
          <li class="nav-item">
            <a class="nav-link active" href="{{route($page_info['route'].'.index')}}">Search</a>
          </li>
        </ul>
      </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <form enctype="multipart/form-data" id="form" method="POST" action="{{route('screenshot.store')}}" >
            @method('Post')
            @csrf
            <div class="custom-file">
                <input type="file" class="custom-file-input input-image" name="image" id="customFile" accept="image/*" onchange="loadFile(event)">
                <label class="custom-file-label" for="customFile">Choose Image</label>
            </div>

            <div class="row mb-1 mt-3">
                <div class="col-4">
                    <div class="img_preview">
                        <img style="width:100%;hight:100%" id="output"/>
                    </div>
                </div>
                <div class="col-8" id="text">

                </div>
            </div>

            <input type="submit" class="mt-1 btn btn-secondary">

        </form>
    </div>
    <!-- /.card-body -->
</div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <style>
        .loader {
          border: 16px solid #f3f3f3;
          border-radius: 50%;
          border-top: 16px solid #3498db;
          width: 120px;
          height: 120px;
          -webkit-animation: spin 2s linear infinite; /* Safari */
          animation: spin 2s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
          0% { -webkit-transform: rotate(0deg); }
          100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
        }
        .custom-file-input {
            position: relative;
            z-index: 2;
            width: 32%;
            height: calc(18.5em + .75rem + 2px);
            margin: 0;
            opacity: 0;
        }
        .img_preview {
            height: 250px;
            width: 100%;
            border: 1px dashed gray;
        }

        .search_result_img_preview {
            height: 250px;
            width: 100%;
            border: 1px dashed gray;
        }
        .search{
            width: 100%;
        }
        .loader_gif {
            height: 240px;
        }
        #text {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
@endpush
@push('js')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <script>

        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src)
            }

            $("#text").html(`<img class="loader_gif" src="http://orfi-google-vision.test/storage/storage/loader.gif" alt="" srcset="">`)

            var formData = new FormData();
            formData.append('image', $('#customFile')[0].files[0]);
            formData.append('_method', $("input[name=_method]").val());

            $.ajax({
                url: 'api/screenshot/get/text',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (result) {
                    $("#text").html(
                        ' <textarea name="text" id="" cols="100" rows="10">'+ result.text +'</textarea>'
                    )
                },
                cache : false,
                processData: false
            });

        };



    </script>
@endpush





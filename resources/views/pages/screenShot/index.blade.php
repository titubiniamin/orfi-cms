@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{$page_info['title']}}</h3>

            <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                    <!--<a class="nav-link active" href="{{route($page_info['route'].'.create')}}">Entry Image</a>-->
                    </li>
                </ul>
            </div>

        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-mb-10 offset-1">
                    <form id="search_form">
                        <div class="form-group">
                            <label for="search">Search : </label>
                            <input
                                type="text"
                                class="form-control"
                                id="search"
                                aria-describedby="search_box_description"
                                placeholder="Enter question..."
                                name="search_query"
                            >
                            <small id="search_box_description" class="form-text text-muted">We'll provide you with the
                                answer we have..</small>
                        </div>
                        <input type="submit" class="btn btn-secondary" name="search" value="Search">

                    </form>
                </div>
                <div class="col-md-10 ml-5 pl-4">
                    <div class="row ml-5" id="img_preview">

                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
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
            0% {
                -webkit-transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        #img_preview {
            min-height: 250px;
            width: 100%;
            height: auto;
        }

        .search {
            width: 100%;
        }

        .loader_gif {
            height: 240px;
        }

        /*#img_preview {*/
        /*    display: flex;*/
        /*    justify-content: center;*/
        /*    align-items: center;*/
        /*}*/
    </style>
@endpush
@push('js')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <script>
        $('#search_form').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData();
            formData.append('search_query', $("input[name=search_query]").val());
            formData.append('_method', "POST");
            formData.append('_token', @json(csrf_token()));
            $("#img_preview").html(`<img class="loader_gif" src="{{ asset('lodding.gif') }}" alt="" srcset="">`)
            $.ajax({
                url: '/search-text-answer',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (result) {
                    answers = result.result.hits.hits;
                    image = '';
                    let imageBasePath = '{{ env('AWS_CLOUD_FRONT_URL')}}';
                    answers.map((answer) => {
                        image = image + `
                        <div class="col-md-9 mt-3">
                            <h5>Question</h5>
                            <h6 class="text-muted">What did he make the hut with?</h6>
                            <h5 class="mt-3">Answer</h5>
                            <h6 class="text-muted">
                                ${answer._source.answer}
                            </h6>
                            <img style="width:100%" src="${imageBasePath + answer._source.answer_image}"/>
                        </div>
                        `
                    })
                    $("#img_preview").html(image)
                },
                cache: false,
                processData: false
            });

        })


    </script>


@endpush

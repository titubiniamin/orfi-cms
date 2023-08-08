<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Document</title>
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

        #img_preview {
            height: 250px;
            width: 100%;
        }

        .search{
            width: 100%;
        }
        .loader_gif {
            height: 240px;
        }
        #img_preview {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container mt-5">

        <div class="row">
            <div class="col-mb-10 offset-1">
                <form id="search_form">
                    <div class="form-group">
                        <label for="search">Search :</label>
                        <input
                                type="text"
                                class="form-control"
                                id="search"
                                aria-describedby="search_box_description"
                                placeholder="Enter question..."
                                name="search_qerry"
                        >
                        <small id="search_box_description" class="form-text text-muted">We'll provide you with the answer we have..</small>
                    </div>
                    <input type="submit" class="btn btn-secondary" name="search" value="search">
                    <a type="button" href="{{route('screenshot.index')}}" class="btn btn-secondary"> Entry image </a>

                </form>
            </div>
            <div class="col-md-10 offset-1">
                <div class="row" id="img_preview">

                </div>
            </div>
        </div>

    </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<script>
    $('#search_form').on('submit',function(e){
        e.preventDefault();
        var formData = new FormData();
        formData.append('search_qerry', $("input[name=search_qerry]").val());
        formData.append('_method', "POST");
        $("#img_preview").html(`<img class="loader_gif" src="http://orfi-google-vision.test/storage/storage/loader.gif" alt="" srcset="">`)
        $.ajax({
            url: 'api/search-text-answer',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (result) {
                answers = result.result.hits.hits;
                image = '';
                answers.map((answer)=>{
                    image = image+`
                    <div class="col-md-6">
                        <img style="width:100%;" src="${"http://"+window.location.host+'/storage/'+answer._source.image}"/>
                    </div>
                    `
                })
                $("#img_preview").html(image)

            },
            cache : false,
            processData: false
        });

    })


</script>

</html>

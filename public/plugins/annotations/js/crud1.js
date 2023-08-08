var loading = $(`<img id="loader" src='${window.location.origin}/lodding.gif' style="margin-left: 150px;" width="100px">`);
function store(data) {
    // console.log('hello' + data);
    // $('#questions_list').append(loading);
    $("#loading-massage").modal('show');
    $.ajax({
        type: "POST",
        url: window.location.origin+'/annotation',
        data: data,
        success: function (response) {
            // console.log(response);
            $("#loading-massage").modal('hide');
            toastr.success('annotated successfully')
            editPreviewText(response.annotation.id)

            renderAnnotation()
            renderList()
            annotation.annotation = null

        },
        statusCode: {
            500: function(xhr) {

                $("#loading-massage").modal('hide');
                toastr.warning('sorry somthing want wrong')
                renderAnnotation()
                renderList()
                annotation.annotation = null

            }
        }
    });
}

function editPreviewText(annotationId) {

    $.ajax({
        type: "GET",
        url: window.location.origin+'/edit/annotation/text/'+annotationId,
        success: function (response) {

            // $("#show-annotation-text").summernote("code", response.text);
            resetAnnotationVariable()
            document.getElementById("show-annotation-text").value  = response.text;
            $("#annotationID").val(response.annotation.id);
            if(sidebarOpen){
                toggleSideBar(null)
            }
            $("#edit-annotation-preview").modal('show');

        },
        statusCode: {
            500: function(xhr) {
                toastr.warning('sorry somthing want wrong')
            }
        }
    });
}

$("#edit-annotation-preview").on('submit',(e)=>{
    e.preventDefault();
    data = extractValue(e.target);

    $.ajax({
        type: "POST",
        url: window.location.origin+'/update/annotation/text/'+data.annotationID,
        data: data,
        success: function (response) {
            toastr.success('annotatation text updated successfully')
            $("#edit-annotation-preview").modal('hide');
        },
        statusCode: {
            500: function(xhr) {
                toastr.warning('sorry somthing want wrong,please try again.')
            }
        }
    });

})

function extractValue(form) {
    array = $(form).serializeArray();
    data = [];
    array.map( (v,i) =>{
        key = v.name
        value = v.value

        data.map((v,i) => {
            if( v[0] == key ){
                if(Array.isArray(v[1])){
                    newArray = v[1].concat(value)
                    value = newArray.filter((v, i, a) => a.indexOf(v) === i)
                }else{
                    value = [v[1],value]
                }
            }
        })

        data.push([key,value])
    })

    return Object.fromEntries(data);
}

function updatePreviewText(annotationId) {

    $.ajax({
        type: "GET",
        url: window.location.origin+'/edit/annotation/text/'+annotationId,
        success: function (response) {

            // console.log(response.text,$("#show-annotation-text"));
            // $("#show-annotation-text").summernote("code", response.text);
            document.getElementById("show-annotation-text").value  = response.text;
            $("#edit-annotation-preview").modal('show');

        },
        statusCode: {
            500: function(xhr) {
                toastr.warning('sorry somthing want wrong')
            }
        }
    });


}


function update(data) {
    // $('#questions_list').append(loading);
    // console.log(data.annotation_id);
    // url = ;
    console.log('hello from update ',window.location.origin+'/annotation/'+data.annotation_id);

    $("#loading-massage").modal('show');
    $.ajax({
        type: "PUT",
        url: window.location.origin+'/annotation/'+data.annotation_id,
        data: data,
        success: function (response) {
            // console.log(response);
            // $("#loader").remove()
            // renderQuestions(response.book.id)
            $("#loading-massage").modal('hide');

            // updatePreviewText(data.annotation_id)
            // renderAnnotation()
            // console.log('dadasdas');
            editPreviewText(data.annotation_id)

            toastr.success('annotated successfully')
            renderAnnotation()
            renderList()
            annotation.annotation = null
        },
        statusCode: {
            500: function(xhr) {
                //   if(window.console) console.log(xhr.responseText);
                // console.log(xhr);
                // $("#loader").remove()
                // renderQuestions(data.bookID)
                $("#loading-massage").modal('hide');
                toastr.success('annotated successfully')
                renderAnnotation()
                renderList()
                annotation.annotation = null
            }
        }
    });
}


// function renderQuestions(book) {
//     var questionCards = '';
//     var questions = [];
//     $('#questions_list').append(loading)
//     $.ajax({
//         type: "GET",
//         url: window.location.origin+`/${book}/get/all/QnA`,
//         success: function (response) {

//             questions = response.questions
//             questions.map((question)=>{
//                 // console.log(question.text.original.text);
//                 questionCards +=
//                 `<li class="nav-item">
//                     <div class="card collapsed-card m-0 p-0">

//                         <div class="card-header">
//                             <h3 class="card-title">${question.text != null ? question.text : `no text found` }</h3>
//                             <div class="card-tools">

//                                 <button type="button" onclick="setAnnotationType('answer',${question.id})" class="btn btn-tool annotation-type-button" data-type="answer"  data-question-id="${question.id}" >
//                                     <i data-type="answer" data-question-id="${question.id}" data-question-id="1" class="fas fa-comment-dots"></i>
//                                 </button>

//                                 <button type="button" onclick="setAnnotationType('diagram',${question.id})" class="btn btn-tool annotation-type-button" data-type="diagram" data-question-id="${question.id}" >
//                                     <i data-type="diagram" data-question-id="${question.id}" data-question-id="1" class="fas fa-project-diagram"></i>
//                                 </button>

//                                 <button type="button" onclick="deleteAnnotation(${question.annotationID})" class="btn btn-tool annotation-type-button" data-type="diagram" data-question-id="${question.id}" >
//                                     <i data-type="diagram" data-question-id="1" class="fas fa-trash"></i>
//                                 </button>

//                                 <button type="button" class="btn btn-tool" data-card-widget="collapse">
//                                     <i class="fas fa-plus"></i>
//                                 </button>

//                             </div>
//                         </div>

//                         <div class="card-body p-3 ">
//                             <div class="row">
//                                 <div class="col-md-12">
//                                     <img src='${question.image}' style="width: initial;max-width: 100%;">
//                                 </div>
//                                 <div class="col-md-12">
//                                     <textarea class="form-control" rows="5">${question.text != null ? question.text : `no text found` }</textarea>
//                                 </div>
//                             </div>

//                             <ul class="nav nav-pills flex-column">
//                                 ${answerCards(question.answers)}
//                             </ul>
//                         </div>

//                     </div>
//                 </li>
//                 `
//             })

//             $("#questions_list").html(questionCards);
//             // var annotation_type_button = $(".annotation-type-button");
//             // annotation_type_button.map( (i,v)=>{
//             //     v.addEventListener('click', handleCrud, false);
//             // })
//         }

//     });

// }

function answerCards(answers) {
    var cards = '';

    answers.map((answer)=>{
        cards += `<li class="nav-item">
                    <div class="card collapsed-card m-0 p-0 ">

                        <div class="card-header">
                            <h3 class="card-title">${answer.type}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" ><i data-type="answer" data-question-id="1" class="fas fa-${answer.iconname}"></i> </button>
                                <button type="button" onclick="deleteAnnotation(${answer.annotationID})" class="btn btn-tool annotation-type-button" data-type="diagram"><i data-type="diagram" data-question-id="1" class="fas fa-trash"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src='${answer.image}' style="width: initial;max-width: 100%;">
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control" rows="3">${answer.text}</textarea>
                                </div>
                            </div>

                        </div>

                    </div>
                </li>
                `
    })

    return cards;
}

function deleteAnnotation(annotation) {
    $.ajax({
        type: "DELETE",
        url: window.location.origin+`/annotation/${annotation}`,
        success: function (response) {
            // renderQuestions(response.book.id)
            console.log('deleting....');
            renderAnnotation()
            renderList()
            annotation = {
                type : 'question',
                questionID: null
            };
        }
    });
}

function renderAnnotation() {

    var bookid = document.getElementById('pdf-render').getAttribute('data-book-id');
    var pagenumber = document.getElementById('pdf-render').getAttribute('data-page-number');
    // var image = document.getElementById(presentCanvas.getAttribute('data-image-src'));

    $.ajax({
        type: "GET",
        url: window.location.origin+`/bookscreenshot/annotation/${bookid}/${pagenumber}`,
        success: function (response) {

            // console.log('renderring...');
            var ctx = canvas.getContext("2d");
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(latestImageObject, 0, 0);

            response.annotations.map((annotation)=>{
                ctx.beginPath();
                ctx.setLineDash([20, 5]);
                ctx.strokeStyle = annotation.type == 'question' ? 'red' : annotation.type == 'answer' ? 'green' : 'blue';

                ctx.rect(annotation.x_coordinate,annotation.y_coordinate,annotation.width,annotation.height);
                ctx.stroke();
            })

            // console.log(response);
        }
    });

}



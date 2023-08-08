
function store(data) {
    var loading = $(`<img id="loader" src='http://orfi.test/lodding.gif' style="margin-left: 150px;" width="100px">`);
    $('#questions_list').append(loading)
    // console.log(data);
    $.ajax({
        type: "POST",
        url: window.location.origin+'/annotation',
        data: data,
        success: function (response) {
            $("#loader").remove()
            renderQuestions(response.book.id)
            renderAnnotation()
        }
    });
}


function renderQuestions(book) {
    var questionCards = '';
    var questions = [];
    $.ajax({
        type: "GET",
        url: window.location.origin+`/${book}/get/all/QnA`,
        success: function (response) {

            questions = response.questions
            questions.map((question)=>{
                // console.log(question.text.original.text);
                questionCards +=
                `<li class="nav-item">
                    <div class="card collapsed-card m-0 p-0">

                        <div class="card-header">
                            <h3 class="card-title">question</h3>
                            <div class="card-tools">
                                <button type="button" onclick="setAnnotationType('answer',${question.id})" class="btn btn-tool annotation-type-button" data-type="answer"  data-question-id="${question.id}" ><i data-type="answer" data-question-id="1" class="fas fa-comment-dots"></i> </button>
                                <button type="button" onclick="setAnnotationType('diagram',${question.id})" class="btn btn-tool annotation-type-button" data-type="diagram" data-question-id="${question.id}" ><i data-type="diagram" data-question-id="1" class="fas fa-project-diagram"></i></button>
                                <button type="button" onclick="deleteAnnotation(${question.annotationID})" class="btn btn-tool annotation-type-button" data-type="diagram" data-question-id="${question.id}" ><i data-type="diagram" data-question-id="1" class="fas fa-trash"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>

                        <div class="card-body p-3 ">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src='${question.image}' class="" height="150" width="200">
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control" rows="12">${question.text}</textarea>
                                </div>
                            </div>

                            <ul class="nav nav-pills flex-column">
                                ${answerCards(question.answers)}
                            </ul>
                        </div>

                    </div>
                </li>
                `
            })

            $("#questions_list").html(questionCards);

        }

    });

}

function answerCards(answers) {
    var cards = '';

    answers.map((answer)=>{
        cards += `<li class="nav-item">
                    <div class="card collapsed-card m-0 p-0">

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
                                    <img src='${answer.image}' class="" height="150" width="200">
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
            renderQuestions(response.book.id)
            console.log('deleted');
            renderAnnotation()
        }
    });
}

function renderAnnotation() {
    console.log('rendering...');
    var bookscreenshot = presentCanvas.getAttribute('data-page-id');
    var image = document.getElementById(presentCanvas.getAttribute('data-image-src'));

    $.ajax({
        type: "GET",
        url: window.location.origin+`/bookscreenshot/annotation/${bookscreenshot}`,
        success: function (response) {
            var ctx = presentCanvas.getContext("2d");
            ctx.clearRect(0, 0, imageObj.width, imageObj.height);
            ctx.drawImage(imageObj, 0, 0);

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



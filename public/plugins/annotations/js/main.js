var imageObj;
var annotation_id = null;
var annotation = {
    type : null,
    questionID: null,
    groupID:null,
    annotation: null,
    buttonType : null
};

var mouse = {
    position:{
        present:{
            x:0,
            y:0
        },
        start:{
            x:0,
            y:0
        },
        end:{
            x:0,
            y:0
        },
    },
    event:{
        mousedown:false,
        mouseup:false,
        mousemove:false
    }
}

var rect = {
    x: 0,
    y: 0,
    width: 0,
    height: 0,
}

var action = null;

function setAnnotationsID(e) {
    annotation_id = e.getAttribute('data-annotation-id');
}

function resetAnnotationVariable() {
    annotation_id = null
    annotation = {
        type : null,
        questionID: null,
        groupID:null,
        annotation: null,
        buttonType : null
    };

    mouse = {
        position:{
            present:{
                x:0,
                y:0
            },
            start:{
                x:0,
                y:0
            },
            end:{
                x:0,
                y:0
            },
        },
        event:{
            mousedown:false,
            mouseup:false,
            mousemove:false
        }
    }

    rect = {
        x: 0,
        y: 0,
        width: 0,
        height: 0,
    }

   action = null;
}

function setmouse(data) {
    if(annotation.type != null){
        mouse = {
            position:{
                present:{
                    x:data.position.present.x,
                    y:data.position.present.y
                },
                start:{
                    x:data.position.start.x,
                    y:data.position.start.y
                },
                end:{
                    x:data.position.end.x,
                    y:data.position.end.y
                },
            },
            event:{
                mousedown:data.event.mousedown,
                mouseup:data.event.mouseup,
                mousemove:data.event.mousemove
            }
        }
        // console.log(mouse);
    }

}

function movePoint(e) {
    var canvas = e.target
    ctx = canvas.getContext('2d');
    var {x,y} = getCoordinates(e);
    ctx.moveTo(x,y);
}

function drow(e) {

    switch(action) {
        case 'line':
            presentCanvas.style.cursor = `url('${window.location.origin}/dist/img/pen.png') 0 0, pointer`;
            drowLine(e)
          break;
        case 'rect':
            // console.log(e);
            e.target.style.cursor = "crosshair";
            drowRect(e)
          break;
        case 'crop':
            crop(e)
          break;
        default:
          return
    }

}

function getCoordinates(e) {

    var canvas = e.target
    var rect = canvas.getBoundingClientRect();
    return {
        x: e.clientX - rect.left,
        y: e.clientY - rect.top
    };

}
// loadImageToCanvas(canvas)
function loadImageToCanvas(canvas) {

    // imageObj = new Image();
    // imageObj.onload = function () {

    //     canvas.height = this.height;
    //     canvas.width =  this.width;

    //     var ctx = canvas.getContext('2d');
    //     ctx.drawImage(imageObj, 0, 0);

    // };

    // imageObj.src = canvas.getAttribute('data-image-src');
    // canvas.style.cursor = "crosshair";
    // renderAnnotation()

    canvas.addEventListener('mousedown', mouseDown, false);
    canvas.addEventListener('mouseup', mouseUp, false);
    canvas.addEventListener('mousemove', mouseMove, false);

}

function mouseDown(e) {
    // movePoint(e)
    setmouse({
        position:{
            present:{
                x:getCoordinates(e).x,
                y:getCoordinates(e).y
            },
            start:{
                x:getCoordinates(e).x,
                y:getCoordinates(e).y
            },
            end:{
                x:mouse.position.end.x,
                y:mouse.position.end.y
            },
        },
        event:{
            mousedown:true,
            mouseup:false,
            mousemove:mouse.event.mousemove
        }
    })

}

function mouseUp(e) {
    // movePoint(e)
    setmouse({
        position:{
            present:{
                x:getCoordinates(e).x,
                y:getCoordinates(e).y
            },
            start:{
                x:getCoordinates(e).x,
                y:getCoordinates(e).y
            },
            end:{
                x:getCoordinates(e).x,
                y:getCoordinates(e).y
            },
        },
        event:{
            mousedown:false,
            mouseup:true,
            mousemove:false
        }
    })

}

function mouseMove(e) {

    setmouse({
        position:{
            present:{
                x:getCoordinates(e).x,
                y:getCoordinates(e).y
            },
            start:{
                x:mouse.position.start.x,
                y:mouse.position.start.y
            },
            end:{
                x:mouse.position.end.x,
                y:mouse.position.end.y
            },
        },
        event:{
            mousedown:mouse.event.mousedown,
            mouseup:false,
            mousemove:true
        }
    })

    drow(e)

}

function crop(){

    // console.log(ract);
    let {x,y,width,height} = ract;

    if(action == 'rect'){

        let image = latestImageObject;
        // let previewImage = document.getElementById('preview_crop_image')
        // let preview = document.getElementById("crop_preview");
        let preview = document.createElement("canvas");

        preview.width = width*2;
        preview.height = height*2;

        let preview_ctx = preview.getContext("2d");
        preview_ctx.drawImage(image, x*2, y*2, width*2, height*2, 0, 0, width*2, height*2);

        // previewImage.setAttribute("height", '400px');
        // previewImage.setAttribute("width",'100%' );
        // previewImage.setAttribute("src", preview.toDataURL('image/jpeg', 1.0));

        // console.log(preview.toDataURL('image/jpeg', 1.0))

        var annotationData = {
            type: annotation.type,
            bookID:document.getElementById('pdf-render').getAttribute('data-book-id'),
            questionID: annotation.questionID,
            groupID: annotation.groupID,
            pageNumber: pageNum,
            pagebase64:latestImageObject.getAttribute('src'),
            imagebase64: preview.toDataURL('image/jpeg', 1.0),
            CoordinateX: x*2,
            CoordinateY: y*2,
            height: height*2,
            width: width*2,
        }
        // console.log();


        if(annotation.buttonType == 'edit'){
            annotationData.annotation_id = annotation.annotation;
            // console.log(annotationData);
            update(annotationData);
            annotation.buttonType = null;
        }else{
            store(annotationData);
            annotation.annotation = null;
        }

    }

}

function drowRect(e) {

    if (mouse.event.mousedown) {
        // console.log('hi')
        var canvas = e.target,
        ctx = canvas.getContext('2d');
        // latestImageObject = canvas.toDataURL('image/jpeg', 1.0),
        // imgData = ctx.getImageData(0, 0, canvas.width, canvas.height)

        // console.log(latestImageObject);


        // console.log(imgdata);
        // console.log(imgData,canvas,canvas.height);
        // renderPage(1)
        // console.log(latestImageObject);
        // newImageObj = new Image();
        // newImageObj.onload = function () {
        //     ctx.drawImage(newImageObj, 0, 0);
        // };

        // newImageObj.src = latestImageObject;

        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(latestImageObject, 0, 0);
        // ctx.putImageData(latestImageObject,0,0);
        // renderPage(1);

        rect.w = getCoordinates(e).x - mouse.position.start.x;
        rect.h = getCoordinates(e).y - mouse.position.start.y;

        ctx.setLineDash([20, 5]);
        // ctx.strokeStyle = 'rgb(63, 191, 191)';
        ctx.strokeStyle = annotation.type == 'question' ? 'red' : annotation.type == 'answer' ? 'green' : 'blue';

        ctx.strokeRect(mouse.position.start.x*2, mouse.position.start.y*2, rect.w*2, rect.h*2);
        ract = {
            x: mouse.position.start.x,
            y: mouse.position.start.y,
            width: rect.w,
            height: rect.h,
        }
    }

}

function drowLine(e) {

    if(!mouse.event.mousedown ){
        return
    }

    var canvas = e.target
    ctx = canvas.getContext('2d');

    ctx.lineCap = 'round';
    ctx.lineWidth = '1';
    ctx.strokeStyle = "red";
    ctx.setLineDash([]);
    ctx.lineTo(mouse.position.present.x,mouse.position.present.y);
    ctx.stroke();

}

function setAction(e) {
    action = e.target.getAttribute('data-action-name');
}

function setAnnotationType(
    type,
    questionID,
    group_id = null,
    buttonType = null,
    annotation_id = null
) {


    // if(questionID != null){
    //     if(annotation.type != null){
    //         if(){

    //         }
    //         annotation.type = annotation.questionID == questionID ? null : type;

    //     }else{
            annotation.type = type;
            annotation.groupID = group_id;
            annotation.buttonType = buttonType;
            if(annotation_id){
                annotation.annotation = annotation_id;
            }
    //     }
    // }else{
    //     annotation.type = annotation.type == type ? null : type;
    // }


    if(annotation.type == 'question' || annotation.type == 'answer' || annotation.type == 'diagram' ){
        action = 'rect';
    }
    annotation.questionID = questionID;

    console.log(annotation,action);

}

window.addEventListener('load',function () {

    var pdf_canvas = document.getElementById('pdf-render');
    pdf_canvas.addEventListener('mousedown', mouseDown, false);
    pdf_canvas.addEventListener('mouseup', mouseUp, false);
    pdf_canvas.addEventListener('mousemove', mouseMove, false);

    // var actionButton = document.getElementsByClassName('action-button');
    // var annotationTypeButton = document.getElementsByClassName('annotation-type-button');

    // var bookID = document.getElementsByClassName('canvas')[0].getAttribute('data-book-id');
    // renderQuestions(bookID);

    // Object.entries(actionButton).forEach(index => {
    //     actionButton[index[0]].addEventListener('click', setAction, false)
    // });

    // Object.entries(annotationTypeButton).forEach(index => {
    //     annotationTypeButton[index[0]].addEventListener('click', setAnnotationType , false)
    // });

    window.addEventListener('keypress', function (e) {
        // console.log(e.which);
        if (e.key === 'Enter') {
            crop(e);
            // console.log(e);
        }

    });


})

function handleCrud(event) {
    console.log();
}




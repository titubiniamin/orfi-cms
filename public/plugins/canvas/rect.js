var imageObj;
var annotation = {
    type : 'question',
    questionID: null
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

var ract = {
    x: 0,
    y: 0,
    width: 0,
    height: 0,
}

var action = null;

function setmouse(data) {
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
            presentCanvas.style.cursor = "crosshair";
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

function loadImageToCanvas(canvas) {
    canvas = document.getElementById(canvas.getAttribute('id'));
    imageObj = new Image();
    imageObj.onload = function () {

        canvas.height = this.height;
        canvas.width =  this.width;

        var ctx = canvas.getContext('2d');
        ctx.drawImage(imageObj, 0, 0);

    };

    imageObj.src = canvas.getAttribute('data-image-src');
    // canvas.style.cursor = "crosshair";
    renderAnnotation()

    canvas.addEventListener('mousedown', mouseDown, false);
    canvas.addEventListener('mouseup', mouseUp, false);
    canvas.addEventListener('mousemove', mouseMove, false);

}

function mouseDown(e) {
    movePoint(e)
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
    movePoint(e)
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

        let image = document.getElementById( presentCanvas.getAttribute('data-image-id') )
        // let previewImage = document.getElementById('preview_crop_image')
        // let preview = document.getElementById("crop_preview");
        let preview = document.createElement("canvas");

        preview.width = image.width;
        preview.height = image.height;

        let preview_ctx = preview.getContext("2d");
        preview_ctx.drawImage(image, x, y,  width, height, 0, 0, image.width, image.height);

        // previewImage.setAttribute("height", '400px');
        // previewImage.setAttribute("width",'100%' );
        // previewImage.setAttribute("src", preview.toDataURL('image/jpeg', 1.0));

        var annotationData = {
            type: annotation.type,
            bookID:presentCanvas.getAttribute('data-book-id'),
            questionID: annotation.questionID,
            screenshotID: presentCanvas.getAttribute('data-page-id'),
            imagebase64: preview.toDataURL('image/jpeg', 1.0),
            CoordinateX: x,
            CoordinateY: y,
            height: height,
            width: width,
        }

        store( annotationData );

    }
    // console.log(annotationData);

}

function drowRect(e) {

    if (mouse.event.mousedown) {

        var canvas = e.target,
        ctx = canvas.getContext('2d');

        ctx.clearRect(0, 0, imageObj.width, imageObj.height);
        ctx.drawImage(imageObj, 0, 0);

        rect.w = getCoordinates(e).x - mouse.position.start.x;
        rect.h = getCoordinates(e).y - mouse.position.start.y;

        ctx.setLineDash([20, 5]);
        // ctx.strokeStyle = 'rgb(63, 191, 191)';
        ctx.strokeStyle = annotation.type == 'question' ? 'red' : annotation.type == 'answer' ? 'green' : 'blue';

        ctx.strokeRect(mouse.position.start.x, mouse.position.start.y, rect.w, rect.h);
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

function setAnnotationType(type,questionID) {
    annotation.type = type;
    annotation.questionID = questionID;
    console.log(annotation);

}

window.addEventListener('load',function () {

    var actionButton = document.getElementsByClassName('action-button');
    var pdfPageCanvases = document.getElementsByClassName('canvas');

    var bookID = document.getElementsByClassName('canvas')[0].getAttribute('data-book-id');
    renderQuestions(bookID);

    Object.entries(actionButton).forEach(index => {
        actionButton[index[0]].addEventListener('click', setAction, false)
    });

    window.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
          crop(e);
        }
    });


})





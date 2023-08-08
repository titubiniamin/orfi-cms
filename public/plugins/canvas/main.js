window.addEventListener("load",()=>{

    var canvas = document.getElementById('canvas-seebeez-alicequite-0');
    var ctx = canvas.getContext('2d');

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

    var actions = {
        rect:false,
        line:false
    };

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
        var {x,y} = getCoordinates(e);
        ctx.moveTo(x,y);
    }

    function getCoordinates(e) {

        var rect = canvas.getBoundingClientRect();
        return {
          x: e.clientX - rect.left,
          y: e.clientY - rect.top
        };

    }

    function drowLine() {

        if(!mouse.event.mousedown ){
            return
        }

        if(!actions.line){
            return
        }

        ctx.lineCap = 'round';
        ctx.lineWidth = '5';
        ctx.strokeStyle = "red";

        ctx.lineTo(mouse.position.present.x,mouse.position.present.y);
        ctx.stroke();

    }

    function drowRect(e) {

        e.preventDefault();
        e.stopPropagation();


        if (!mouse.event.mousedown) {
            return;
        }


        mouseX = mouse.position.present.x;
        mouseY = mouse.position.present.y;

        var width = mouse.position.present.x - mouse.position.start.x;
        var height = mouse.position.present.y - mouse.position.start.y;

        // ctx.beginPath();
        ctx.fillStyle = 'rgba(0,0,0,.2';
        ctx.strokeStyle = 'red';
        ctx.lineWidth = 1;
        ctx.fillRect(mouse.position.start.x, mouse.position.start.y, width, height);

        // ctx.fillRect(10, 10, 100, 100);

        // ctx.stroke();

    }

    function drow(e) {
        if(actions.line){
            drowLine(e);
        }
        if(actions.rect){
            drowRect(e);
        }
    }

    canvas.addEventListener("mousedown",function (e){
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
    )

    canvas.addEventListener("mouseup",function (e){
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
    )

    canvas.addEventListener("mousemove",function (e){

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
    )

    document.getElementById("line").addEventListener("click", function(e) {

        actions = {
            rect:false,
            line: !actions.line
        };
        e.target.classList.toggle("bg-secondary");
    });

    document.getElementById("rect").addEventListener("click", function(e) {

        actions = {
            rect:!actions.rect,
            line: false,
        };

        e.target.classList.toggle("bg-secondary");
    });

})

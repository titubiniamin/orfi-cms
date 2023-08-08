
var slideIndex = 1;
var presentCanvas = null;
var presentCanvas_id = null;


showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
    var i;
    // console.log(n);
    var slides = document.getElementsByClassName("mySlides");
    // console.log(slides[n]);
    // var dots = document.getElementsByClassName("demo");
    //   var captionText = document.getElementById("caption");

    if (n > slides.length) {
        slideIndex = 1
    }

    if (n < 1) {
        slideIndex = slides.length
    }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    // for (i = 0; i < dots.length; i++) {
    //     dots[i].className = dots[i].className.replace(" active", "");
    // }
    // console.log(slides);
    slides[slideIndex-1].style.display = "block";
    presentCanvas = slides[slideIndex-1].childNodes[3];
    // console.log(presentCanvas.getAttribute('id'));
    loadImageToCanvas(presentCanvas)

// console.log(presentCanvas);
//   dots[slideIndex-1].className += " active";
//   captionText.innerHTML = dots[slideIndex-1].alt;

}




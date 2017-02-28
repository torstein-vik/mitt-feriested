function init() {
    console.log("it works!");
}

var slideIndex = 0;
var slides = $('.slide');
var slideAmt = slides.length;

//function slideshow() {
    var slide = $('.slide').eq(slideIndex);
    console.log(slideAmt);

    slide.css('display', 'block');
    slides.css('display', 'none');

//}

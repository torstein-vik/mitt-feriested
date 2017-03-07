function init() {

    var slideIndex = 0;
    var slides = $('.slide');
    var slideAmt = slides.length;

    function slideShow() {
        var slide = $('.slide').eq(slideIndex);

        slides.css('display', 'none');
        slide.css('display', 'block');
    }

    var autoSlide = setInterval(function() {
        slideIndex += 1;
        if (slideIndex > slideAmt - 1) {
            slideIndex = 0;
        }
        slideShow();
    }, 4000);

    $('#prev').click(function() {
        clearInterval(autoSlide);
        slideIndex -= 1;
        if (slideIndex > slideAmt - 1) {
            slideIndex = 0;
        }
        slideShow();
    });

    $('#next').click(function() {
        clearInterval(autoSlide);
        slideIndex += 1;
        if (slideIndex > slideAmt - 1) {
            slideIndex = 0;
        }
        slideShow();
    });

}


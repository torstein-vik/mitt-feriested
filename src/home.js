function init() {

    var slideIndex = 0;
    var slides = $('.slide');
    var slideAmt = slides.length;

    function slideShow() {
        var slide = $('.slide').eq(slideIndex);

        slides.css('display', 'none');
        slide.css('display', 'block');
    }

    function autoSlide() {
        slideIndex += 1;
        if (slideIndex > slideAmt - 1) {
            slideIndex = 0;
        }
        slideShow();
    }

    var autoSlide2 = setInterval(autoSlide, 3000);

    $('#prev').click(function() {
        clearInterval(autoSlide2);
        slideIndex -= 1;
        if (slideIndex > slideAmt - 1) {
            slideIndex = 0;
        } else if (slideIndex < 0){
            slideIndex = slideAmt - 1;
        }
        slideShow();
        setInterval(autoSlide, 3000);
    });

    $('#next').click(function() {
        clearInterval(autoSlide);
        slideIndex += 1;
        if (slideIndex > slideAmt - 1) {
            slideIndex = 0;
        } else if (slideIndex < 0){
            slideIndex = slideAmt - 1;
        }
        slideShow();
        setInterval(autoSlide, 3000);
    });

}


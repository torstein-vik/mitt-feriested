function init() {

    var slideIndex = 0;
    var slides = $('.slide');
    var slideAmt = slides.length;

    function slideShow() {
        var slide = $('.slide').eq(slideIndex);

        slides.css('display', 'none');
        slide.css('display', 'block');
    }

    var interval;
    var autoSlide = function() {
        interval = setInterval(function() {
            slideIndex += 1;
            if (slideIndex > slideAmt - 1) {
                slideIndex = 0;
            }
            slideShow();
        }, 3000);
    };

    autoSlide();

    $('#prev').click(function() {
        clearInterval(interval);
        slideIndex -= 1;
        if (slideIndex > slideAmt - 1) {
            slideIndex = 0;
        } else if (slideIndex < 0){
            slideIndex = slideAmt - 1;
        }
        slideShow();
        autoSlide();
    });

    $('#next').click(function() {
        clearInterval(interval);
        slideIndex += 1;
        if (slideIndex > slideAmt - 1) {
            slideIndex = 0;
        } else if (slideIndex < 0){
            slideIndex = slideAmt - 1;
        }
        slideShow();
        autoSlide();
    });

}


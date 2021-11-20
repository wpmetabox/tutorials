jQuery(document).ready(function ($) {
    jQuery(".list-restaurant .slider-res").slick({
        infinite: false,
        dots: false,
        autoplay: false,
        speed: 800,
        autoplaySpeed: 4000,
        slidesToShow: 3,
        slidesToScroll: 3,
        nextArrow: '<button class="next-btn">Next</button>',
        prevArrow: '<button class="prev-btn">Previous</button>'
    });

    jQuery('.status-res span').each(function () {
        if (jQuery(this).html() == 'open') {
            jQuery(this).parent().addClass('open');
        } else {
            jQuery(this).parent().addClass('close');
        }
    });

})

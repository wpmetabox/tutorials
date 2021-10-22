jQuery(document).ready(function ($) {
    $(".best-selling-product ul").slick({
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
    $(".list-restaurant .slider-res").slick({
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
        if (jQuery(this).html() == 'online') {
            jQuery(this).parent().addClass('online');
        } else {
            jQuery(this).parent().addClass('offline');
        }
    });
})
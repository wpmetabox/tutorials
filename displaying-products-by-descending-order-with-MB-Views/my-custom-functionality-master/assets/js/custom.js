jQuery(document).ready(function ($) {
    $(".slider-product").slick({
        infinite: false,
        // arrows: false,
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

    jQuery('.discount-price span').each(function () {
        if (jQuery(this).not(':empty').length) {
            jQuery(this).parent().addClass('no');
        } else {
            jQuery(this).parent().hide();
            jQuery(this).parent().next().addClass('full-width');
        }
    });

    jQuery('.status-res span').each(function () {
        if (jQuery(this).html() == 'online') {
            jQuery(this).parent().addClass('online');
        } else {
            jQuery(this).parent().addClass('offline');
        }
    });

})
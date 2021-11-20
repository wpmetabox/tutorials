jQuery(document).ready(function ($) {
    jQuery(".list-restaurant .ecs-posts").slick({
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
        if (jQuery(this).html() == 'Open') {
            jQuery(this).parents('.status-res').addClass('open');
        } else {
            jQuery(this).parents('.status-res').addClass('close');
        }
    });
})

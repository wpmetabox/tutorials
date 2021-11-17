jQuery(document).ready(function ($) {
    $(".list-restaurant .ecs-posts").slick({
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
    jQuery('.status-res span').each(function () {
        if (jQuery(this).html() == 'Online') {
            jQuery(this).parents('.status-res').addClass('online');
        } else {
            jQuery(this).parents('.status-res').addClass('offline');
        }
    });
})
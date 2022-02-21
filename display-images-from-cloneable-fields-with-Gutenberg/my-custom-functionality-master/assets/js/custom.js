jQuery(document).ready(function ($) {
    jQuery(".brand-group").slick({
        infinite: false,
        dots: false,
        autoplay: false,
        speed: 800,
        autoplaySpeed: 4000,
        slidesToShow: 7,
        slidesToScroll: 7,
        nextArrow: '<button class="next-btn">Next</button>',
        prevArrow: '<button class="prev-btn">Previous</button>'
    });
})

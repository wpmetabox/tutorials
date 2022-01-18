jQuery(document).ready(function ($) {
    $('.slider-single').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        adaptiveHeight: false,
        infinite: false,
        useTransform: true,
        speed: 400,
        cssEase: 'cubic-bezier(0.77, 0, 0.18, 1)',

    });

    $('.slider-nav')
        .on('init', function (event, slick) {
            $('.slider-nav .slick-slide.slick-current').addClass('is-active');
        })
        .slick({
            slidesToShow: 4,
            slidesToScroll: 4,
            dots: false,
            focusOnSelect: false,
            infinite: false,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 5,
                }
            }, {
                breakpoint: 640,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4,
                }
            }, {
                breakpoint: 420,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            }]
        });

    $('.slider-single').on('afterChange', function (event, slick, currentSlide) {
        $('.slider-nav').slick('slickGoTo', currentSlide);
        var currrentNavSlideElem = '.slider-nav .slick-slide[data-slick-index="' + currentSlide + '"]';
        $('.slider-nav .slick-slide.is-active').removeClass('is-active');
        $(currrentNavSlideElem).addClass('is-active');
    });

    $('.slider-nav').on('click', '.slick-slide', function (event) {
        event.preventDefault();
        var goToSingleSlide = $(this).data('slick-index');

        $('.slider-single').slick('slickGoTo', goToSingleSlide);
    });
    jQuery(".grouped-product .color-contain-group .color-group .color-name a").click(function (e) {
jQuery(".color-contain-group .color-group .color-name").removeClass("active");
jQuery(this).show();
jQuery(this).parent().addClass("active");
jQuery("div[data-id]").removeClass("active");
jQuery("div[data-id='" + jQuery(this).attr("href").replace("#", "") + "']").addClass("active");
jQuery('.slider-single').slick('refresh');
jQuery('.slider-nav').slick('refresh');
e.preventDefault();
    });

    jQuery(".size-contain-group .size-group .info .list-size a").click(function (e) {
        e.preventDefault();
    });

    jQuery('.size-contain-group .size-group .info .list-size .size-name').click(function(){
        jQuery(this).addClass('active');
        jQuery('.size-contain-group .size-group .info .list-size .size-name').not(this).removeClass('active')
    })
})

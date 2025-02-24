jQuery(document).ready(function ($) {
    $('.button-readmore').click(function () {
        $(this).parent().find('.bio-description').toggleClass('show-full-content');
        if ($(this).text() == "Read more")
            $(this).text("Read less")
        else
            $(this).text("Read more");
    })

    $(".hover-shadow").click(function () {
        $('.contact').toggleClass('show-popup');
    });

    $(".close.cursor").click(function () {
        $(".contact").removeClass("show-popup");
    });
})

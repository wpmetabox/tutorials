jQuery(function ($) {
    $('.timeline-readmore').click(function () {

        $(this).parent().find('.timeline-post').toggleClass('show-full-content')

        if ($(this).text() == "Read more")
            $(this).text("Read less")
        else
            $(this).text("Read more");
    })
})

jQuery(function ($) {
    $("#video-playlist .video").on("click", function () {
        $('.video').removeClass('active');
        $(this).addClass('active');
        $("#videoarea").attr({
            "src": $(this).find('.video-name').attr("movieurl"),
        })
    })
})


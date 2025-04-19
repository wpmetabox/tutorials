jQuery(document).ready(function ($) {
    var getTimeElement = document.getElementById("load-more");
    var first = getTimeElement.getAttribute("data-first");
    var loadmore = getTimeElement.getAttribute("data-loadmore");
    $(".mb-content").slice(0, first).show();
    $("#load-more").on("click", function (e) {
        e.preventDefault();
        $(".mb-content:hidden").slice(0, loadmore).slideDown();
        if ($(".mb-content:hidden").length == 0) {
            $("#load-more").css('visibility', 'hidden');
        }
    });
});

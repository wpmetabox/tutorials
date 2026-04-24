jQuery(document).ready(function ($) {
    var $grid = $('.project-grid').isotope({
        itemSelector: '.project-item',
        layoutMode: 'fitRows'
    });

    $('.filter-btn').on('click', function () {
        var filterValue = $(this).data('filter');
        $grid.isotope({ filter: filterValue });
        $('.filter-btn').removeClass('is-active');
        $(this).addClass('is-active');
    });
});

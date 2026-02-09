jQuery(function ($) {

    var iso = new Isotope($('.services-grid')[0], {
        itemSelector: '.service-item',
        layoutMode: 'fitRows'
    });

    var filters = { type: '*', plan: '*' };

    $('.filter-btn').on('click', function () {
        var g = $(this).data('group'),
            f = $(this).data('filter');

        $('.filter-btn[data-group="' + g + '"]').removeClass('active');
        $(this).addClass('active');

        filters[g] = f;

        iso.arrange({
            filter: Object.values(filters).filter(v => v !== '*').join('') || '*'
        });
    });

});

jQuery(document).ready(function ($) {
    $('.class-tabs').each(function () {
        var $container = $(this);
        $container.find('.tab-btn').on('click', function () {
            var tabId = $(this).data('tab');
            $container.find('.tab-btn').removeClass('active');
            $(this).addClass('active');
            $container.find('.tab-content').removeClass('active');
            $container.find('#' + tabId).addClass('active');
        });
    });
});

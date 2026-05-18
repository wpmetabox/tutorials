jQuery(function ($) {
    $('#filter-day').on('change', function () {
        const selected = $(this).val().toLowerCase();
        $('.doctor-card').each(function () {
            const days = $(this).data('days') || "";
            $(this).toggle(
                selected === "" || days.includes(selected)
            );
        });
    });
});

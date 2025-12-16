jQuery(function ($) {
    var $from = $('#from-date');
    var $to = $('#to-date');
    var $spec = $('#specific-date');
    var $items = $('.movie-item');

    $from.on('change', function () {
        $spec.val('');

        if (this.value) {
            $to.attr('min', this.value);
        } else {
            $to.removeAttr('min');
        }

        applyFilter();
    });

    $to.on('change', function () {
        $spec.val('');
        if (this.value) {
            $from.attr('max', this.value);
        } else {
            $from.removeAttr('max');
        }
        applyFilter();
    });

    $spec.on('change', function () {
        $from.val('').removeAttr('max');
        $to.val('').removeAttr('min');
        applyFilter();
    });

    $('#clear-filters').on('click', function (e) {
        e.preventDefault();

        $from.val('').removeAttr('max');
        $to.val('').removeAttr('min');
        $spec.val('');
        $items.show();
    });

    function applyFilter() {
        var from = $from.val();
        var to = $to.val();
        var spec = $spec.val();

        $items.each(function () {
            var d = $(this).data('date');
            var show = true;

            if (spec) {
                show = (d === spec);
            } else {
                if (from) {
                    if (d < from) {
                        show = false;
                    }
                }
                if (to) {
                    if (d > to) {
                        show = false;
                    }
                }
            }

            $(this).toggle(show);
        });
    }
});

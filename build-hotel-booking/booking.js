jQuery(document).ready(function ($) {
    $('.group-booking .add-clone').on('click', function (e) {
        setTimeout(function () {
            var rooms = $('.group-booking .rwmb-group-clone').length;
            $('#total_number_of_rooms').val(rooms);
            update_js();
        }, 100);

    });


    function update_js() {
        $('.group-booking .remove-clone').on('click', function (e) {
            setTimeout(function () {
                var rooms = $('.group-booking .rwmb-group-clone').length;
                $('#total_number_of_rooms').val(rooms);
            }, 100);
        });
        $(".group-booking .rwmb-field select[name*='[room]']").on('change', function () {
            var curr = $(this).val();
            var price_unit = $(this).closest('.rwmb-field').siblings().find("input[name*='[price]']");
            //var total_extra = 0;
            rooms_data.forEach(function (val, i) {
                if (curr == val['id']) {
                    price_unit.val(parseInt(val['regular_price']));
                }
                // if (2593 == val['id']) {
                //     total_extra = extra * parseInt(val['regular_price']);
                    
                // }
            });

            var total = $(this).closest('.rwmb-field').siblings().find("input[name*='[total_nights_of_stay]']").val();
            var price_unit = $(this).closest('.rwmb-field').siblings().find("input[name*='[price]']").val();
            //var total_extra = 0;
            var extra = $(this).closest('.rwmb-field').siblings().find("input[name*='[extra_bed]']").val();
            var total_extra = extra * price_unit;
            $(this).closest('.rwmb-field').siblings().find("input[name*='[total_amount]']").val((parseInt(price_unit) + parseInt(total_extra)) * total);
            update_total_payment();
        });
        $(".group-booking .rwmb-field input[name*='[check-in_date]']").on('change', function () {
            $(this).closest('.rwmb-field').siblings().find("input[name*='[check-out_date]']").datepicker('option', 'minDate', $(this).val());
        });
        $(".group-booking .rwmb-field input[name*='[check-out_date]']").on('change', function () {
            var total = calculate_total_day($(this).closest('.rwmb-field').siblings().find("input[name*='[check-in_date]']").val(), $(this).val());
            $(this).closest('.rwmb-field').siblings().find("input[name*='[total_nights_of_stay]']").val(total);

            var total = $(this).closest('.rwmb-field').siblings().find("input[name*='[total_nights_of_stay]']").val();
            //var total_extra = 0;
            var price_unit = $(this).closest('.rwmb-field').siblings().find("input[name*='[price]']").val();
            var extra = $(this).closest('.rwmb-field').siblings().find("input[name*='[extra_bed]']").val();
            var total_extra = extra * price_unit;
            rooms_data.forEach(function (val, i) {
                if (2593 == val['id']) {
                    total_extra = extra * parseInt(val['regular_price']);
                }
            });
            $(this).closest('.rwmb-field').siblings().find("input[name*='[total_amount]']").val((parseInt(price_unit) + parseInt(total_extra)) * total);
            update_total_payment();
        });

    }
    $(".group-booking .rwmb-field input[name*='[extra_bed]']").on('change', function () {
        var total = $(this).closest('.rwmb-field').siblings().find("input[name*='[total_nights_of_stay]']").val();
        var price_unit = $(this).closest('.rwmb-field').siblings().find("input[name*='[price]']").val();
        var extra = $(this).val();
        //alert(extra);
        var total_extra = extra * price_unit;
        //alert(total_extra);
        // rooms_data.forEach(function (val, i) {
        //     if (2593 == val['id']) {
        //         total_extra = extra * parseInt(val['regular_price']);
        //     }
        // });
        $(this).closest('.rwmb-field').siblings().find("input[name*='[total_amount]']").val((parseInt(price_unit) + parseInt(total_extra)) * total);
        update_total_payment();
    });
    $(".group-booking .rwmb-field select[name*='[room]']").on('change', function () {
        var curr = $(this).val();
        var price_unit = $(this).closest('.rwmb-field').siblings().find("input[name*='[price]']");
        //var total_extra = 0;
        rooms_data.forEach(function (val, i) {
            if (curr == val['id']) {
                price_unit.val(parseInt(val['regular_price']));
            }
            // if (2593 == val['id']) {
            //     total_extra = extra * parseInt(val['regular_price']);
            // }
        });

        var total = $(this).closest('.rwmb-field').siblings().find("input[name*='[total_nights_of_stay]']").val();
        var price_unit = $(this).closest('.rwmb-field').siblings().find("input[name*='[price]']").val();
        var total_extra;
        var extra = $(this).closest('.rwmb-field').siblings().find("input[name*='[extra_bed]']").val();
        var total_extra = extra * price_unit;
        $(this).closest('.rwmb-field').siblings().find("input[name*='[total_amount]']").val((parseInt(price_unit) + parseInt(total_extra)) * total);

        update_total_payment();
    });


    // $("#paid_amount").on('change', function () {
    //     $('#unpaid_amount').val(parseInt($('#total').val()) - parseInt($(this).val()));
    // });


    $(".group-booking .rwmb-field input[name*='[check-in_date]']").on('change', function () {
        var d = new Date($(this).val());
        var af_date = d.getDate() + 1;
        var af_month = d.getMonth() + 1;
        var af_year = d.getFullYear();
        var min_date = af_year + '-' + af_month + '-' + af_date;
        $(this).closest('.rwmb-field').siblings().find("input[name*='[check-out_date]']").datepicker('option', 'minDate', min_date);
        var total = $(this).closest('.rwmb-field').siblings().find("input[name*='[total_nights_of_stay]']").val();
        var price_unit = $(this).closest('.rwmb-field').siblings().find("input[name*='[price]']").val();
        //var total_extra = 0;
        var extra = $(this).closest('.rwmb-field').siblings().find("input[name*='[extra_bed]']").val();
        var total_extra = extra * price_unit;
        // rooms_data.forEach(function (val, i) {
        //     if (2593 == val['id']) {
        //         total_extra = extra * parseInt(val['regular_price']);
        //     }
        // });
        $(this).closest('.rwmb-field').siblings().find("input[name*='[total_amount]']").val((parseInt(price_unit) + parseInt(total_extra)) * total);
        update_total_payment();
    });

    $(".group-booking .rwmb-field input[name*='[check-out_date]']").on('change', function () {
        var total = calculate_total_day($(this).closest('.rwmb-field').siblings().find("input[name*='[check-in_date]']").val(), $(this).val());
        $(this).closest('.rwmb-field').siblings().find("input[name*='[total_nights_of_stay]']").val(total);

        var total = $(this).closest('.rwmb-field').siblings().find("input[name*='[total_nights_of_stay]']").val();
        var price_unit = $(this).closest('.rwmb-field').siblings().find("input[name*='[price]']").val();
        //var total_extra = 0;
        var extra = $(this).closest('.rwmb-field').siblings().find("input[name*='[extra_bed]']").val();
        var total_extra = extra * price_unit;
        // rooms_data.forEach(function (val, i) {
        //     if (2593 == val['id']) {
        //         total_extra = extra * parseInt(val['regular_price']);
        //     }
        // });
        $(this).closest('.rwmb-field').siblings().find("input[name*='[total_amount]']").val((parseInt(price_unit) + parseInt(total_extra)) * total);
        update_total_payment();
    });

    function calculate_total_day(check_in, check_out) {
        var date1 = new Date(check_in);
        var date2 = new Date(check_out);
        return (date2.getTime() - date1.getTime()) / (1000 * 3600 * 24);
    }

    function update_total_payment() {
        var total_payment = 0;
        $(".group-booking .rwmb-field input[name*='[total_amount]']").each(function () {
            total_payment = parseInt(total_payment) + parseInt($(this).val());
        })
        $('#total_amount').val(total_payment);
    }
});

jQuery('.content-wrapper div.dynamic').each(function () {
        if (jQuery.trim(jQuery(this).html()) == 'Open') {
            jQuery(this).addClass('open');
        } else {
            jQuery(this).addClass('close');
        }
 });

jQuery(document).ready(function ($) {
    setTimeout(function () {
        const $grid = $('.post-grid');
        if (!$grid.length) return;

        $grid.on('click', '.remove-fav', function (e) {
            e.preventDefault();
            const $item = $(this).closest('.post-item');
            const id = $item.data('post-id');
            if (!id) return;

            if (!confirm('Remove this post from favorites?')) return;

            $item.addClass('is-loading');

            $.post(window.MBFP.ajaxUrl, {
                action: 'mbfp_delete',
                id: id,
                _wpnonce: window.MBFP.deleteNonce
            })
                .done(function (res) {
                    if (!res || res.success !== true) {
                        alert((res && res.data) || 'Request failed');
                        $item.removeClass('is-loading');
                        return;
                    }
                    $item.remove();
                    if (!$grid.find('.post-item').length) {
                        const msg = (res.data && res.data.empty_notice) || 'No favorite posts yet.';
                        $grid.replaceWith('<p>' + msg + '</p>');
                    }
                })
                .fail(function (xhr) {
                    alert('Error occurred. Please try again.');
                    $item.removeClass('is-loading');
                });
        });
    }, 2000);
});

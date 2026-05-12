jQuery(function ($) {
    const $grid = $('#productGrid');
    if (!$grid.length) return;

    let $cards = $grid.children('.product-card');
    const originalOrder = $cards.toArray();

    const $range = $('#saleRange');
    const $rangeValue = $('#saleValue');

    const $orderSaleBtn = $('#orderSaleBtn');
    const $orderPriceBtn = $('#orderPriceBtn');
    const $resetBtn = $('#resetFilterBtn');
    function updateCountdown() {
        const now = Math.floor(Date.now() / 1000);
        $cards.each(function () {
            const $card = $(this);
            const end = parseInt($card.data('sale-end') || 0, 10);
            const salePersistent = String($card.data('sale-persistent')) === '1';
            const $countdown = $card.find('.countdown');
            const $timer = $card.find('.countdown-timer');
            if (!end) {
                $card.addClass('no-sale');
                return;
            }
            const diff = end - now;
            if (diff <= 0) {
                if (!salePersistent) {
                    $card.addClass('is-hidden');
                    return;
                }
                $card.addClass('no-sale');
                $countdown.remove();
                return;
            }
            if (!$timer.length) return;
            const days = Math.floor(diff / 86400);
            const hours = Math.floor((diff % 86400) / 3600);
            const minutes = Math.floor((diff % 3600) / 60);
            const seconds = diff % 60;
            let text = '';
            if (days > 0) {
                text += days + 'd ';
            }
            text += hours + 'h ' + minutes + 'm ' + seconds + 's';
            $timer.text(text);
        });
    }
    function filterSale() {
        const min = parseInt($range.val(), 10);
        $rangeValue.text(min + '%');
        $cards.each(function () {
            const sale = parseInt($(this).data('sale') || 0, 10);
            $(this).toggleClass('is-filter-hidden', sale < min);
        });
    }
    function orderSalePercent() {
        $cards = $cards.sort((a, b) => ($(b).data('sale') || 0) - ($(a).data('sale') || 0))
            .appendTo($grid);
    }
    function orderSalePrice() {
        $cards = $cards.sort((a, b) =>
            (parseFloat($(a).data('sale-price')) || 0) -
            (parseFloat($(b).data('sale-price')) || 0)
        ).appendTo($grid);
    }
    function resetAll() {
        $range.val(0);
        $rangeValue.text('0%');
        $cards.removeClass('is-filter-hidden');
        $cards = $(originalOrder).appendTo($grid);
    }
    updateCountdown();
    setInterval(updateCountdown, 1000);

    $range.on('input', filterSale);
    $orderSaleBtn.on('click', orderSalePercent);
    $orderPriceBtn.on('click', orderSalePrice);
    $resetBtn.on('click', resetAll);
});

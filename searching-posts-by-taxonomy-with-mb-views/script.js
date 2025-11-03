jQuery(function ($) {
    const locations = $('#location-data li').map((_, li) => ({
        id: $(li).data('id'),
        name: $(li).text(),
    })).get();

    const $input = $('#location');
    const $suggest = $('#suggestions');
    let selected = '';

    const clearSuggest = function () {
        $suggest.empty().hide();
    };

    const renderSuggestions = function (q) {
        clearSuggest();
        if (q.length < 2) {
            return;
        }

        locations
            .filter(function (l) {
                return l.name.toLowerCase().includes(q);
            })
            .slice(0, 20)
            .forEach(function (l) {
                $suggest.append(
                    '<li data-id="' + l.id + '" data-name="' + l.name + '">' + l.name + '</li>'
                );
            });

        if ($suggest.children().length) {
            $suggest.show();
        }
    };

    const filterHotels = function (filter) {
        $('.hotel-item').each(function (_, el) {
            const loc = ($(el).data('location') || '').toLowerCase();
            $(el).toggle(loc.includes(filter));
        });
    };

    // Input -> suggestions.
    $input.on('input', function () {
        selected = '';
        renderSuggestions($input.val().trim().toLowerCase());
    });

    // Click suggestion.
    $suggest.on('click', 'li', function (e) {
        const name = $(e.currentTarget).data('name');
        selected = name.toLowerCase();
        $input.val(name);
        clearSuggest();
    });

    // Click outside.
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#location, #suggestions').length) {
            clearSuggest();
        }
    });

    // Search button.
    $('.filter-action').on('click', function () {
        const filter = selected || $input.val().trim().toLowerCase();
        filterHotels(filter);
    });

    // Enter key.
    $input.on('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            $('.filter-action').trigger('click');
            clearSuggest();
        }
    });
});

jQuery(function ($) {
    window.addEventListener('load', async () => {
        const $section = $('#mb-recently-viewed');
        if (!$section.length || !$('body').hasClass('single-post')) return;

        const $container = $section.find('.mb-rv-list');
        const $loading = $section.find('.mb-rv-loading');

        // Create a fixed uid for this browser (not dependent on login)
        const uid = (function () {
            const saved = localStorage.getItem('mb_rv_uid');
            if (saved) return saved;
            const v = 'guest-' + Math.random().toString(36).slice(2);
            localStorage.setItem('mb_rv_uid', v);
            return v;
        })();
        const key = `mb_recently_viewed_posts_${uid}`;

        const getList = () => {
            try { return JSON.parse(Cookies.get(key) || '[]'); }
            catch { return []; }
        };
        const setList = (list) => Cookies.set(key, JSON.stringify(list), { expires: 7 });

        // Record the current post
        const currentId =
            $('article[id^="post-"]').attr('id')?.replace('post-', '') ||
            $('body').attr('class')?.match(/postid-(\d+)/)?.[1] || null;

        if (currentId) {
            const updated = [
                { id: currentId, time: Date.now() },
                ...getList().filter(item => item.id !== currentId),
            ].slice(0, 10);
            setList(updated);
        }

        // Filter items older than 7 days
        const now = Date.now();
        let list = getList().filter(({ time }) => now - time < 7 * 24 * 60 * 60 * 1000);
        setList(list);

        if (!list.length) {
            $loading.text('No recently viewed posts.');
            return;
        }

        const ids = list.map(item => item.id);

        try {
            const res = await fetch(`/wp-json/wp/v2/posts?include=${ids.join(',')}&_embed&per_page=100`);
            const posts = await res.json();
            $loading.remove();

            const postMap = Object.fromEntries(posts.map(p => [String(p.id), p]));
            renderClearButton($section, key, $container);

            const items = ids.map(id => createItem(postMap[id])).filter(Boolean);
            ids.length <= 4
                ? renderGrid($container, items)
                : renderSwiper($section, $container, items);
        } catch (e) {
            console.error(e);
            $loading.text('Unable to load recently viewed posts.');
        }
    });

    function renderClearButton($section, key, $container) {
        if ($section.find('#mb-clear-history').length) return;
        $('<button>', {
            id: 'mb-clear-history',
            class: 'mb-clear-history',
            text: 'Clear History',
            css: { float: 'right', marginBottom: 10 },
            click: () => {
                Cookies.remove(key);
                if (window._recentlySwiper?.destroy) {
                    window._recentlySwiper.destroy(true, true);
                    window._recentlySwiper = null;
                }
                $container.empty().append('<p>History cleared.</p>');
            }
        }).prependTo($section);
    }

    function createItem(post) {
        if (!post) return null;
        const img = post._embedded?.['wp:featuredmedia']?.[0]?.source_url || '/wp-content/uploads/placeholder.png';
        const date = new Date(post.date).toLocaleDateString();
        return $(`
            <article class="mb-rv-item">
                <a class="mb-rv-thumb" href="${post.link}">
                    <img src="${img}" alt="${escapeHtml(post.title.rendered)}">
                </a>
                <div class="mb-rv-body">
                    <h4 class="mb-rv-title-item">
                        <a href="${post.link}">${post.title.rendered}</a>
                    </h4>
                    <p class="mb-rv-date">${date}</p>
                </div>
            </article>
        `);
    }

    function renderGrid($container, items) {
        $container.empty().append(items);
    }

    function renderSwiper($section, $container, items) {
        const $swiper = $('<div class="swiper mySwiper" aria-label="Recently viewed slider"></div>');
        const $wrap = $('<div class="swiper-wrapper"></div>').appendTo($swiper);

        items.forEach(($item) =>
            $('<div class="swiper-slide"></div>').append($item).appendTo($wrap)
        );

        $swiper.append('<div class="swiper-button-prev"></div><div class="swiper-button-next"></div><div class="swiper-pagination"></div>');
        $container.replaceWith($swiper);

        if (window._recentlySwiper?.destroy) window._recentlySwiper.destroy(true, true);
        window._recentlySwiper = new Swiper('.mySwiper', {
            slidesPerView: 4,
            spaceBetween: 20,
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
            pagination: { el: '.swiper-pagination', clickable: true },
            breakpoints: {
                0: { slidesPerView: 1.2 },
                640: { slidesPerView: 2 },
                768: { slidesPerView: 3 },
                1024: { slidesPerView: 4 },
            },
        });
    }

    function escapeHtml(str = '') {
        return String(str)
            .replace(/&/g, '&')
            .replace(/</g, '<')
            .replace(/>/g, '>')
            .replace(/"/g, '"');
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const poll = document.querySelector('.poll');
    if (!poll) return;

    poll.addEventListener('click', e => {
        const btn = e.target.closest('.poll-button');
        if (!btn || poll.classList.contains('voted')) return;

        const option = btn.closest('.poll-option').dataset.option;
        btn.disabled = true;

        fetch(poll.dataset.ajax, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ action: 'submit_poll_vote', option })
        })
            .then(r => r.json())
            .then(res => {
                btn.disabled = false;
                if (!res.success) { alert(res.data.message); return; }
                updatePoll(res.data, option);
            })
            .catch(() => btn.disabled = false);
    });

    function updatePoll(data, votedOption) {
        const wrapper = poll.querySelector('.poll-options');
        const items = [...wrapper.querySelectorAll('.poll-option')];
        const maxVotes = data.options[0].votes;

        data.options.forEach(opt => {
            const el = wrapper.querySelector(`[data-option="${opt.label}"]`);
            if (!el) return;
            el.querySelector('.poll-progress').style.width = opt.percent + '%';
            el.querySelector('.poll-percent').textContent = opt.percent + '%';
            el.querySelector('.poll-votes').textContent = opt.votes;
            el.classList.toggle('is-voted', opt.label === votedOption);
            el.classList.toggle('is-winner', opt.votes === maxVotes);
        });

        const firstRects = Object.fromEntries(
            items.map(el => [el.dataset.option, el.getBoundingClientRect().top])
        );

        data.options.forEach(opt => {
            const el = wrapper.querySelector(`[data-option="${opt.label}"]`);
            if (el) wrapper.appendChild(el);
        });

        items.forEach(el => {
            const delta = firstRects[el.dataset.option] - el.getBoundingClientRect().top;
            if (!delta) return;
            el.style.cssText = `transform:translateY(${delta}px);transition:none`;
            el.getBoundingClientRect(); // trigger reflow
            el.style.cssText = 'transform:translateY(0);transition:transform 0.6s cubic-bezier(0.22,1,0.36,1)';
        });

        setTimeout(() => items.forEach(el => el.style.cssText = ''), 700);

        poll.querySelector('.poll-total-value').textContent = data.total;
        showVotedMessage(votedOption);
        poll.classList.add('voted');
    }

    function showVotedMessage(label) {
        let msg = poll.querySelector('.poll-message');
        if (!msg) {
            msg = Object.assign(document.createElement('div'), { className: 'poll-message' });
            poll.appendChild(msg);
        }
        msg.textContent = '✓ You voted for ' + label;
        msg.style.cssText = 'opacity:0;transition:opacity 0.4s ease';
        setTimeout(() => msg.style.opacity = '1', 50);
    }
});

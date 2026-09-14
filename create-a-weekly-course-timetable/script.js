jQuery(function ($) {
    const $container = $('#mb-course-schedule');
    if (!$container.length) return;

    const courses  = $container.data('courses') || [];
    const teachers = $container.data('teachers') || {};
    const days     = ['monday','tuesday','wednesday','thursday','friday','saturday'];
    const minH     = Math.min(...courses.map(c => parseInt(c.start)));
    const maxH     = Math.max(...courses.map(c => parseInt(c.end)));
    const rowH     = 30;

    let html = `<div class="schedule-filter"><button class="active" data-teacher="all">All Teachers</button>`;
    $.each(teachers, (slug, name) => { html += `<button data-teacher="${slug}">${name}</button>`; });
    html += `</div><div class="schedule-grid"><div class="schedule-header"><div></div>`;
    days.forEach(d => { html += `<div>${d.charAt(0).toUpperCase() + d.slice(1)}</div>`; });
    html += `</div>`;
    let ri = 0;
    for (let h = minH; h <= maxH; h++) {
        for (let m = 0; m < 60; m += 15) {
            const rc = ri++ % 2 === 0 ? 'row-even' : 'row-odd';
            html += `<div class="time-cell ${rc}">${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}</div>`;
            for (let d = 0; d < 6; d++) html += `<div class="day-cell ${rc}"></div>`;
        }
    }
    html += `</div>`;
    $container.html(html);

    const $grid = $('.schedule-grid');
    setTimeout(() => {
        const timeColW  = $grid.find('.time-cell').first().outerWidth();
        const headerH   = $grid.find('.schedule-header div').first().outerHeight();
        const dayW      = ($grid.outerWidth() - timeColW) / 6;

        courses.forEach(course => {
            const [sh, sm] = course.start.split(':').map(Number);
            const [eh, em] = course.end.split(':').map(Number);
            const startMin = (sh - minH) * 60 + sm;
            const endMin   = (eh - minH) * 60 + em;
            const dayIndex = days.indexOf(course.day);
            if (dayIndex < 0) return;

            const teacherNames = (course.teachers || []).map(s => teachers[s] || s);

            $('<div>', {
                class: 'course-block',
                'data-course':   course.id,
                'data-teacher':  (course.teachers || []).join(',')
            }).css({
                background: course.color,
                top:    headerH + (startMin / 15 * rowH),
                left:   timeColW + dayIndex * dayW + 2,
                width:  dayW - 4,
                height: ((endMin - startMin) / 15) * rowH - 2
            }).html(`
                <div class="course-title">${course.title}</div>
                <div class="course-time">${course.start} - ${course.end}</div>
                ${course.description ? `<div class="course-desc">${course.description}</div>` : ''}
                ${course.room       ? `<div class="course-room">🏫 ${course.room}</div>` : ''}
                ${teacherNames.length ? `<div class="course-teacher">👤 ${teacherNames.join(', ')}</div>` : ''}
            `).appendTo($grid);
        });
    }, 0);

    $container.on('click', '.schedule-filter button', function () {
        const teacher = $(this).data('teacher');
        $('.schedule-filter button').removeClass('active');
        $(this).addClass('active');
        $('.course-block').each(function () {
            const list = ($(this).data('teacher') || '').split(',');
            $(this).toggle(teacher === 'all' || list.includes(String(teacher)));
        });
    });
});

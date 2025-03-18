$(function () {
    var getTimeElement = document.getElementById("calendar");
    var data_event = JSON.parse(getTimeElement.getAttribute("data-event"));

    const current_date = new Date();

    $('#calendar').fullCalendar({
        locale: 'en',
        header: {
            left: 'prev,next, today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
        },
        defaultDate: current_date,
        navLinks: true,
        editable: true,
        eventLimit: true,
        events: data_event,
    });
});

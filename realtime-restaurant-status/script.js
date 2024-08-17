var getTimeElement = document.getElementById("time");
var TimeObject = JSON.parse(getTimeElement.getAttribute("data-time"));

// Short day
var date = new Date();
Date.shortDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
function short_Days(date) {
    return Date.shortDays[date.getDay()];
}

// Get time now
var now = date.getHours() + "." + date.getMinutes();

// Loop TimeObject
TimeObject.forEach(function (elm) {

    if (elm.day == short_Days(date)) {

        var timeSlots = elm.timeSlots

        var statusArray = [];
        timeSlots.forEach(function (elm) {
            if (parseFloat(now) > parseFloat(elm.start_time) && parseFloat(now) < parseFloat(elm.end_time)) {
                statusArray.push('open')
            } else {
                statusArray.push('close')
            }
        })

        if (statusArray.includes('open')) {
            document.getElementById("restaurant-status").innerHTML = `OPEN`;
        } else {
            document.getElementById("restaurant-status").innerHTML = `CLOSE`;
        }

    }
})

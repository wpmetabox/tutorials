
$.ajax({
  type: 'post',
  url: ajaxurl,
  data: {action: 'feed_events'},
  error: function(err){
    console.log(err);
  },
  success: function (data)
  {
    init_calendar(data);
  }
})



function init_calendar(events){
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    plugins: [ 'dayGrid' ],
    defaultView: 'dayGridMonth',
    header: {
      left: 'prev,next today',
      center: 'title',
      right: ''
    },
    events: events,
    eventPositioned (view, element) {
      displayBookings();
    },
  });

  calendar.render();
}


$('.filter-bookings').on('click', function(event){

  event.stopPropagation();

  var room_id = $(this).attr('data-room');

  $('.wrap').attr('class', 'wrap ' + room_id);

    displayBookings();
 
})



function displayBookings(){

  var classes = $('.wrap').attr('class');

  if (classes != 'wrap') {

    room = classes.replace("wrap ", "");

    if (room == 'all') {

      $('[class*="room-"]').show();

    } else {

      $('[class*="room-"]').hide();

      $('.room-'+room).show();

    }

  }

}
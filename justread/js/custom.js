jQuery( function($) {

  setTimeout(function(){
    datepicker_reinstall();
    console.log(disable_dates);
  }, 1000);
  function datepicker_reinstall(){
    var dateFormat = "yy-mm-dd",
    from = $( "#group_booking_check_in" ),
    to = $( "#group_booking_check_out" );
    from.add(to).datepicker('destroy');
    from.datepicker({
      minDate: 0,
      defaultDate: "+1w",
      beforeShowDay: function(date){
        var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
        return [ disable_dates.indexOf(string) == -1 ]
      }
    })
      .on( "change", function() {
        to.datepicker( "option", "minDate", getDate( this ) );
    });
    to.datepicker({
      defaultDate: "+1w",
      beforeShowDay: function(date){
        var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
        return [ disable_dates.indexOf(string) == -1 ]
      }
    })
    .on( "change", function() {
      from.datepicker( "option", "maxDate", getDate( this ) );
    });

    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
      return date;
    }
  }

} );




{% set timeArray = [] %}
{% for clone in post.custom_time %}
  {% set  timeSlotsArray= [] %}
      {% for clone in clone.choose_time_slots %}
            {% set timeSlotsArray = timeSlotsArray|merge([ {'start_time':clone.start_time | date( 'H.i' ),'end_time':clone.end_time | date( 'H.i' )} ] ) %}
      {% endfor %}
    {% set timeArray = timeArray|merge([ { 'day':clone.day.value, 'timeSlots':timeSlotsArray} ]) %}
{% endfor %}
<div id="time" data-time='{{timeArray|json_encode()}}'>
	<div id="restaurant-status"></div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/locale-all.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" />

{% set args = { post_type: 'event', posts_per_page: -1} %}
{% set posts = mb.get_posts( args ) %}

{% set event_info = [] %}
{% for post in posts %}
    {% set event_info = event_info|merge([{ title: post.title, start: post.start_date | date( 'Y-m-d H:i' ), end: post.end_date | date( 'Y-m-d H:i' ) }]) %}
{% endfor %}

<div id="calendar" data-event='{{ event_info|json_encode() }}'></div>

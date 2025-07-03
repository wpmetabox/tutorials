{% set course_id = post.ID %}
{% set options = mb.get_option('schedule') %}
{% set schedule = options.schedule_detail ?? [] %}
{% set filtered = [] %}

{% for row in schedule %}
{% set related_courses = row.courses ?? [] %}
{% if course_id in related_courses %}
{% set filtered = filtered|merge([row]) %}
{% endif %}
{% endfor %}

{% if filtered is not empty %}
<table class="mb-table">
	<thead>
		<tr>
			<th>Day</th>
			<th>Teacher</th>
			<th>Price</th>
		</tr>
	</thead>
	<tbody>
		{% for row in filtered %}
		<tr>
			<td>{{ row.date | date( 'd F Y' ) }}</td>
			<td>{{ row.teacher }}</td>
			<td>${{ row.price }} </td>
		</tr>
		{% endfor %}
	</tbody>
</table>
{% else %}
<p>No schedule available for this course.</p>
{% endif %}
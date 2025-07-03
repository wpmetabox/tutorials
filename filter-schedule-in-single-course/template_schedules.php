<table class="mb-table">
	<thead>
		<tr>
			<th>Day</th>
			<th>Teacher</th>
			<th>Price</th>
			<th>Courses</th>
		</tr>
	</thead>
	<tbody>
		{% for clone in site.schedule.schedule_detail %}
		<tr>
			<td>{{ clone.date | date('d/m/Y') }}</td>
			<td>{{ clone.teacher.value }} </td>
			<td>${{ clone.price }}</td>
			<td>
				{% for item in clone.courses %}
				<a href="{{ item.url }}">{{ item.title }}</a>
				{% if not loop.last %}, {% endif %}
				{% endfor %}
			</td>
		</tr>
		{% endfor %}
	</tbody>
</table>
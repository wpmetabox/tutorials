{% set args = {  post_type: 'room',   posts_per_page: -1,  orderby: 'date',order: 'DESC'    } %}
{% set posts = mb.get_posts(args) %}

<div class="mb-container">
	<h1> Rooms Listing</h1>
	<div class="room-grid">
		{% for post in posts %}
		<div class="room-card">
			{% if post.gallery|length > 0 %}
			{% set first_image = post.gallery|first %}
			<img src="{{ first_image.full.url }}" alt="{{ first_image.alt ?? post.title }}">
			{% endif %}
			<div class="room-info">
				<div class="room-title"><a href="{{ post.url }}">{{ post.title }} </a></div>
				<div class="room-price">{{ post.price }}$</div>
				<div class="room-meta">
					Max adults per room: {{ post.number_of_adults }} <br>
					Max children per room: {{ post.max_children_per_room }}
				</div>
			</div>
		</div>
		{% endfor %}
	</div>
</div>
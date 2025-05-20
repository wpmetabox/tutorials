<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
{% set args = { post_type: 'post', posts_per_page: -1} %}
{% set posts = mb.get_posts( args ) %}
<div class="accordian">
	<ul>
		{% for post in posts %}
		<li class="mb-item">
			<div class="image_title">
				<a href="{{ mb.get_permalink( post.ID ) }}">{{ mb.substr(post.title, 0, 15) }} ...</a>
			</div>
			<a href="#" class="mb-image">
				<img src="{{ post.thumbnail.full.url }}" width="{{ post.thumbnail.full.width }}"
					height="{{ post.thumbnail.full.height }}" alt="{{ post.thumbnail.full.alt }}">
			</a>
		</li>
		{% endfor %}
	</ul>
</div>
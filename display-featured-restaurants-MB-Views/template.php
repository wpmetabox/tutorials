<div class="listing">
	{% set args = { post_type: 'restaurant', posts_per_page: -1 } %}
	{% set posts = mb.get_posts( args ) %}
		{% for post in posts %}
			{% if post.feature_the_restaurant == 1 %}
			<div class="contain-restaurant">
				<div class="cover-image-res">
					<img src="{{ post.thumbnail.full.url }}" width="{{ post.thumbnail.full.width }}" height="{{ post.thumbnail.full.height }}" alt="{{ post.thumbnail.full.alt }}">
				</div>
				<div class="logo">
						<img src="{{ post.logo.full.url }}" width="{{ post.logo.full.width }}" height="{{ post.logo.full.height }}" alt="{{ post.logo.full.alt }}" class="logo">
				</div>
				<div class="voucher-res">
					{% for item in post.voucher %}
					{{ item.label }}
					{% endfor %}
				</div>
				<a href="{{ post.url }}">{{ post.title }}</a>
				<p>{{ post.address }}</p>
			</div>
			{% endif %}
		{% endfor %}
</div>

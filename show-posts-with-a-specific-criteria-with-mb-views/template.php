<div class="cuisine-template">
	<h1>{{ post.title }}</h1>
	{% set args = { post_type: 'cuisine', meta_key : 'promotional_price',meta_value: '', meta_compare : '!=', meta_type : 'CHAR', posts_per_page: 6, order: 'DESC' } %}
	{% set posts = mb.get_posts( args ) %}
	<div class="cuisine-items">
	{% for post in posts %}
		<div class="cuisine-item">
			<img src="{{ post.thumbnail.full.url }}" width="{{ post.thumbnail.full.width }}" height="{{ post.thumbnail.full.height }}" alt="{{ post.thumbnail.full.alt }}">
			<div class="heading-cover">
				<h2><a href="{{ post.url }}">{{ post.title }}</a></h2>
				<div class="price">
					<div class="promotional-price">
						${{ post.promotional_price }}
					</div>
					<div class="original-price">
						${{ post.original_price }}
					</div>
				</div>
			</div>
			<p>{{ post.content }}</p>
		</div>
	{% endfor %}
	</div>
</div>

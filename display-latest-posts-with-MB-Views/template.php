<div class="list-restaurant slider">
	<div class="slider-res slider__wrapper">
		{% set args = { post_type: 'restaurant', posts_per_page: -1, orderby: 'date', order: 'DESC' } %}
		{% set posts = mb.get_posts( args ) %}
		{% for post in posts %}
		<div class="contain-restaurant slider__item">
			<div class="cover-image-res">
				<img src="{{ post.thumbnail.large.url }}" width="{{ post.thumbnail.large.width }}" height="{{ post.thumbnail.large.height }}" alt="{{ post.thumbnail.large.alt }}">
				<div class="voucher-res">
					<span>
					{% for item in post.voucher %}
						{{ item.label }}
					{% endfor %}
					</span>
				</div>
			</div>
			<div class="logo">
				<img src="{{ post.logo.thumbnail.url }}" width="{{ post.logo.thumbnail.width }}" height="{{ post.logo.thumbnail.height }}" alt="{{ post.logo.thumbnail.alt }}">
			</div>
			<a class="name-res" href="{{ mb.get_permalink( post.ID ) }}"> {{ post.post_title }}</a>
			<div class="address-res"> {{ post.address }}</div>
			<div class="status-res">
				<span>{{ post.status.label }}</span>
			</div>
		</div>
		{% endfor %}
    
	</div>
	<a class="slider__control slider__control_left" href="#" role="button"></a>
    <a class="slider__control slider__control_right slider__control_show" href="#" role="button"></a>
</div>

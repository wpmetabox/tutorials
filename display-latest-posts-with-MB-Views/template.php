<div class="list-restaurant">
	<div class="slider-res">
{% set args = { post_type: 'restaurant', posts_per_page: -1, orderby: 'date', order: 'DESC' } %}
{% set posts = mb.get_posts( args ) %}
{% for post in posts %}
	<div class="contain-restaurant">
		<div class="cover-image-res">
			<img src="{{ post.logo.thumbnail.url }}" width="{{ post.logo.thumbnail.width }}" height="{{ post.logo.thumbnail.height }}" alt="{{ post.logo.thumbnail.alt }}">
			<div class="voucher-res">
				<span>{% for item in post.voucher %}
	{{ item.label }}
{% endfor %}
</span>
			</div>
			<div class="brand-res">
				<img src="{{ post.logo.thumbnail.url }}" width="{{ post.logo.thumbnail.width }}" height="{{ post.logo.thumbnail.height }}" alt="{{ post.logo.thumbnail.alt }}">
<a class="name-res" href="{{ mb.get_permalink( post.ID ) }}"> {{ post.post_title }}</a>
		<div class="address-res"> {{ post.address }}</div>

		<div class="status-res">
			<span>{{ post.status.label }}</span>
		</div>
</div>
<div>

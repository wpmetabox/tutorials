<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://npmcdn.com/isotope-layout@3.0.6/dist/isotope.pkgd.js"></script>

<div class="mb-container">
	<div class="filter-buttons">
		<button data-filter="*" class="filter-tab active">All Restaurants</button>
		{% set terms = mb.get_terms({taxonomy: 'voucher'}) %}
		{% for term in terms %}
		<button data-filter=".{{ term.slug }}" class="filter-tab">{{ term.name }}</button>
		{% endfor %}
	</div>

	<div class="grid">
		{% set args = { post_type: 'restaurant', posts_per_page: -1, orderby: 'date', order: 'DESC' } %}
		{% set posts = mb.get_posts(args) %}
		{% for post in posts %}
		{% set vouchers = mb.get_the_terms(post.ID, 'voucher') %}
		{% set voucher_classes = '' %}
		{% if vouchers is not empty %}
		{% set voucher_classes = vouchers|map(v => v.slug)|join(' ') %}
		{% endif %}

		<div class="grid-item {{ voucher_classes }}">
			<div class="restaurant-card">
				<div class="image-wrapper">
					<img class="feature-img" src="{{ post.thumbnail.full.url }}" width="{{ post.thumbnail.full.width }}"
						height="{{ post.thumbnail.full.height }}" alt="{{ post.thumbnail.full.alt }}">
					<span class="status-dot {{ post.status.value }}"></span>
					<img class="logo-img" src="{{ post.logo.full.url }}" width="{{ post.logo.full.width }}"
						height="{{ post.logo.full.height }}" alt="{{ post.logo.full.alt }}">
				</div>
				{% if vouchers %}
				{% for voucher in vouchers %}
				<div class="voucher-label">{{ voucher.name }} </div>
				{% endfor %}
				{% endif %}
				<div class="mb-title">{{ post.title }} </div>
				<div class="mb-address">{{ post.address }} </div>
			</div>
		</div>
		{% endfor %}
	</div>
</div>
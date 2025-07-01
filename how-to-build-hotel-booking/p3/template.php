<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<div class="swiper main-slider">
	<div class="swiper-wrapper">
		{% for item in post.gallery %}
		<div class="swiper-slide">
			<img src="{{ item.full.url }}" width="{{ item.full.width }}" height="{{ item.full.height }}"
				alt="{{ item.full.alt }}">
		</div>
		{% endfor %}
	</div>

	<!-- Navigation -->
	<div class="swiper-button-prev"></div>
	<div class="swiper-button-next"></div>

	<!-- Dots -->
	<div class="swiper-pagination"></div>
</div>

<!-- Thumbnail slider -->
<div class="swiper thumb-slider">
	<div class="swiper-wrapper">
		{% for item in post.gallery %}
		<div class="swiper-slide">
			<img src="{{ item.full.url }}" width="100" height="60" alt="{{ item.full.alt }}">
		</div>
		{% endfor %}
	</div>
</div>

<div class="infor">
	<div class="regular_price">Price Regular: {{ post.price }}$ </div>
	<ul class="number_of_adults max_children_per_room">
		<li>Number of Adults: {{ post.number_of_adults }}</li>
		<li>Max Children per room: {{ post.max_children_per_room }} </li>
	</ul>
	<div class="additional_information">{{ post.additional_information }} </div>
</div>
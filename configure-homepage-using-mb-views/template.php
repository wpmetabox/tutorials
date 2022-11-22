	<!-- Carousel
	================================================== -->
<div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
		{% for clone in post.homepage_fields %}
		<div class="carousel-item {% if loop.first %}active{% endif %}">
			<img src="{{ clone.single_image.full.url }}" width="{{ clone.single_image.full.width }}" height="{{ clone.single_image.full.height }}" alt="{{ clone.single_image.full.alt }}">
			<div class="container">
          		<div class="carousel-caption  {% if loop.first %}text-start{% endif %} {% if loop.last %}text-end{% endif %}">
					<h1>
						{{ clone.title }}
					</h1>
					<p>
						{{ clone.description }}
					</p>
					<p><a class="btn btn-lg btn-primary" href="{{ clone.button_link }}">{{ clone.button_text }}</a></p>
				</div>
			</div>
		</div>
		{% endfor %}
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>


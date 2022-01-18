{% set product_types = post.does_this_product_have_variations %}
<div class="container detail-product">
	{% if (product_types  == 0) %}
	 	<div class="page-layout simple-product">
			<div class="gallery-side">
					<div class="group-image">
								<div class="slider slider-single">
									{% for item in post.simple_product.product_images %}
										<div class="img-slider">
											<img src="{{ item.large.url }}" width="{{ item.large.width }}" height="{{ item.large.height }}" alt="{{ item.large.alt }}"/>
										</div>
									{% endfor %}
								</div>
								<div class="slider slider-nav">
									{% for item in post.simple_product.product_images %}
									 <div class="gallery-slide">
											<img src="{{ item.thumbnail.url }}" width="{{ item.thumbnail.width }}" height="{{ item.thumbnail.height }}" alt="{{ item.thumbnail.alt }}"/>
									</div>
									{% endfor %}
								</div>
					</div>
			</div>
			<div class="info-detail-product">
				<h1 class="title-product">{{ post.title }}</h1>
				<h2 class="description-product">{{ post.content }}</h2>
				<div class="price-contain-group">
					<div class="price-group">
						<div class="price">
							{% if post.simple_product.promotional_price|trim is empty %} 
							<div class="original-price">{{ post.simple_product.original_price }}</div>
							{% else %}
							<div class="original-price promotional-price">{{ post.simple_product.promotional_price }}</div>
							<div class="old-price">{{ post.simple_product.original_price }}</div>
							{% endif %}
						</div>
					</div>
				</div>
				<div class="size-contain-group">
					<p class="type-size">Size:</p>
					<div class="size-group">
						<div class="info">
							<div class="list-size">
							    {% for item in post.simple_product.size %}
								<p class="size-name {% if loop.first %}active{% endif %}">{{ item.label }}</p>
								{% endfor %}
							</div>
						</div>
					</div>
				</div>
				<div class="status">{{ post.simple_product.status.label }}</div>
				<button id="{{ post.ID }}" class="order-now">Order Now</button>
			</div>
		</div>
		 {% else %}
		 	<div class="page-layout grouped-product">
				<div class="gallery-side">
					{% for clone in post.variations_of_product %}
					<div class="group-image {% if loop.first %}active{% endif %}" data-id="{{ clone.color_name.value }}">
						<div class="slider slider-single">
							{% for item in clone.product_images %}
							<div class="img-slider">
								<img src="{{ item.large.url }}" width="{{ item.large.width }}" height="{{ item.large.height }}" alt="{{ item.large.alt }}"/>
							</div>
							{% endfor %}
						</div>
						<div class="slider slider-nav">
							{% for item in clone.product_images %}
							<div class="gallery-slide">
								<img src="{{ item.thumbnail.url }}" width="{{ item.thumbnail.width }}" height="{{ item.thumbnail.height }}" alt="{{ item.thumbnail.alt }}"/>
							</div>
							{% endfor %}
						</div>
					</div>
					{% endfor %}
				</div>
				<div class="info-detail-product">
					<h1 class="title-product">{{ post.title }}</h1>
					<h2 class="description-product">{{ post.content }}</h2>
					<div class="color-contain-group">
						<p class="type-color">Color:</p>
							<div class="color-group">
								{% for clone in post.variations_of_product %}
									<div class="color-name {% if loop.first %}active{% endif %}">
										<a href="#{{ clone.color_name.value }}" class="color {{ clone.color_name.value }}"  title="{{ clone.color_name.label }}">{{ clone.color_name.label }}</a>
									</div>
								{% endfor %}
							</div>	
					</div>
					<div class="price-contain-group">
						{% for clone in post.variations_of_product %}
						<div class="price-group {% if loop.first %}active{% endif %}" data-id="{{ clone.color_name.value }}">
							<div class="price">
							{% if clone.promotional_price|trim is empty %} 
								<div class="original-price">{{ clone.original_price }}</div>
								{% else %}
								<div class="promotional-price">{{ clone.promotional_price }}</div>
								<div class="original-price">{{ clone.original_price }}</div>
							{% endif %}
							</div>
						</div>
						{% endfor %}
						</div>
						<div class="size-contain-group">
							<p class="type-size">Size:</p>
							<div class="size-group">
								{% for clone in post.variations_of_product %}
								<div class="info {% if loop.first %}active{% endif %}" data-id="{{ clone.color_name.value }}">
									<div class="list-size">
										{% for item in clone.size %}
										<p class="size-name {% if loop.first %}active{% endif %}">{{ item.label }}</p>
										{% endfor %}
									</div>
								</div>
								{% endfor %}
							</div>
						</div>
						<div class="status-group">
							{% for clone in post.variations_of_product %}
							<div class="status {% if loop.first %}active{% endif %}" data-id="{{ clone.color_name.value }}">
								{{ clone.status.label }}
							</div>
							{% endfor %}
						</div>
						<a class="open-button order-now" href="javascript:void(0)"> Order Now</a>
				</div>
			</div>
			{% endif %}
</div>

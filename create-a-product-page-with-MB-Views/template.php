<div class="car-rental">
	<div class="col-left">
		<div class="slideshow-container">
			{% for item in post.gallery %}
				<div class="mySlides fade">
					<img src="{{ item.full.url }}" width="{{ item.full.width }}" height="{{ item.full.height }}" alt="{{ item.full.alt }}">
				</div>
			{% endfor %}
			<a class="prev" onclick="plusSlides(-1)">❮</a>
			<a class="next" onclick="plusSlides(1)">❯</a>

		</div>
	</div>
	<div class="col-right">
		<h1>{{ post.title }}</h1>
		<div class="post-content">{{ post.content }}</div>
		<p class="rental-price">${{ post.rental_price }}/day</p>
		<ul>
			<li>
			 	<div class="details">
					<h5>Car Year</h5>
					<span>{{ post.car_year }}</span>
				</div>
			</li>
			<li>
			 	<div class="details">
					<h5>Max Passengers</h5>
					<span>{{ post.max_passengers }}</span>
				</div>
			</li>
			<li>
			 	<div class="details">
					<h5>Fuel</h5>
					<span>{{ post.fuel.label }}</span>
				</div>
			</li>
			<li>
			 	<div class="details">
					<h5>Doors</h5>
					<span>{{ post.doors.label }}</span>
				</div>
			</li>
			<li>
			 	<div class="details">
					<h5>Fuel Usage</h5>
					<span>{{ post.fuel_usage }}</span>
				</div>
			</li>
			<li>
			 	<div class="details">
					<h5>Engine Capacity</h5>
					<span>{{ post.engine_capacity }}</span>
				</div>
			</li>
			<li>
			 	<div class="details">
					<h5>Mileage</h5>
					<span>{{ post.mileage }}</span>
				</div>
			</li>
			<li>
			 	<div class="details">
					<h5>Max Luggage</h5>
					<span>{{ post.max_luggage }}</span>
				</div>
			</li>
		</ul>
	</div>
</div>

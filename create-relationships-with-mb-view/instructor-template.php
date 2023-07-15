<div class="container instructor-template">
<h1>{{ post.title }}</h1>
<span>{{ post.content }}</span>
<div class="items">
{% set relationship = attribute( relationships, 'instructor-to-course' ) %}
{% for post in relationship.to %}
	<div class="item">
		<img src="{{ post.thumbnail.full.url }}" width="{{ post.thumbnail.full.width }}" height="{{ post.thumbnail.full.height }}" alt="{{ post.thumbnail.full.alt }}">
		<h5><a href="{{ post.url }}">{{ post.title }}</a></h5>
		<p><b>Type:</b> <span>{{ post.type.label }}</span></p>
		<p><b>Date:</b> <span> {{ post.start_date | date( 'd/m/Y' ) }} - {{ post.end_date | date( 'd/m/Y' ) }}</span></p>
		<p><b>Place:</b> <span> {{ post.place }}</span></p>
		<p><b>Price:</b> <span> {{ post.price }}</span></p>
	</div>
{% endfor %}
</div>
</div>

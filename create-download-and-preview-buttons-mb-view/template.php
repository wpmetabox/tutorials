<div class="e-book-container">
<div class="e-book-wrap">
 	<div class="e-book-list">
		{% set args = { post_type: 'e-book', posts_per_page: -1 } %}
			{% set posts = mb.get_posts( args ) %}
				{% for post in posts %}
					<div class="e-book-item">
						<img src="{{ post.thumbnail.full.url }}" width="{{ post.thumbnail.full.width }}" height="{{ post.thumbnail.full.height }}" alt="{{ post.thumbnail.full.alt }}">
						<a href="{{ post.url }}" class="e-book-title">{{ post.title }}</a>
						<div class="e-book-content">{{ post.content }}</div>
						{% for item in post.pdf_upload %}
							<a href="{{ item.url }}" class="btn-book btn-book-download"  download>Download</a>
						{% endfor %}
						{% for item in post.pdf_upload %}
							<a href="{{ item.url }}"  class="btn-book btn-book-view" >View more</a>
						{% endfor %}
					</div>
				{% endfor %}
	</div>
</div>
</div>	

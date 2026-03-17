<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<div class="post-grid">
{% for clone in user.mbfp_posts %}
	<div class="post-item" data-post-id="{{ clone.ID }}">
		{% if post.thumbnail %}
			<img src="{{ clone.thumbnail.full.url }}" width="{{ clone.thumbnail.full.width }}" height="{{ clone.thumbnail.full.height }}" alt="{{ clone.thumbnail.full.alt }}">
		{% endif %}
		<div class="post-title"><a href="{{ clone.url }}">{{ clone.title }}</a></div>
		<div class="post-date">{{ clone.date | date( 'd F Y' ) }}</div>
		<button class="remove-fav" title="Remove from favorites" aria-label="Remove from favorites">
			<svg viewBox="0 0 24 24" aria-hidden="true">
				<path d="M6 7h12l-1 12a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2L6 7zm10.5-3H15l-.71-1.06A1.99 1.99 0 0 0 12.59 2h-1.18c-.7 0-1.35.36-1.7.94L9 4H7.5A1.5 1.5 0 0 0 6 5.5V6h12v-.5A1.5 1.5 0 0 0 16.5 4zM10 9v9h2V9h-2zm4 0v9h2V9h-2zM8 9v9h2V9H8z"></path>
			</svg>
		</button>
		<div class="mbfp-hidden">[mbfp-posts]</div>
	</div>
{% else %}
	<p>You don't have any favorite posts yet.</p>
{% endfor %}
</div>

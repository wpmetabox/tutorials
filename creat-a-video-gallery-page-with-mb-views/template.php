<div class="container video-gallery">
<h1>{{ post.title }}</h1>
{% set args = { post_type: 'video', posts_per_page: 9 } %}
{% set posts = mb.get_posts( args ) %}
<div class="container-video-list">
{% for post in posts %}
	<div class="container-video">
		<div class="video">
			{{ post.video_oembed.rendered }}
			{% set author = mb.get_user( post.post_author ) %}
		</div>
		<div class="details">
			<div class="avatar">
				{{ mb.get_avatar( author.ID, 56 ) }}
			</div>
			<div class="detailed-info">
				<h2 class="title">{{ post.title }}</h2>
				<p class="author-name">{{ author.display_name }} </p>
				<span class="description">{{ post.content }}</span>
				<p>-- {{ post.date | date( 'd/m/Y' ) }}</p>
			</div>
		</div>
	</div>
{% endfor %}
</div>
</div>

<h1>
		Meet The Team
	</h1>
	<div class="team-member-container">
	{% set args = { post_type: 'team-member', posts_per_page: -1, orderby: 'date', order: 'ASC' } %}
	{% set posts = mb.get_posts( args ) %}
	{% for post in posts %}
	<div class="team-member-box">
		<div class="content-left">
			{{ mb.get_the_post_thumbnail( post.ID,'medium' ) }}
			<div class="icon-group">
				<a class="icon facebook" href="{{ post.facebook }}"><i class="fab fa-facebook"></i></a>
				<a class="icon instagram" href="{{ post.instagram }}"><i class="fab fa-instagram"></i></a>
				<a class="icon mail" href="{{ post.mail }}"><i class="fas fa-envelope"></i></a>
			</div>
		</div>
		<div class="content-right">
			<p class="name">
				{{ post.post_title }}
			</p>
			<p class="position">
				{{ mb.rwmb_the_value( 'position', '', post.ID, false ) }}
			</p>
			<div class="description">
				{{ post.post_content }}
			</div>
		</div>
	</div>
	{% endfor %} 
	</div>

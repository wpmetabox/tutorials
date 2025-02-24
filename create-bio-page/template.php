<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
<div class="mb-profile">
	<div class="mb-bio">
		<div class="mb-avatar">
			<img src="{{ site.bio_page.avatar.full.url }}" width="{{ site.bio_page.avatar.full.width }}" height="{{ site.bio_page.avatar.full.height }}" alt="{{ site.bio_page.avatar.full.alt }}">		
		</div>	
		<div class="bio-name">{{ site.bio_page.name }}</div>
		<div class="bio-address">{{ site.bio_page.address }}</div>	
		<div class="bio-description">{{ site.bio_page.description }}</div>

		<span class="button-readmore">Read more</span>
		<div class="contact">
			<button class="hover-shadow cursor">Contact</button> 
			<div class="mb-overlay"></div>
			<div id="myModal" class="modal">
			  	<span class="close cursor" >&times;</span>			    	
			    <div class="modal-content info-link">
			    	<div class="icon-link"><i class="fa fa-at"></i></div>
			    	<i class="fa fa-mail"></i><div class="mb-email">Email</div>
			    	<a class="link-mail" href="mailto:{{ site.bio_page.contact }}">{{ site.bio_page.contact }}</a>
			    </div>
			</div>
		</div>
	</div>

	<div class="mb-account">
		<h3>Verified Accounts</h3>
		{% for clone in site.bio_page.verified_accounts %}
		<div class="item-accounts">
			<div class="icon-accounts">{{ clone.icon }}</div>
			<div class="info-accounts">
				<div class="title-accounts">{{ clone.account_title }}</div>
				<div class="mb-url"><a href="{{ clone.account_url }}">{{ clone.account_url }}</a></div>
			</div>
		</div>
		{% endfor %}
	</div>

	<div class="mb-link">
		<h3>Links</h3>
		{% for clone in site.bio_page.links %}
			<div class="item-link">
				<div class="icon-link"><i class="fa fa-link"></i></div>
				<div class="info-link">
					<div class="title-link">{{ clone.title }}</div>
					<div class="mb-url"><a href="{{ clone.url }}">{{ clone.url }}</a></div>
				</div>
			</div>
		{% endfor %}
	</div>
	
</div>

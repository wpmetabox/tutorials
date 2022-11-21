<div class="faq-page">
	<h1>FAQs</h1>
	<div class="content-faq">
		<div class="tab-category">
			<ul>
			{% for clone in post.tabs %}
				<li><a href="#{{ clone.tab_name }}">{{ clone.tab_name }}</a></li>
			{% endfor %}
			</ul>
			
		</div>
		<div class="content-ul-cate">
		{% for clone in post.tabs %}
			<ul class="ul-cate" id="{{ clone.tab_name }}">
			{% for clone in clone.qanda %}
					<li class="content-group">
						<h3>{{ clone.question }}</h3>
						<p>{{ clone.answer }}</p>
					</li>
			{% endfor %}
			</ul>
		{% endfor %}
		</div>
	</div>
</div>

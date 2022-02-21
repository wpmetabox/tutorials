<div class="brand-group">
{% for clone in site.brands.brand_group %}
	<div class="brand-img">
	{% if clone.brand_logo_url|trim is empty %}
		<img src="{{ clone.brand_logo_upload.thumbnail.url }}" width="{{ clone.brand_logo_upload.thumbnail.width }}" height="{{ clone.brand_logo_upload.thumbnail.height }}" alt="{{ clone.brand_logo_upload.thumbnail.alt }}">
	{% elseif clone.brand_logo_upload.thumbnail.ID|trim is empty %}
		<img src="{{ clone.brand_logo_url }}">
	{% else %}
		<img src="{{ clone.brand_logo_upload.thumbnail.url }}" width="{{ clone.brand_logo_upload.thumbnail.width }}" height="{{ clone.brand_logo_upload.thumbnail.height }}" alt="{{ clone.brand_logo_upload.thumbnail.alt }}">
	{% endif %}
	<p class="name">
		{{ clone.brand_name }}
	</p>
	</div>
{% endfor %}
</div>

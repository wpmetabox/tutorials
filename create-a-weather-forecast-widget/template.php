{% set group = attribute( site, 'weather-forecast' ) %}
{% set weather_details = [] %}
{% for item in group.show_weather_details %}
	{% set weather_details = weather_details|merge([item.value]) %}
{% endfor %}
<div 
	id="weather-widget"
	class="weather-widget"
	data-location="{{ group.location }}"
	data-lat="{{ group.maps.latitude }}"
	data-lng="{{ group.maps.longitude }}"
	data-unit="{{ group.temperature_unit.value }}"
	data-lang="{{ group.language.value }}"
	data-layout="{{ group.layout_style.value }}"
	data-days="{{ group.forecast_days.value }}"
	data-details="{{ weather_details|join(',') }}">
	<div class="weather-loading">Loading weather...</div>
</div>

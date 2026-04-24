<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

{% set args = { post_type: 'garage', posts_per_page: -1 } %}
{% set posts = mb.get_posts(args) %}

<div class="garage-toolbar">
    <button id="locate-btn" type="button">📍 Get my location</button>
    <input type="number" id="filter-radius" placeholder="Radius (km)" min="5" step="1">
    <button id="filter-btn" type="button">Find nearby garages</button>
    <span id="result-info"></span>
</div>

<div class="garage-layout">
    <div class="garage-list" id="garage-list"></div>
    <div class="garage-map">
        <div id="map"></div>
    </div>
</div>

{% set garages = [] %}
{% for post in posts %}
    {% set garages = garages|merge([{
        id: post.ID,
        title: post.title,
        address: post.address,
        lat: post.garage_location.latitude,
        lng: post.garage_location.longitude,
        open_time: post.open_time ? post.open_time|date('H:i') : '',
        close_time: post.close_time ? post.close_time|date('H:i') : '',
        phone: post.phone
    }]) %}
{% endfor %}

<div id="garage-data"data-items='{{ garages|json_encode()|raw }}'></div>

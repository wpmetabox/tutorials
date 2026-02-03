
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

{% set args = { post_type: 'restaurant', posts_per_page: -1 } %}
{% set posts = mb.get_posts(args) %}
<div class="filter-wrapper">
    {% set ratings = [] %}
    {% for post in posts %}
        {% set rating_num = post.rating.value ?? '' %}
        {% if rating_num is not empty and rating_num not in ratings %}
            {% set ratings = ratings|merge([rating_num]) %}
        {% endif %}
    {% endfor %}
    {% set ratings = ratings|sort %}

    <select id="filter-rating">
        <option value="">- All Ratings -</option>
        {% for rate in ratings %}
            <option value="{{ rate }}">
                {% for i in 1..rate %}⭐{% endfor %}
            </option>
        {% endfor %}
    </select>

    {% set cuisines = [] %}
    {% for post in posts %}
        {% set type_val = post.cuisine_types.value ?? '' %}
        {% if type_val is iterable %}
            {% for cui in type_val %}
                {% if cui not in cuisines %}
                    {% set cuisines = cuisines|merge([cui]) %}
                {% endif %}
            {% endfor %}
        {% elseif type_val is not empty %}
            {% if type_val not in cuisines %}
                {% set cuisines = cuisines|merge([type_val]) %}
            {% endif %}
        {% endif %}
    {% endfor %}
    {% set cuisines = cuisines|sort %}

    <select id="filter-cuisine">
        <option value="">- All Cuisines -</option>
        {% for cuis in cuisines %}
            <option value="{{ cuis }}">{{ cuis }}</option>
        {% endfor %}
    </select>

    <div class="price-range">
        <span class="price-label">💰 Price:</span>
        <div class="price-control">
            <span class="price-min-label">Min</span>
            <input type="range" id="price-min" min="0" max="100" value="10">
        </div>
        <div class="price-control">
            <span class="price-max-label">Max</span>
            <input type="range" id="price-max" min="0" max="100" value="50">
        </div>
        <span id="price-display">10 - 50$</span>
    </div>

    <button id="locate-btn" type="button">📍 My Location</button>
    <input type="number" id="filter-radius" placeholder="Radius (km)" min="0" step="1">

    <button id="filter-btn" type="button">Search</button>
    <span id="filter-info"></span>
</div>

<div id="map"></div>
{% set restaurantsArray = [] %}

{% for post in posts %}
    {% set lat = post.location.latitude %}
    {% set lng = post.location.longitude %}
    {% set rating_num = post.rating.value %}
    {% set cuisine = post.cuisine_types.value %}
    {% set price = post.price %}
    {% set address = post.address %}

    {% set restaurantsArray = restaurantsArray|merge([{
        'id': post.ID,
        'title': post.title,
        'lat': lat,
        'lng': lng,
        'rating_num': rating_num,
        'cuisine': cuisine,
        'price': price,
        'address': address
    }]) %}
{% endfor %}

<div id="restaurants-data" data-items='{{ restaurantsArray|json_encode()|raw }}' style="display:none;"></div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
{% set total_stops = post.schedule|length %}
{% set nights = total_stops - 1 %}
<div class="tour-single">
    <div class="tour-header">
        <img src="{{ post.thumbnail.full.url }}" width="{{ post.thumbnail.full.width }}" height="{{ post.thumbnail.full.height }}" alt="{{ post.thumbnail.full.alt }}">
    </div>
    <div class="tour-info">
        <div class="tour-excerpt">{{ post.content }}</div>
        <div class="tour-info-bottom">
            <span class="tour-duration">
                <i class="ti ti-clock" aria-hidden="true"></i>
                {{ total_stops }} Days {{ nights }} Nights
            </span>
            <div class="tour-price">
                <span class="price-amount">${{ post.price|number_format(0, '.', ',') }}</span>
            </div>
        </div>
    </div>
    <div class="day-tabs">
        <button class="day-tab active" data-day="all">All</button>
        {% for clone in post.schedule %}
            <button class="day-tab" data-day="{{ loop.index }}">Day {{ loop.index }}</button>
        {% endfor %}
    </div>
    <div class="tour-body">
        <div class="tour-map-wrap">
            <div id="tour-map"></div>
        </div>
        <div class="tour-sidebar" id="tour-sidebar">
            {% for clone in post.schedule %}
                <div class="stop-card"
                    data-index="{{ loop.index0 }}"
                    data-day="{{ loop.index }}"
                    data-lat="{{ clone.map.latitude }}"
                    data-lng="{{ clone.map.longitude }}">
                     <div class="stop-card-top">
                        <div class="stop-thumb">
                            <img src="{{ clone.image.full.url }}" width="{{ clone.image.full.width }}" height="{{ clone.image.full.height }}" alt="{{ clone.image.full.alt }}">
                            <span class="stop-index">{{ loop.index }}</span>
                        </div>
                        <div class="stop-info">
                            <span class="stop-day">Day {{ loop.index }}</span>
                            <h3 class="stop-name">{{ clone.address }}</h3>
                        </div>
                    </div>
                    <div class="stop-desc">{{ clone.description }}</div>
                </div>
            {% endfor %}
        </div>
    </div>
</div>

<script>
window.tourStops = [
    {% for clone in post.schedule %}
    {
        index: {{ loop.index }},
        day: {{ loop.index }},
        name: "{{ clone.address }}",
        desc: "{{ clone.description|e('js') }}",
        lat: {{ clone.map.latitude }},
        lng: {{ clone.map.longitude }},
        image: "{{ clone.image.full.url }}"
    }{% if not loop.last %},{% endif %}
    {% endfor %}
];
</script>

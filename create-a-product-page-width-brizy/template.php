<div class="car-gallery">
    {% for item in post.car_gallery %}
        <img src="{{ item.full.url }}" width="{{ item.full.width }}" height="{{ item.full.height }}" alt="{{ item.full.alt }}">
    {% endfor %}
</div>

{% set args = {  post_type: 'tour',  posts_per_page: -1,  orderby: 'date', order: 'DESC'} %}
{% set posts = mb.get_posts(args) %}

{% set trending_posts = [] %}
{% set normal_posts = [] %}

{% for post in posts %}
    {% if post.the_trend_of_month == '1' %}
        {% set trending_posts = trending_posts | merge([post]) %}
    {% else %}
        {% set normal_posts = normal_posts | merge([post]) %}
    {% endif %}
{% endfor %}

{% set top_trending = trending_posts[:3] %}
{% set remaining_trending = trending_posts[3:] %}

{% set normal_posts = remaining_trending | merge(normal_posts) %}

<div class="restaurant-wrapper">
    <div class="featured-top-row columns-{{ top_trending|length }}">
        {% if top_trending|length > 0 %}
            {% for post in top_trending %}
                <div class="featured-large-card">
                    <a class="thumb" href="{{ post.link }}">
                        <img src="{{ post.thumbnail.full.url }}" alt="{{ post.thumbnail.full.alt }}" loading="lazy">
                    </a>
                    <div class="info">
                        <span class="badge">Hot Trend</span>
                        <h3 class="title"><a href="{{ post.url }}">{{ post.title }}</a></h3>
                        <div class="tour-meta">
                            <span class="duration">{{ post.duration.value }}</span>
                            <span class="price">{{ post.price }}$</span>
                        </div>
                       
                    </div>
                </div>
            {% endfor %}           
        {% endif %}
    </div>

    <div class="below-grid">
        {% for post in normal_posts %}
            <div class="card-grid-item">
                <a class="thumb" href="{{ post.link }}">
                    <img src="{{ post.thumbnail.full.url }}" alt="{{ post.thumbnail.full.alt }}" loading="lazy">
                </a>
                <div class="info">                    
                    <h4 class="title"><a href="{{ post.url }}">{{ post.title }}</a></h4>
                    <div class="tour-meta">
                        <span class="duration">{{ post.duration.value }}</span>
                        <span class="price">{{ post.price }}$</span>
                    </div>
                </div>
            </div>
        {% endfor %}
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>

{% set today = "now"|date("Y-m-d") %}

<div class="project-filter">
    <button class="filter-btn is-active" data-filter="*">All</button>
    <button class="filter-btn" data-filter=".past">Past</button>
    <button class="filter-btn" data-filter=".ongoing">Ongoing</button>
    <button class="filter-btn" data-filter=".pending">Pending</button>
</div>

<div class="project-grid">
{% set posts = mb.get_posts({ post_type: 'project', posts_per_page: -1, orderby: 'date', order: 'DESC'}) %}
{% for post in posts %}

    {% set start = post.start_date|date('Y-m-d') %}
    {% set end   = post.end_date|date('Y-m-d') %}
    {% if end < today %}
        {% set status = 'past' %}
    {% elseif start > today %}
        {% set status = 'pending' %}
    {% else %}
        {% set status = 'ongoing' %}
    {% endif %}

    {% set type_value = post.type.value|lower %}
    <div class="project-item {{ status }} type-{{ type_value }}">
        <div class="project-card">
            <div class="project-thumb">
                <img src="{{ post.thumbnail.full.url }}" width="{{ post.thumbnail.full.width }}" height="{{ post.thumbnail.full.height }}" alt="{{ post.thumbnail.full.alt }}">
            </div>
            <div class="project-body">
                <h3 class="project-title">{{ post.title }}</h3>
                <div class="project-date">
                    {{ post.start_date | date( 'd F Y' ) }} - {{ post.end_date | date( 'd F Y' ) }}
                </div>
                <div class="project-type-badge">
                    {{ post.type.value|lower }}
                </div>
            </div>
        </div>
    </div>
{% endfor %}
</div>

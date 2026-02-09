<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://npmcdn.com/isotope-layout@3.0.6/dist/isotope.pkgd.js"></script>

{% set args = { post_type: 'service', posts_per_page: -1, orderby: 'date', order: 'DESC'} %}
{% set posts = mb.get_posts(args) %}

<div class="service-filters">
    <div class="service-filter service-type-filter">
        <button class="filter-btn active" data-filter="*" data-group="type">All Services</button>
        {% set service_types = mb.get_terms({
            taxonomy: 'service-type',
            hide_empty: true
        }) %}
        {% for term in service_types %}
            <button
                class="filter-btn"
                data-filter=".{{ term.slug }}"
                data-group="type">
                {{ term.name }}
            </button>
        {% endfor %}
    </div>

    <div class="service-filter service-plan-filter">
        <button class="filter-btn active" data-filter="*" data-group="plan">All Plans</button>
        {% set plans = [] %}
        {% for post in posts %}
            {% if post.treatment_plan.label not in plans %}
                {% set plans = plans|merge([post.treatment_plan.label]) %}
            {% endif %}
        {% endfor %}
        {% set plans = plans|sort((a, b) => a <=> b) %}
        {% for plan in plans %}
            {% set plan_class = 'plan_' ~ plan|lower|replace({' ': '_'}) %}
            <button
                class="filter-btn"
                data-filter=".{{ plan_class }}"
                data-group="plan">
                {{ plan }}
            </button>
        {% endfor %}
    </div>
</div>

<div class="services-grid">
{% for post in posts %}
    {% set post_terms = mb.get_the_terms(post.ID, 'service-type') %}
    {% set term_classes = [] %}
    {% if post_terms %}
        {% for term in post_terms %}
            {% set term_classes = term_classes|merge([term.slug]) %}
        {% endfor %}
    {% endif %}
    {% set plan_class = 'plan_' ~ post.treatment_plan.label|lower|replace({' ': '_'}) %}
    <div class="service-item {{ term_classes|join(' ') }} {{ plan_class }}">
        <div>
            <div class="service-thumb">
                <img src="{{ post.thumbnail.full.url }}" alt="{{ post.title }}">
            </div>
            <div class="service-body">
                <h3 class="service-title">
                    <a href="{{ post.url }}">{{ post.title }}</a>
                </h3>
                <div class="service-meta">
                    <div class="service-price">$ {{ post.price }}</div>
                    <div class="service-plan">Treatment Plan: {{ post.treatment_plan.label }}</div>
                    <div class="service-duration">⏱ {{ post.duration }} mins</div>
                </div>
            </div>
        </div>
    </div>
{% endfor %}
</div>

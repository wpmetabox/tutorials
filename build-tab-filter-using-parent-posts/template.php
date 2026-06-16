<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
{% set posts  = mb.get_posts({ post_type: 'class', posts_per_page: -1, orderby: 'menu_order', order: 'ASC'}) %}
{% set parents = [] %}
{% for post in posts %}
    {% if post.post_parent == 0 %}
        {% set parents = parents|merge([post]) %}
    {% endif %}
{% endfor %}

<div class="class-tabs">
    <div class="tab-nav">
        {% for parent in parents %}
            <button class="tab-btn {% if loop.first %}active{% endif %}" data-tab="tab-{{ parent.ID }}">
                {{ parent.title }}
            </button>
        {% endfor %}
    </div>
    <div class="tab-content-wrapper"> 
        {% for parent in parents %}
            <div class="tab-content {% if loop.first %}active{% endif %}" id="tab-{{ parent.ID }}">
                <div class="class-grid">
                    {% for post in posts %}
                        {% if post.post_parent == parent.ID %}
                            <div class="class-card">
                                <div class="class-thumb">
                                    <img src="{{ post.thumbnail.full.url }}" width="{{ post.thumbnail.full.width }}" height="{{ post.thumbnail.full.height }}" alt="{{ post.thumbnail.full.alt }}">
                                </div>
                                <div class="class-content">
                                    <h3 class="class-title">{{ post.title }}</h3>
                                    <div class="class-meta">
                                        <div class="meta-item">
                                            <span class="meta-label">Trainer:</span>
                                            <span class="meta-value">{{ post.trainer.value }}</span>
                                        </div>
                                        <div class="meta-item">
                                            <span class="meta-label">Duration:</span>
                                            <span class="meta-value">{{ post.duration }} mins</span>
                                        </div>
                                        <div class="meta-item">
                                            <span class="meta-label">Burn:</span>
                                            <span class="meta-value">{{ post.calories_burn }} kcal</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {% endif %}
                    {% endfor %}
                </div>
            </div>
        {% endfor %}
    </div>
</div>

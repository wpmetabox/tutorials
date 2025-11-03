<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<div class="mb-header"><h1>Hotels</h1></div>

<div class="mb-container">
    <div class="hotel-filter">
        <label class="hotel-label" for="location">Search Hotel:</label>
        <div class="hotel-input-wrap">
            <input type="text" id="location" placeholder="Enter location..." />
            <ul id="suggestions" class="suggestions" style="display: none;"></ul>
            <button class="filter-action">Search</button>
        </div>
    </div>
    
    <div class="hotel-results">
    {% set args = { post_type: 'hotel', posts_per_page: -1, orderby: 'date', order: 'ASC' } %}
    {% set posts = mb.get_posts( args ) %}
        <div class="hotel-grid">
            {% for post in posts %}
                {% set post_terms = mb.get_the_terms( post.ID, 'location' ) %}

                {% set term_names = [] %}
                {% if post_terms %}
                    {% for term in post_terms %}
                        {% set term_names = term_names|merge( [ term.name|lower ] ) %}
                    {% endfor %}
                {% endif %}

                <div class="hotel-item" data-location="{{ term_names|join( '||' ) }}">
                    <a class="thumb-wrap" href="{{ post.url }}">
                        <img src="{{ post.thumbnail.full.url }}" width="{{ post.thumbnail.full.width }}" height="{{ post.thumbnail.full.height }}" alt="{{ post.thumbnail.full.alt }}">
                    </a>
                    <div class="mb-content">
                        <div class="title"><a href="{{ post.url }}">{{ post.title }}</a></div>
                        <div class="location-names">
                            {% if post_terms %}
                                {% for term in post_terms %}
                                    <span class="location">{{ term.name }} </span>{% if not loop.last %},     {% endif %}
                                {% endfor %}
                            {% endif %}
                        </div>
                    </div>
                </div>        
            {% endfor %}
        </div>
    </div>
</div>

<ul id="location-data" style="display: none;">
    {% for term in mb.get_terms( { taxonomy: 'location', hide_empty: false } ) %}
        <li data-id="{{ term.term_id }}">{{ term.name }}</li>
    {% endfor %}
</ul>

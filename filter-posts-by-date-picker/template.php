<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<div class="filters">
    <div class="filter-inputs">
        <label>From Date: <input type="date" id="from-date"></label>
        <label>To Date: <input type="date" id="to-date"></label>
        <label class="specific-date">Specific Date: <input type="date" id="specific-date"></label>
    </div>
    <button id="clear-filters" type="button">Clear All Filters</button>
</div>

<div class="movie-list">
    {% set args = { post_type: 'movie', posts_per_page: -1, orderby: 'date', order: 'ASC' } %}
    {% set posts = mb.get_posts( args ) %}

    {% for post in posts %}
    <div class="movie-item" data-date="{{ post.movie_schedule.date | date( 'Y-m-d' ) }}">
        <div class="movie-thumb">
            <img src="{{ post.thumbnail.full.url }}" width="{{ post.thumbnail.full.width }}" height="{{ post.thumbnail.full.height }}" alt="{{ post.thumbnail.full.alt }}">
        </div>
        <div class="movie-content">
            <div class="genres">
                {% for item in post.genres %}
                    <span class="genre">{{ item.value }} </span>
                {% endfor %}
            </div>
            <div class="movie-title"><a href="{{ post.url }}">{{ post.title }}</a></div>
            <div class="movie-date">Show Date: {{ post.movie_schedule.date | date( 'm/d/Y' ) }}</div>
            <div class="showtimes">
                {% for clone in post.movie_schedule.time %}
                    <span class="showtime">{{ clone | date( 'H:i' ) }} </span>
                {% endfor %}
            </div>
        </div>
    </div>
    {% endfor %}
</div>

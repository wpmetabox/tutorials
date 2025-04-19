<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
{% set args = { post_type: site.archive.post_type, posts_per_page: -1 } %}
{% set posts = mb.get_posts( args ) %}
<div class="mb-container">
    <div class="mb-row">
        {% for post in posts %}
        <div class="mb-coloumn coloumn-{{ site.archive.column.value }}">
            <div class="mb-content">
                <div class="item">
                    <img src="{{ post.thumbnail.full.url }}" width="{{ post.thumbnail.full.width }}" height="{{ post.thumbnail.full.height }}" alt="{{ post.thumbnail.full.alt }}">
                    <h3>{{ post.title }} </h3>
                    <div>{{ post.content }}</div>
                </div>
            </div>
        </div>
        {% endfor %}
    </div>
    <a href="" data-first="{{ site.archive.item_first }}" data-loadmore="{{ site.archive.item_load_more }}" id="load-more">Load More</a>
</div>

<div class="listing">
{% set args = { post_type: 'restaurant', posts_per_page: 6, orderby: 'post_views', order: 'DESC' } %}
{% set posts = mb.get_posts( args ) %}
{% for post in posts %}
    <div class="contain-restaurant viewed">
        <div class="cover-image-res">
            <img src="{{ post.thumbnail.large.url }}" width="{{ post.thumbnail.large.width }}" height="{{ post.thumbnail.large.height }}" alt="{{ post.thumbnail.large.alt }}">
            <div class="voucher-res">
                <span> {{ post.voucher.label }}</span>
            </div>
            <div class="logo">
               <img src="{{ post.logo.thumbnail.url }}" width="{{ post.logo.thumbnail.width }}" height="{{ post.logo.thumbnail.height }}" alt="{{ post.logo.thumbnail.alt }}">
            </div>
        </div>
        <a class="name-res" href="{{ mb.get_permalink( post.ID ) }}"> {{ post.post_title }}</a>
        <div class="address-res">{{ post.address }}</div>
        <div class="cover-link">
            <a class="href-res" href="{{ mb.get_permalink( post.ID ) }}"> View Detail</a>
        </div>
    </div>
{% endfor %}
</div>

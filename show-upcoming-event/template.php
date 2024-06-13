<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<div class="mb-container">
    <h1 id="mb_header" class="md_headline">Upcoming Events</h1>
    {% set args = { post_type: 'event', posts_per_page: -1 } %}
    {% set posts = mb.get_posts( args ) %}
    <div class="mb-dynamic-list"> 
        {% for post in posts %}
            {% if post.end_date  >=  mb.date('Y-m-d') %}
                <div class="mb-block"> 
                    <img src="{{ post.thumbnail.large.url }}" width="{{ post.thumbnail.large.width }}" height="{{ post.thumbnail.large.height }}" alt="{{ post.thumbnail.large.alt }}">
                    <div class="mb_content">
                        <div class="mb_title">{{ post.title }} </div>
                        <div class="mb_startdate">
                            <i class="fa fa-calendar"></i>
                            Start: {{ post.start_date | date( 'Y-m-d' ) }}
                        </div>
                        <div class="mb_enddate">
                            <i class="fa fa-calendar"></i>
                            End: {{ post.end_date | date( 'Y-m-d' ) }} 
                        </div>
                        <div class="mb_location">
                            <i class="fa fa-location-arrow"></i>
                            {{ post.location }} 
                        </div>
                    </div>
                </div>
            {% endif %}        
        {% endfor %} 
    </div>
</div>

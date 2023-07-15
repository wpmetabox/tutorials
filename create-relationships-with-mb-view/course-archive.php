<div class="course-archive container">
    <h1>{{ post.title }}</h1>
    <div class="course-inner">
        <div class="course-items">
            {% set args = { post_type: 'course', posts_per_page: -1, order: 'DESC'} %}
            {% set posts = mb.get_posts( args ) %}
            {% for post in posts %}
                <div class="course-item">
                    <img src="{{ post.thumbnail.full.url }}" width="{{ post.thumbnail.full.width }}" height="{{ post.thumbnail.full.height }}" alt="{{ post.thumbnail.full.alt }}">
                    <h5>{{ post.title }}</h5>
                    <p>{{ mb.wp_trim_words( post.content, 10) }}</p>
                    <p><b>Type:</b> <span>{{ post.type.label }}</span></p>
                    <p><b>Date:</b> <span> {{ post.start_date | date( 'd/m/Y' ) }} - {{ post.end_date | date( 'd/m/Y' ) }}</span></p>
                    <p><b>Place:</b> <span> {{ post.place }}</span></p>
                    <p><b>Price:</b> <span> {{ post.price }}</span></p>
                    <p><b>Instructor:</b> <span>
                
                        [instructor_list courseid={{ post.ID }}]
                      
                    </span></p>
                </div>
            {% endfor %}
        </div>
    </div>
</div> 


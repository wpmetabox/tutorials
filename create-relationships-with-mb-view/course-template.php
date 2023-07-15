<div class="course-template container">
    <div class="course-inner">
        <div class="course-item">
            <img src="{{ post.thumbnail.full.url }}" width="{{ post.thumbnail.full.width }}" height="{{ post.thumbnail.full.height }}" alt="{{ post.thumbnail.full.alt }}">
            <h5>{{ post.title }}</h5>
            <p>{{ post.content }}</p>
            <p><b>Type:</b> <span>{{ post.type.label }}</span></p>
            <p><b>Date:</b> <span> {{ post.start_date | date( 'd/m/Y' ) }} - {{ post.end_date | date( 'd/m/Y' ) }}</span></p>
            <p><b>Place:</b> <span> {{ post.place }}</span></p>
            <p><b>Price:</b> <span> {{ post.price }}</span></p>
            <p><b>Instructor:</b> <span>
            {% set relationship = attribute( relationships, 'instructor-to-course' ) %}
            {% for post in relationship.from %}
                {{ post.title }}
            {% endfor %}
            </span>
            </p>
        </div>
    </div>
</div>

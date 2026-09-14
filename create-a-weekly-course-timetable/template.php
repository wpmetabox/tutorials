<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
{% set courses = mb.get_posts({ post_type: 'course', posts_per_page: -1, orderby: 'title', order: 'ASC'}) %}
{% set course_data = [] %}
{% set teacher_map = {} %}
{% for post in courses %}
    {% set teacher_slugs = [] %}
    {% set teachers = mb.get_the_terms(post.ID, 'teacher') %}
    {% if teachers %}
        {% for t in teachers %}
            {% set teacher_slugs = teacher_slugs|merge([t.slug]) %}
            {% set teacher_map   = teacher_map|merge({ (t.slug): t.name }) %}
        {% endfor %}
    {% endif %}
    {% set course_data = course_data|merge([{
        id:          post.ID,
        title:       post.post_title,
        description: post.content|striptags|slice(0, 120),
        day:         post.course_day,
        start:       post.start_time,
        end:         post.end_time,
        color:       post.course_color,
        room:        post.classroom.value,
        teachers:    teacher_slugs
    }]) %}
{% endfor %}
<div id="mb-course-schedule"
    data-courses='{{ course_data|json_encode() }}'
    data-teachers='{{ teacher_map|json_encode() }}'>
</div>

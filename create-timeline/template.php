<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
{% for clone in post.timeline %}
    <div class="timeline">
        <div class="timeline-date">{{ clone.date_timeline | date( 'F j, Y' ) }}</div>
        <div class="timeline-content">
            <div class="timeline-post"> {{ clone.post_timeline.content }}</div>
            <div class="dot"></div>
            <span class="timeline-readmore">Read more</span>
        </div>
    </div>
{% endfor %}

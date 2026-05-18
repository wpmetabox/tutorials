<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

{% set weekday_order = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] %}
{% set used_days = [] %}

{% for clone in post.schedules %}
    {% for item in clone.workday %}
        {% if item.value not in used_days %}
            {% set used_days = used_days|merge([ item.value ]) %}
        {% endif %}
    {% endfor %}
{% endfor %}

{% set sorted_days = [] %}
{% for w in weekday_order %}
    {% if w in used_days %}
        {% set sorted_days = sorted_days|merge([ w ]) %}
    {% endif %}
{% endfor %}

<div class="doctor-filter">
    <label>Workday:</label>
    <select id="filter-day">
        <option value="">-- All --</option>
        {% for day in sorted_days %}
            <option value="{{ day }}">{{ day }}</option>
        {% endfor %}
    </select>
</div>

<div class="doctor-list">
    {% for clone in post.schedules %}
        {% set id = clone.doctor.ID %}
        {% set avatar = clone.doctor.thumbnail.full.url %}
        {% set phone = mb.get_post_field('phone_number', id) %}
        {% set email = mb.get_post_field('email_address', id) %}
        {% set academic = mb.get_post_field('academic', id) %}

        {% set days = [] %}
        {% for item in clone.workday %}
            {% set days = days|merge([ item.value ]) %}
        {% endfor %}
        <div class="doctor-card" data-days="{{ days|join(',')|lower }}">
            <div class="doctor-info">
                <h3 class="doctor-name">{{ clone.doctor.title }}</h3>
                <div><span class="icon">📞</span> {{ phone }}</div>
                <div><span class="icon">📧</span> {{ email }}</div>
                <div><span class="icon">🎓</span> {{ academic.value ?? academic }}</div>
                <div>
                    <span class="icon">📅</span>
                    {% for day in days %}
                        {{ day }}{% if not loop.last %}, {% endif %}
                    {% endfor %}
                </div>
            </div>
            <div class="doctor-avatar">
                <img src="{{ avatar }}" alt="{{ clone.doctor.title }}">
            </div>
        </div>
    {% endfor %}
</div>

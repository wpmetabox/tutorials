{% set members = [] %}
{% for clone in post.teacher_group %}
    {% set members = members|merge([{
        'name': clone.name,
        'subject': clone.subject.label,
        'photo': clone.photo.full.url,
        'photo_alt': clone.photo.full.alt
    }]) %}
{% endfor %}

{% set grouped = {} %}
{% for member in members %}
    {% set subj = member.subject ?? 'Other' %}
    {% if grouped[subj] is not defined %}
        {% set grouped = grouped|merge({ (subj): [member] }) %}
    {% else %}
        {% set grouped = grouped|merge({ (subj): grouped[subj]|merge([member]) }) %}
    {% endif %}
{% endfor %}

<div class="teacher-wrapper">
    {% for subj, items in grouped %}
    <div class="subject-block">
        <h3 class="subject-heading">{{ subj }}</h3>
        <div class="teacher-grid">
            {% for item in items %}
                <div class="teacher-card">
                    {% if item.photo %}
                        <div class="teacher-thumb">
                            <img src="{{ item.photo }}" alt="{{ item.photo_alt }}">
                        </div>
                    {% endif %}
                    <div class="teacher-info">
                        <h4 class="teacher-name">{{ item.name }}</h4>
                        <p class="teacher-subject">{{ item.subject }}</p>
                    </div>
                </div>
            {% endfor %}
        </div>
    </div>
    {% endfor %}
</div>

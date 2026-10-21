{% set vote    = site.votes %}
{% set options = vote.options|sort((a, b) => b.votes <=> a.votes) %}
{% set total   = options|map(o => o.votes)|reduce((carry, v) => carry + v, 0) %}

<div class="poll" data-ajax="/wp-admin/admin-ajax.php">
    <h2 class="poll-question">{{ vote.question }}</h2>
    <div class="poll-total">
        Total Votes: <span class="poll-total-value">{{ total }}</span>
    </div>
    <div class="poll-options">
        {% for option in options %}
            {% set percent = total ? (option.votes / total * 100)|round(1) : 0 %}
            <div class="poll-option {{ loop.first ? 'is-winner' }}" data-option="{{ option.label }}">
                <button class="poll-button" type="button">
                    <div class="poll-progress" style="width:{{ percent }}%"></div>
                    <div class="poll-content">
                        <span class="poll-label">{{ option.label }}</span>
                        <span class="poll-percent">{{ percent }}%</span>
                        <span class="poll-votes">{{ option.votes }}</span>
                    </div>
                </button>
            </div>
        {% endfor %}
    </div>
</div>

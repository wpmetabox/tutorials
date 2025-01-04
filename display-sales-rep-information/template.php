{% if mb.is_user_logged_in %}
    {% set salesrep_related = { relationship: { id: 'salesrep-to-user', to: user.ID }, nopaging: true, post_type: 'salesrep' } %}
    {% set salesreps = mb.get_posts(salesrep_related) %}

    {% for salesrep in salesreps %}
    <div class="mb-container"> 
        <div class="mb-content">
            <div class="mb-your-sale">Your Sales Representative</div>
            <div class="mb-title-sale">{{  salesrep.post_title }}</div>
            <img src="{{ mb.get_the_post_thumbnail_url(salesrep.ID) }}" alt="{{  salesrep.post_title }}" />
            <div class="mb-phone"><b>Phone Number</b>: {{  salesrep.phone }}</div>
            <div class="mb-email"><b>Email</b>: {{  salesrep.email }}</div>
            <div class="mb-experience"><b>Years of experience</b>: {{  salesrep.years_of_experience }}</div>
            <div class="mb-language"><b>Language</b>: {{  salesrep.language.label }}</div>       
            <div class="mb-motto"><b>Working Motto</b>: {{  salesrep.working_motto }}</div>
        </div>
    </div>
    {% endfor %}

{% endif %}

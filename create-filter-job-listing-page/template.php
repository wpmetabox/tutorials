<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://npmcdn.com/isotope-layout@3.0.6/dist/isotope.pkgd.js"></script>

{% set args = { post_type: 'job', posts_per_page: -1, orderby: 'date', order: 'ASC' } %}
{% set posts = mb.get_posts(args) %}

<div class="mb-filter">
	<div id="filter-search">
		<h4>Search Job</h4>
		<div id="job-search-filter"><input type="text" id="quicksearch" placeholder="Search" /></div>
	</div>

	<div id="job-type-filters" class="button-group">
		<h4>Filter by Job Type</h4>
		{% set job_types = [] %}
		{% for post in posts %}
		{% if post.job_type.label not in job_types %}
		{% set job_types = job_types|merge([post.job_type.label]) %}
		{% endif %}
		{% endfor %}
		<button class="button is-checked" data-filter="*">Show All</button>
		{% for job_type in job_types %}
		<button class="button" data-filter=".{{ job_type|replace({' ': '_'}) }}">{{ job_type }}</button>
		{% endfor %}
	</div>

	<div id="technical-skills-filter">
		<h4>Filter by Technical Skills</h4>
		{% set all_skills = [] %}
		{% for post in posts %}
		{% for skill in post.technical_skills %}
		{% if skill.label not in all_skills %}
		{% set all_skills = all_skills|merge([skill.label]) %}
		{% endif %}
		{% endfor %}
		{% endfor %}
		{% for skill in all_skills %}
		<label>
			<input type="checkbox" class="technical-skill-checkbox" value="{{ skill|replace({' ': '_'}) }}">
			{{ skill }}
		</label><br>
		{% endfor %}
	</div>

	<div id="experience-level-filter">
		<h4>Filter by Experience Level</h4>
		<select id="experience-level-select">
			<option value="*">Show All</option>
			{% set experience_levels = [] %}
			{% for post in posts %}
			{% if post.experience_level.label not in experience_levels %}
			{% set experience_levels = experience_levels|merge([post.experience_level.label]) %}
			{% endif %}
			{% endfor %}
			{% for level in experience_levels %}
			<option value=".{{ level|replace({' ': '_'}) }}">{{ level }}</option>
			{% endfor %}
		</select>
	</div>
</div>

<div class="mb-container">
	{% for post in posts %}
	{% set job_type_class = post.job_type.label|replace({' ': '_'}) %}
	{% set skill_classes = post.technical_skills|map(skill => skill.label|replace({' ': '_'}))|join(' ') %}
	{% set experience_level_class = post.experience_level.label|replace({' ': '_'}) %}
	<div class="mb-item {{ job_type_class }} {{ skill_classes }} {{ experience_level_class }}">
		<h3><a href="{{ post.url }}">{{ post.title }}</a></h3>
		<div><b>Location:</b> {{ post.location }}</div>
		<div><b>Company Name:</b> {{ post.company_name }}</div>
		<div><b>Type:</b> {{ post.job_type.label }}{% if post.job_type.label == 'Part-time' %} -
			{{ post.working_time.label }} {% endif %}</div>
		<div><b>Email:</b> {{ post.email }}</div>
		<div><b>Phone:</b> {{ post.phone }}</div>
		<div><b>Website:</b> <a href="{{ post.website }}">{{ post.website }}</a></div>
		<div><b>Skills:</b> {{ post.technical_skills|map(skill => skill.label)|join(', ') }}</div>
		<div><b>Experience:</b> {{ post.experience_level.label }}</div>
	</div>
	{% endfor %}
</div>
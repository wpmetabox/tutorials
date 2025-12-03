<h1>{{ post.title }}</h1>
<ul class="service-list">
  {% set sorted_services = post.services|sort((a, b) => a.price <=> b.price) %}
  {% for clone in sorted_services %}
    <li>
      <span class="service-name">{{ clone.service_name }}</span>
      <span class="separator"></span>
      <span class="service-price">${{ clone.price }}</span>
    </li>
  {% endfor %}
</ul>

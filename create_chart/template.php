<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
{% set type = post.type.value %}
{% set title = mb.explode(' ',post.chart_title) %}
{% set key = [] %}
{% set value = [] %}
{% set color = [] %}
{% set line_color = post.line_color %}

{% for clone in post.categories %}
    {% set key = key|merge([clone.key_x]) %}
    {% set value = value|merge([clone.value_y]) %}
    {% set color = color|merge([clone.color]) %}  
{% endfor %}

<canvas id="myChart" 
data-type='{{type}}'
data-title='{{title|json_encode()}}'
data-line-color='{{line_color}}'
data-color='{{color|json_encode()}}'
data-key='{{key|json_encode()}}'
data-value='{{value|json_encode()}}'

style="width:100%;max-width:600px">
</canvas>

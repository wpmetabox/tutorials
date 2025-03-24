<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<div class="mb-pricing-container">
    <div class="mb-content">
    {% for clone in post.plans %}
        <div class="mb-item">
            <div class="mb-title">{{ clone.title }}</div>
            <div class="mb-price">${{ clone.price }}/Year</div>
            <div class="mb-description">{{ clone.description }}</div>
            <div class="mb-features">
            {% for clone in clone.features %}
                <div class="item-feature">
                    <i class="fa fa-check-circle "></i>
                    {{ clone.item }}
                </div>
            {% endfor %}
            </div>
            <div class="mb-button">
                <a href="{{ clone.button_url }}">{{ clone.button }}</a>
            </div>
        </div>
    {% endfor %}
    </div>
</div>

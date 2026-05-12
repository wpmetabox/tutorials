<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="product-toolbar">
    <label>
        Sale %:
        <input type="range" id="saleRange" min="0" max="100" value="0">
        <span id="saleValue">0%</span>
    </label>
    <button id="orderSaleBtn">Order sale % ↓</button>
    <button id="orderPriceBtn">Order price ↑</button>
    <button id="resetFilterBtn">Reset filter</button>
</div>
<div class="product-grid" id="productGrid">
{% for clone in post.sale_products %}
    {% set product = clone.product[0] ?? null %}
    {% set price = mb.get_post_meta(product.ID, 'price', true) %}
    {% set sale_percent = clone.sale_percent %}
    {% set sale_price = price * (100 - sale_percent) / 100 %}

    {% set sale_end_ts = 0 %}
    {% if clone.sale_end_type.value == 'hot' %}
        {% set sale_end_ts = "today 12:00"|date('U') %}
    {% elseif clone.sale_end_type.value == 'afternoon' %}
        {% set sale_end_ts = "today 18:00"|date('U') %}
    {% elseif clone.sale_end_type.value == 'regular' %}
        {% set sale_end_ts = "today 22:00"|date('U') %}
    {% elseif clone.sale_end_type.value == 'custom' %}
        {% set sale_end_ts = clone.end_time ? clone.end_time|date('U') : 0 %}
    {% endif %}
    {% set sale_persistent = clone.sale_persistent.value == 'On' ? 1 : 0 %}

    <div class="product-card" data-sale="{{ sale_percent }}" data-sale-price="{{ sale_price }}" data-sale-end="{{ sale_end_ts }}" data-sale-persistent="{{ sale_persistent }}">
        <div class="sale-badge">-{{ sale_percent }}%</div>
        <div class="product-image">
            <img src="{{ product.thumbnail.full.url }}" width="{{ product.thumbnail.full.width }}" height="{{ product.thumbnail.full.height }}" alt="{{ product.thumbnail.full.alt }}">
        </div>
        <div class="product-content">
            <h3 class="product-title">{{ item.title }}</h3>
            <div class="product-price">
                <span class="price-regular">
                    ${{ price|number_format(0, ',', '.') }}
                </span>
                <span class="price-sale">
                    ${{ sale_price|number_format(0, ',', '.') }}
                </span>
            </div>
            {% if sale_end_ts %}
            <div class="countdown">
                Sale end:
                <span class="countdown-timer">--:--:--</span>
            </div>
            {% endif %}
        </div>
    </div>
{% endfor %}
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<div class="product-grid">
    {% set args = { post_type: 'product', posts_per_page: -1, orderby: 'date', order: 'DESC' } %}
    {% set posts = mb.get_posts( args ) %}
    {% for post in posts %}
        <div class="product-card" data-id="{{ post.ID }}">
            <div class="product-image">
                <img src="{{ post.thumbnail.full.url }}" alt="{{ post.thumbnail.full.alt }}">
            </div>
            <h3 class="product-title"><a href="{{ post.url }}">{{ post.title }}</a></h3>
            <ul class="product-specs">
                <li><strong>OS:</strong> {{ post.operating_system }}</li>
                <li><strong>CPU:</strong> {{ post.processor }}</li>
                <li><strong>Storage:</strong> {{ post.storage.value }}</li>
                <li><strong>Camera:</strong> {{ post.camera }}</li>
                <li><strong>Battery:</strong> {{ post.battery.value }}</li>
            </ul>
            <button class="btn-compare"
                data-id="{{ post.ID }}"
                data-title="{{ post.title }}"
                data-thumb="{{ post.thumbnail.full.url }}"
                data-os="{{ post.operating_system }}"
                data-cpu="{{ post.processor }}"
                data-storage="{{ post.storage.value }}"
                data-camera="{{ post.camera }}"
                data-battery="{{ post.battery.value }}">
                + Compare
            </button>
        </div>
    {% endfor %}
</div>

<div id="compare-bar">
    <div class="compare-slots">
        <div class="slot" data-slot="1">+ Add Product</div>
        <div class="slot" data-slot="2">+ Add Product</div>
        <div class="slot" data-slot="3">+ Add Product</div>
    </div>
    <button id="btn-show-compare" disabled>Compare Now</button>
    <a href="#" id="btn-clear-all">Clear all products</a>
</div>

<div id="compare-table-container" style="display:none;">
    <h2>Compare Table</h2>
    <table class="compare-table">
        <thead>
            <tr id="compare-titles">
                <th>Technical Specifications</th>
            </tr>
        </thead>
        <tbody>
            <tr id="row-os"><td>Operating System</td></tr>
            <tr id="row-cpu"><td>CPU</td></tr>
            <tr id="row-storage"><td>Storage</td></tr>
            <tr id="row-camera"><td>Camera</td></tr>
            <tr id="row-battery"><td>Battery</td></tr>
        </tbody>
    </table>
</div>

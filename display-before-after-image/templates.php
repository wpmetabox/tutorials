<div class="mb-container">
    <div id="before-after-slider">
        <div id="before-image">
            <img src="{{ post.before_image.full.url }}" width="{{ post.before_image.full.width }}" height="{{ post.before_image.full.height }}" alt="{{ post.before_image.full.alt }}">
            <div class="text-before">{{ post.before_content }} </div>
        </div>
        <div id="after-image">
            <img src="{{ post.after_image.full.url }}" width="{{ post.after_image.full.width }}" height="{{ post.after_image.full.height }}" alt="{{ post.after_image.full.alt }}">
            <div class="text-after">{{ post.after_content }} </div>
        </div>

        <div id="resizer">
            <div class="mb-icon">
                <div id="triangle-left"></div>
                <div id="triangle-right"></div>
            </div>
        </div>

    </div>
</div>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<div class="wrapper mb-slider">
    <div class="carousel">
        {% for item in post.image_gallery %}
            <div>
               <img src="{{ item.full.url }}" width="{{ item.full.width }}" height="{{ item.full.height }}" alt="{{ item.full.alt }}">
            </div>
        {% endfor %}        
    </div>
</div>


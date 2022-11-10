<?php
 get_header();
?>
<style>
.car-rental {
    display: flex;
    flex-wrap: wrap;
    margin: 50px 0;
}

.car-rental .col-left {
    width: 55%;
}

.car-rental .col-left .mySlides.fade img {
    width: 100%;
    height: 500px;
    object-fit: cover;
}

.car-rental .col-right {
    width: 45%;
    padding-left: 50px;
}

.post-content {
    font-style: italic;
    font-size: 16px;
}

.rental-price {
    font-size: 45px;
    font-weight: 700;
    color: #fe5252;
}

.car-rental .col-right ul {
    margin: 0;
    list-style: none;
}

.car-rental .col-right ul .details {
    display: flex;
    width: 100%;
    justify-content: space-between;
    align-items: center;
}

.car-rental .col-right ul .details h5 {
    font-weight: 700;
}

.car-rental .col-right ul .details span {
    font-style: italic;
}

.mySlides {display: none}

.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -22px;
  color: white;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
}

.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

.prev:hover, .next:hover {
  background-color: rgba(0,0,0,0.8);
}

.active, .dot:hover {
  background-color: #717171;
}

.fade {
  animation-name: fade;
  animation-duration: 1.5s;
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}
</style>
<div class="page-wrapper">
<div class="car-rental">
	<div class="col-left">
		<div class="slideshow-container">
            <?php 
                    $gallery = rwmb_meta( 'gallery', array( 'size' => 'thumbnail', 'limit' => '5' ) );
                    foreach ( $gallery as $img ) {
                        echo '<div class="mySlides fade"><a href="'. $img['full_url']. '"><img src ="'.$img['url']. '"></a></div>';
                    }
            ?>
			<a class="prev" onclick="plusSlides(-1)">❮</a>
			<a class="next" onclick="plusSlides(1)">❯</a>
		</div>
	</div>
	<div class="col-right">
		<h1><?php the_title(); ?></h1>
		<div class="post-content"><?php the_content(); ?></div>
		<p class="rental-price">$<?php echo $price = rwmb_meta('rental_price'); ?>/Day</p>
		<ul>
			<li>
			 	<div class="details">
					<h5>Car Year</h5>
					<span><?php echo $car_year = rwmb_meta('car_year'); ?></span>
				</div>
			</li>
			<li>
			 	<div class="details">
					<h5>Max Passengers</h5>
					<span><?php echo $max_luggage = rwmb_meta('max_luggage'); ?></span>
				</div>
			</li>
			<li>
			 	<div class="details">
					<h5>Fuel</h5>
					<span><?php echo $fuel = rwmb_meta('fuel'); ?></span>
				</div>
			</li>
			<li>
			 	<div class="details">
					<h5>Doors</h5>
					<span><?php echo $door = rwmb_meta('door'); ?></span>
				</div>
			</li>
			<li>
			 	<div class="details">
					<h5>Fuel Usage</h5>
					<span><?php echo $fuel_u = rwmb_meta('fuel_usage'); ?></span>
				</div>
			</li>
			<li>
			 	<div class="details">
					<h5>Engine Capacity</h5>
					<span><?php echo $engine_capacity = rwmb_meta('engine_capacity'); ?></span>
				</div>
			</li>
			<li>
			 	<div class="details">
					<h5>Mileage</h5>
					<span><?php echo $Mileage = rwmb_meta('mileage'); ?></span>
				</div>
			</li>
			<li>
			 	<div class="details">
					<h5>Max Luggage</h5>
					<span><?php echo $max_luggage = rwmb_meta('max_luggage'); ?></span>
				</div>
			</li>
		</ul>
	</div>
</div>
</div>



 <?php
 get_footer();
 ?>
 <script>
let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slides[slideIndex-1].style.display = "block";  
}
</script>

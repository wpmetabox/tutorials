<div class="recipe-food__container">
	<h2 class="recipe-name">Recipe</h2>
	<div class="recipe-group recipe-times">
		<h3 class="recipe-header">
			<div class="recipe-line"></div>
		</h3>
		<div class="recipe-times__container">
			<div class="recipe-times__item">
				<span class="label">Prep Time</span>
				<span class="recipe-time">{{ post.prep_time }}</span>
			</div>
			<div class="recipe-times__item">
				<span class="label">Cook Time</span>
				<span class="recipe-time">{{ post.cooking_time }}</span>
			</div>
			<div class="recipe-times__item">
				<span class="label">Resting Time</span>
				<span class="recipe-time">{{ post.resting_time }}</span>
			</div>
			<div class="recipe-times__item">
				<span class="label">Total Time</span>
				<span class="recipe-time">{{ post.total_time }}}</span>
			</div>
		</div>
	</div>
	<div class="recipe-group recipe-equipment">
		<h3 class="recipe-header">
			Equipment
			<div class="recipe-line"></div>
		</h3>
		{{ post.equipment }}
	</div>
	<div class="recipe-group recipe-ingredients">
		<h3 class="recipe-header">
			Ingredients
			<div class="recipe-line"></div>
		</h3>
		{{ post.ingredients }}
	</div>
	<div class="recipe-group recipe-instructions">
		<h3 class="recipe-header">
			Instructions
			<div class="recipe-line"></div>
		</h3>
		{{ post.instructions }}
	</div>
	<div class="recipe-group recipe-video">
		<h3 class="recipe-header">
			Video
			<div class="recipe-line"></div>
		</h3>
		{{ post.video.rendered }}
	</div>
	<div class="recipe-group recipe-notes">
		<h3 class="recipe-header">
			Notes
			<div class="recipe-line"></div>
		</h3>
		{{ post.notes }}
	</div>
	<div class="recipe-group recipe-nutrition">
		<h3 class="recipe-header">
			Nutrition
			<div class="recipe-line"></div>
		</h3>
		{{ post.nutrition }}
	</div>
</div>

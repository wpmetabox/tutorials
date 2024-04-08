<?php
/**
 * @var array<string, mixed>[] $attributes The block attributes.
 * @var string $content The block default content.
 * @var \WP_Block $block The block instance.
 */
?>
<div id="mb-block-quote" <?= get_block_wrapper_attributes(); ?> >

	<div class="quote-content">
		<div class="quote_content"><?= $attributes['content'] ?></div>
		<div class="quote_author"><?= $attributes['name'] ?></div>
		<div class="quote_positon"><?= $attributes['positon'] ?></div>
	</div>

	<div class="quote_avater">
		<img class="quote__image" src="<?= $attributes['avatar']['full_url'] ?>">
	</div>

</div>

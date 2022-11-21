<?php
/**
  * Template Name: FAQs
  */
  get_header();
?>
<div class="faq-page">
	<h1>FAQs</h1>
	<div class="content-faq">
		<div class="tab-category">
			<ul>
            <?php $group_values = rwmb_meta( 'tabs' );
                            if ( ! empty( $group_values ) ) {
                                foreach ( $group_values as $group_value ) {
                                    $value = isset( $group_value['tab_name'] ) ? $group_value['tab_name'] : ''; ?>
                                    <li><a href="#<?php echo $value; ?>"><?php echo $value; ?></a></li>
                            <?php }
            }  ?>
			</ul>
		</div>
		<div class="content-ul-cate">
            <?php $group_values = rwmb_meta( 'tabs' );
                if ( ! empty( $group_values ) ) {
                    foreach ( $group_values as $group_value ) {
                        $value = isset( $group_value['tab_name'] ) ? $group_value['tab_name'] : '';
                        $group_childs = isset( $group_value['qanda'] ) ? $group_value['qanda'] : ''; ?>
                        <ul class="ul-cate" id="<?php echo $value; ?>">
                        <?php 
                            foreach ( $group_childs as $group_child ) {
                                $question = isset( $group_child['question'] ) ? $group_child['question'] : '';
                                $answer = isset( $group_child['answer'] ) ? $group_child['answer'] : ''; ?>
                                <li class="content-group">
                                    <h3><?php echo $question; ?> </h3>
                                    <p><?php echo $answer; ?> </p>
                                </li>
                            <?php } ?>
                            </ul>
                    <?php }
                } ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>

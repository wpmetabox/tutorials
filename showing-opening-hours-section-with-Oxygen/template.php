<h2>
	Opening Hours
</h2>
<div class="detail-schedule">
<?php $options = rwmb_meta( 'choose_an_option' ); ?>
<?php if ( $options == "all_days_are_the_same" ): ?>
    <?php $same_days = rwmb_meta( 'all_days_have_the_same_opening_hours' ); ?>
		<?php $same_days_option = $same_days['type_of_opening_hours']; ?>
		<?php $choose_time_slots = $same_days['choose_time_slots'] ?>
		<?php if ( $same_days_option == "enter_hours" ): ?>
			<div class="date-time">
				<div class="date">
					Mon - Sun
				</div>
				<div class="hour">
					<?php foreach ( $choose_time_slots as $time_slots ): ?>
					<div class="time-slot">
						<p class="starting-hour"><?php echo $time_slots['start_time'] ?></p>
						<p class="ending-hour"><?php echo $time_slots['end_time'] ?></p>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php else: ?>
			<div class="date-time">
				<div class="date">
					Mon - Sun
				</div>
				<div class="hour">
				<?php
					$select_field = isset( $same_days['type_of_opening_hours'] ) ? $same_days['type_of_opening_hours'] : '';
					$group_field = rwmb_get_field_settings( 'all_days_have_the_same_opening_hours' );
				?>
				<?php foreach ( $group_field['fields'] as $group_settings ) : ?>
					<?php foreach ( $group_settings as $key => $value ) : ?>
						<?php if ( $key == 'options' ) :?>
							<?php if( $value[$select_field] ): ?>
								<?php echo $value[$select_field]; ?>
							<?php endif;?>
						<?php endif;?>
					<?php endforeach;?>
				<?php endforeach;?>
				</div>
			</div>
		<?php endif; ?>
<!-- 	End "All days are the same" option -->
<?php elseif ( $options == "difference_between_weekdays_and_weekend" ): ?>
	<?php $weekdays = rwmb_meta( 'weekdays' ); ?>
	<?php $weekend = rwmb_meta( 'weekend' ); ?>
		<?php $weekdays_option = $weekdays['type_of_opening_hours_weekdays']; ?>
		<?php $choose_time_slots = $weekdays['choose_time_slots_weekdays'] ?>
		<?php if ( $weekdays_option == "enter_hours" ): ?>
			<div class="date-time">
				<div class="date">
					Mon - Fri
				</div>
				<div class="hour">
					<?php foreach ( $choose_time_slots as $time_slots ): ?>
					<div class="time-slot">
						<p class="starting-hour"><?php echo $time_slots['start_time_weekdays'] ?></p>
						<p class="ending-hour"><?php echo $time_slots['end_time_weekdays'] ?></p>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php else: ?>
			<div class="date-time">
				<div class="date">
					Mon - Fri
				</div>
				<div class="hour">
				<?php
					$select_field = isset( $weekdays['type_of_opening_hours_weekdays'] ) ? $weekdays['type_of_opening_hours_weekdays'] : '';
					$group_field = rwmb_get_field_settings( 'weekdays' );
				?>
				<?php foreach ( $group_field['fields'] as $group_settings ) : ?>
					<?php foreach ( $group_settings as $key => $value ) : ?>
						<?php if ( $key == 'options' ) :?>
							<?php if( $value[$select_field] ): ?>
								<?php echo $value[$select_field]; ?>
							<?php endif;?>
						<?php endif;?>
					<?php endforeach;?>
				<?php endforeach;?>
				</div>
			</div>
		<?php endif; ?>
<!-- 			End weekdays -->
		<?php $weekend_option = $weekend['type_of_opening_hours_weekend']; ?>
		<?php $choose_time_slots = $weekend['choose_time_slots_weekend'] ?>
		<?php if ( $weekend_option == "enter_hours" ): ?>
			<div class="date-time">
				<div class="date">
					Sat - Sun
				</div>
				<div class="hour">
					<?php foreach ( $choose_time_slots as $time_slots ): ?>
					<div class="time-slot">
						<p class="starting-hour"><?php echo $time_slots['start_time_weekend'] ?></p>
						<p class="ending-hour"><?php echo $time_slots['end_time_weekend'] ?></p>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php else: ?>
			<div class="date-time">
				<div class="date">
					Sat - Sun
				</div>
				<div class="hour">
				<?php
					$select_field = isset( $weekend['type_of_opening_hours_weekend'] ) ? $weekend['type_of_opening_hours_weekend'] : '';
					$group_field = rwmb_get_field_settings( 'weekend' );
				?>
				<?php foreach ( $group_field['fields'] as $group_settings ) : ?>
					<?php foreach ( $group_settings as $key => $value ) : ?>
						<?php if ( $key == 'options' ) :?>
							<?php if( $value[$select_field] ): ?>
								<?php echo $value[$select_field]; ?>
							<?php endif;?>
						<?php endif;?>
					<?php endforeach;?>
				<?php endforeach;?>
				</div>
			</div>
		<?php endif; ?>
<!-- 			End weekend -->
<!-- 	End "Difference between weekdays and weekend" option -->
<?php else: ?>
	<?php $monday_group = rwmb_meta( 'monday' ); ?>
	<?php $tuesday_group = rwmb_meta( 'tuesday' ); ?>
	<?php $wednesday_group = rwmb_meta( 'wednesday' ); ?>
	<?php $thursday_group = rwmb_meta( 'thursday' ); ?>
	<?php $friday_group = rwmb_meta( 'friday' ); ?>
	<?php $saturday_group = rwmb_meta( 'saturday' ); ?>
	<?php $sunday_group = rwmb_meta( 'sunday' ); ?>
		<?php $monday_select = $monday_group['type_of_opening_hours_monday']; ?>
		<?php $choose_time_slots = $monday_group['choose_time_slots_monday'] ?>
		<?php if ( $monday_select == "enter_hours" ): ?>
			<div class="date-time">
				<div class="date">
					Monday
				</div>
				<div class="hour">
					<?php foreach ( $choose_time_slots as $time_slots ): ?>
					<div class="time-slot">
						<p class="starting-hour"><?php echo $time_slots['start_time_monday'] ?></p>
						<p class="ending-hour"><?php echo $time_slots['end_time_monday'] ?></p>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php else: ?>
			<div class="date-time">
				<div class="date">
					Monday
				</div>
				<div class="hour">
				<?php
					$select_field = isset( $monday_group['type_of_opening_hours_monday'] ) ? $monday_group['type_of_opening_hours_monday'] : '';
					$group_field = rwmb_get_field_settings( 'monday' );
				?>
				<?php foreach ( $group_field['fields'] as $group_settings ) : ?>
					<?php foreach ( $group_settings as $key => $value ) : ?>
						<?php if ( $key == 'options' ) :?>
							<?php if( $value[$select_field] ): ?>
								<?php echo $value[$select_field]; ?>
							<?php endif;?>
						<?php endif;?>
					<?php endforeach;?>
				<?php endforeach;?>
				</div>
			</div>
		<?php endif; ?>
<!-- 			End Monday -->
		<?php $tuesday_select = $tuesday_group['type_of_opening_hours_tuesday']; ?>
		<?php $choose_time_slots = $tuesday_group['choose_time_slots_tuesday'] ?>
		<?php if ( $tuesday_group == "enter_hours" ): ?>
			<div class="date-time">
				<div class="date">
					Tuesday
				</div>
				<div class="hour">
					<?php foreach ( $choose_time_slots as $time_slots ): ?>
					<div class="time-slot">
						<p class="starting-hour"><?php echo $time_slots['start_time_tuesday'] ?></p>
						<p class="ending-hour"><?php echo $time_slots['end_time_tuesday'] ?></p>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php else: ?>
			<div class="date-time">
				<div class="date">
					Tuesday
				</div>
				<div class="hour">
				<?php
					$select_field = isset( $tuesday_group['type_of_opening_hours_tuesday'] ) ? $tuesday_group['type_of_opening_hours_tuesday'] : '';
					$group_field = rwmb_get_field_settings( 'tuesday' );
				?>
				<?php foreach ( $group_field['fields'] as $group_settings ) : ?>
					<?php foreach ( $group_settings as $key => $value ) : ?>
						<?php if ( $key == 'options' ) :?>
							<?php if( $value[$select_field] ): ?>
								<?php echo $value[$select_field]; ?>
							<?php endif;?>
						<?php endif;?>
					<?php endforeach;?>
				<?php endforeach;?>
				</div>
			</div>
		<?php endif; ?>
<!-- 			End Tuesday -->
		<?php $wednesday_select = $wednesday_group['type_of_opening_hours_wednesday']; ?>
		<?php $choose_time_slots = $wednesday_group['choose_time_slots_wednesday'] ?>
		<?php if ( $wednesday_select == "enter_hours" ): ?>
			<div class="date-time">
				<div class="date">
					Wednesday
				</div>
				<div class="hour">
					<?php foreach ( $choose_time_slots as $time_slots ): ?>
					<div class="time-slot">
						<p class="starting-hour"><?php echo $time_slots['start_time_wednesday'] ?></p>
						<p class="ending-hour"><?php echo $time_slots['end_time_wednesday'] ?></p>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php else: ?>
			<div class="date-time">
				<div class="date">
					Wednesday
				</div>
				<div class="hour">
				<?php
					$select_field = isset( $wednesday_group['type_of_opening_hours_wednesday'] ) ? $wednesday_group['type_of_opening_hours_wednesday'] : '';
					$group_field = rwmb_get_field_settings( 'wednesday' );
				?>
				<?php foreach ( $group_field['fields'] as $group_settings ) : ?>
					<?php foreach ( $group_settings as $key => $value ) : ?>
						<?php if ( $key == 'options' ) :?>
							<?php if( $value[$select_field] ): ?>
								<?php echo $value[$select_field]; ?>
							<?php endif;?>
						<?php endif;?>
					<?php endforeach;?>
				<?php endforeach;?>
				</div>
			</div>
		<?php endif; ?>
<!-- 			End Wednesday -->
		<?php $thursday_select = $thursday_group['type_of_opening_hours_thursday']; ?>
		<?php $choose_time_slots = $thursday_group['choose_time_slots_thursday'] ?>
		<?php if ( $thursday_select == "enter_hours" ): ?>
			<div class="date-time">
				<div class="date">
					Thursday
				</div>
				<div class="hour">
					<?php foreach ( $choose_time_slots as $time_slots ): ?>
					<div class="time-slot">
						<p class="starting-hour"><?php echo $time_slots['start_time_thursday'] ?></p>
						<p class="ending-hour"><?php echo $time_slots['end_time_thursday'] ?></p>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php else: ?>
			<div class="date-time">
				<div class="date">
					Thursday
				</div>
				<div class="hour">
				<?php
					$select_field = isset( $thursday_group['type_of_opening_hours_thursday'] ) ? $thursday_group['type_of_opening_hours_thursday'] : '';
					$group_field = rwmb_get_field_settings( 'thursday' );
				?>
				<?php foreach ( $group_field['fields'] as $group_settings ) : ?>
					<?php foreach ( $group_settings as $key => $value ) : ?>
						<?php if ( $key == 'options' ) :?>
							<?php if( $value[$select_field] ): ?>
								<?php echo $value[$select_field]; ?>
							<?php endif;?>
						<?php endif;?>
					<?php endforeach;?>
				<?php endforeach;?>
				</div>
			</div>
		<?php endif; ?>
<!-- 			End Thursday -->
		<?php $friday_select = $friday_group['type_of_opening_hours_friday']; ?>
		<?php $choose_time_slots = $friday_group['choose_time_slots_friday'] ?>
		<?php if ( $friday_select == "enter_hours" ): ?>
			<div class="date-time">
				<div class="date">
					Friday
				</div>
				<div class="hour">
					<?php foreach ( $choose_time_slots as $time_slots ): ?>
					<div class="time-slot">
						<p class="starting-hour"><?php echo $time_slots['start_time_friday'] ?></p>
						<p class="ending-hour"><?php echo $time_slots['end_time_friday'] ?></p>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php else: ?>
			<div class="date-time">
				<div class="date">
					Friday
				</div>
				<div class="hour">
				<?php
					$select_field = isset( $friday_group['type_of_opening_hours_friday'] ) ? $friday_group['type_of_opening_hours_friday'] : '';
					$group_field = rwmb_get_field_settings( 'friday' );
				?>
				<?php foreach ( $group_field['fields'] as $group_settings ) : ?>
					<?php foreach ( $group_settings as $key => $value ) : ?>
						<?php if ( $key == 'options' ) :?>
							<?php if( $value[$select_field] ): ?>
								<?php echo $value[$select_field]; ?>
							<?php endif;?>
						<?php endif;?>
					<?php endforeach;?>
				<?php endforeach;?>
				</div>
			</div>
		<?php endif; ?>
<!-- 			End Friday -->
		<?php $saturday_select = $saturday_group['type_of_opening_hours_saturday']; ?>
		<?php $choose_time_slots = $saturday_group['choose_time_slots_saturday'] ?>
		<?php if ( $saturday_select == "enter_hours" ): ?>
			<div class="date-time">
				<div class="date">
					Saturday
				</div>
				<div class="hour">
					<?php foreach ( $choose_time_slots as $time_slots ): ?>
					<div class="time-slot">
						<p class="starting-hour"><?php echo $time_slots['start_time_saturday'] ?></p>
						<p class="ending-hour"><?php echo $time_slots['end_time_saturday'] ?></p>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php else: ?>
			<div class="date-time">
				<div class="date">
					Saturday
				</div>
				<div class="hour">
				<?php
					$select_field = isset( $saturday_group['type_of_opening_hours_saturday'] ) ? $saturday_group['type_of_opening_hours_saturday'] : '';
					$group_field = rwmb_get_field_settings( 'saturday' );
				?>
				<?php foreach ( $group_field['fields'] as $group_settings ) : ?>
					<?php foreach ( $group_settings as $key => $value ) : ?>
						<?php if ( $key == 'options' ) :?>
							<?php if( $value[$select_field] ): ?>
								<?php echo $value[$select_field]; ?>
							<?php endif;?>
						<?php endif;?>
					<?php endforeach;?>
				<?php endforeach;?>
				</div>
			</div>
		<?php endif; ?>
<!-- 			End Saturday -->
		<?php $sunday_select = $sunday_group['type_of_opening_hours_sunday']; ?>
		<?php $choose_time_slots = $sunday_group['choose_time_slots_sunday'] ?>
		<?php if ( $sunday_select == "enter_hours" ): ?>
			<div class="date-time">
				<div class="date">
					Sunday
				</div>
				<div class="hour">
					<?php foreach ( $choose_time_slots as $time_slots ): ?>
					<div class="time-slot">
						<p class="starting-hour"><?php echo $time_slots['start_time_sunday'] ?></p>
						<p class="ending-hour"><?php echo $time_slots['end_time_sunday'] ?></p>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php else: ?>
			<div class="date-time">
				<div class="date">
					Sunday
				</div>
				<div class="hour">
				<?php
					$select_field = isset( $sunday_group['type_of_opening_hours_sunday'] ) ? $sunday_group['type_of_opening_hours_sunday'] : '';
					$group_field = rwmb_get_field_settings( 'sunday' );
				?>
				<?php foreach ( $group_field['fields'] as $group_settings ) : ?>
					<?php foreach ( $group_settings as $key => $value ) : ?>
						<?php if ( $key == 'options' ) :?>
							<?php if( $value[$select_field] ): ?>
								<?php echo $value[$select_field]; ?>
							<?php endif;?>
						<?php endif;?>
					<?php endforeach;?>
				<?php endforeach;?>
				</div>
			</div>
		<?php endif; ?>
<!-- 			End Sunday -->
<?php endif; ?>
				</div>

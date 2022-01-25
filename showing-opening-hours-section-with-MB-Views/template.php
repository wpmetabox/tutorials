<div class="opening-hours">
		<h2>
			Opening Hours
		</h2>
		<div class="detail-schedule">
			{% set options = post.choose_an_options.value %}
			{% if (options == "all_days_are_the_same") %}
				{% set all_day_the_same = post.all_days_have_the_same_opening_hours.type_of_opening_hours.value %}
				{% if ( all_day_the_same == "enter_hours") %}
				<div class="date-time">
					<div class="date">
						Mon - Sun
					</div>
					<div class="hour">
						{% for clone in post.all_days_have_the_same_opening_hours.choose_time_slots %}
						<div class="time-slot">
							<p class="starting-hour">
								{{ clone.start_time | date( 'h:i A' ) }}
							</p>
							<p class="ending-hour">
								{{ clone.end_time | date( 'h:i A' ) }}
							</p>
						</div>
						{% endfor %}
					</div>
				</div>
				{% else %}
				<div class="date-time">
					<div class="date">
							Mon - Sun
					</div>
					<div class="hour">
						{{ post.all_days_have_the_same_opening_hours.type_of_opening_hours.label }}
					</div>
				</div>
				{% endif %}
<!-- 			End "All days are the same" option -->
			{% elseif (options == "difference_between_weekdays_and_weekend") %}
				{% set weekdays = post.weekdays.type_of_opening_hours_weekdays.value %}
				{% set weekend =  post.weekend.type_of_opening_hours_weekend.value %}
				{% if (weekdays == "enter_hours") %}
				<div class="date-time">
					<div class="date">
						Mon - Fri
					</div>
					<div class="hour">
						{% for clone in post.weekdays.choose_time_slots_weekdays %}
						<div class="time-slot">
							<p class="starting-hour">
								{{ clone.start_time_weekdays | date( 'h:i A' ) }}
							</p>
							<p class="ending-hour">
								{{ clone.end_time_weekdays | date( 'h:i A' ) }}
							</p>
						</div>
						{% endfor %}
					</div>
				</div>
				{% else %}
				<div class="date-time">
					<div class="date">
							Mon - Fri
					</div>
					<div class="hour">
						{{ post.weekdays.type_of_opening_hours_weekdays.label }}
					</div>
				</div>
				{% endif %}
<!-- 			End weekdays -->
				{% if (weekend == "enter_hours") %}
				<div class="date-time">
					<div class="date">
						Sat - Sun
					</div>
					<div class="hour">
						{% for clone in post.weekend.choose_time_slots_weekend %}
						<div class="time-slot">
							<p class="starting-hour">
								{{ clone.start_time_weekend | date( 'h:i A' ) }}
							</p>
							<p class="ending-hour">
								{{ clone.end_time_weekend | date( 'h:i A' ) }}
							</p>
						</div>
						{% endfor %}
					</div>
				</div>
				{% else %}
				<div class="date-time">
					<div class="date">
							Sat - Sun
					</div>
					<div class="hour">
						{{ post.weekend.type_of_opening_hours_weekend.label }}
					</div>
				</div>
				{% endif %}
<!-- 			End weekend  -->
<!-- 			End "Difference between weekdays and weekend" option -->
			{% else %}
				{% set monday = post.monday.type_of_opening_hours_monday.value %}
				{% set tuesday = post.tuesday.type_of_opening_hours_tuesday.value %}
				{% set wednesday = post.wednesday.type_of_opening_hours_wednesday.value %}
				{% set thursday = post.thursday.type_of_opening_hours_thursday.value %}
				{% set friday = post.friday.type_of_opening_hours_friday.value %}
				{% set saturday = post.saturday.type_of_opening_hours_saturday.value %}
				{% set sunday = post.sunday.type_of_opening_hours_sunday.value %}
				{% if (monday == "enter_hours") %}
					<div class="date-time">
						<div class="date">
							Monday
						</div>
						<div class="hour">
							{% for clone in post.monday.choose_time_slots_monday %}
							<div class="time-slot">
								<p class="starting-hour">
									{{ clone.start_time_monday | date( 'h:i A' ) }}
								</p>
								<p class="ending-hour">
									{{ clone.end_time_monday | date( 'h:i A' ) }}
								</p>
							</div>
							{% endfor %}
						</div>
					</div>
					{% else %}
					<div class="date-time">
						<div class="date">
								Monday
						</div>
						<div class="hour">
							{{ post.monday.type_of_opening_hours_monday.label }}
						</div>
					</div>
				{% endif %}
<!-- 			End Monday -->
			{% if (tuesday == "enter_hours") %}
					<div class="date-time">
						<div class="date">
							Tuesday
						</div>
						<div class="hour">
							{% for clone in post.tuesday.choose_time_slots_tuesday %}
							<div class="time-slot">
								<p class="starting-hour">
									{{ clone.start_time_tuesday | date( 'h:i A' ) }}
								</p>
								<p class="ending-hour">
									{{ clone.end_time_tuesday | date( 'h:i A' ) }}
								</p>
							</div>
							{% endfor %}
						</div>
					</div>
					{% else %}
					<div class="date-time">
						<div class="date">
								Tuesday
						</div>
						<div class="hour">
							{{ post.tuesday.type_of_opening_hours_tuesday.label }}
						</div>
					</div>
				{% endif %}
			<!-- 			End Tuesday -->
			{% if (wednesday == "enter_hours") %}
					<div class="date-time">
						<div class="date">
							Wednesday
						</div>
						<div class="hour">
							{% for clone in post.wednesday.choose_time_slots_wednesday %}
							<div class="time-slot">
								<p class="starting-hour">
									{{ clone.start_time_wednesday | date( 'h:i A' ) }}
								</p>
								<p class="ending-hour">
									{{ clone.end_time_wednesday | date( 'h:i A' ) }}
								</p>
							</div>
							{% endfor %}
						</div>
					</div>
					{% else %}
					<div class="date-time">
						<div class="date">
								Wednesday
						</div>
						<div class="hour">
							{{ post.wednesday.type_of_opening_hours_wednesday.label }}
						</div>
					</div>
				{% endif %}
			<!-- 			End Wednesday -->
			{% if (thursday == "enter_hours") %}
					<div class="date-time">
						<div class="date">
							Thursday
						</div>
						<div class="hour">
							{% for clone in post.thursday.choose_time_slots_thursday %}
							<div class="time-slot">
								<p class="starting-hour">
									{{ clone.start_time_thursday | date( 'h:i A' ) }}
								</p>
								<p class="ending-hour">
									{{ clone.end_time_thursday | date( 'h:i A' ) }}
								</p>
							</div>
							{% endfor %}
						</div>
					</div>
					{% else %}
					<div class="date-time">
						<div class="date">
								Thursday
						</div>
						<div class="hour">
							{{ post.thursday.type_of_opening_hours_thursday.label }}
						</div>
					</div>
				{% endif %}
			<!-- 			End Thursday -->
			{% if (friday == "enter_hours") %}
					<div class="date-time">
						<div class="date">
							Friday
						</div>
						<div class="hour">
							{% for clone in post.friday.choose_time_slots_friday %}
							<div class="time-slot">
								<p class="starting-hour">
									{{ clone.start_time_friday | date( 'h:i A' ) }}
								</p>
								<p class="ending-hour">
									{{ clone.end_time_friday | date( 'h:i A' ) }}
								</p>
							</div>
							{% endfor %}
						</div>
					</div>
					{% else %}
					<div class="date-time">
						<div class="date">
								Friday
						</div>
						<div class="hour">
							{{ post.friday.type_of_opening_hours_friday.label }}
						</div>
					</div>
				{% endif %}
			<!-- 			End Friday -->
			{% if (saturday == "enter_hours") %}
					<div class="date-time">
						<div class="date">
							Saturday
						</div>
						<div class="hour">
							{% for clone in post.saturday.choose_time_slots_saturday %}
							<div class="time-slot">
								<p class="starting-hour">
									{{ clone.start_time_saturday | date( 'h:i A' ) }}
								</p>
								<p class="ending-hour">
									{{ clone.end_time_saturday | date( 'h:i A' ) }}
								</p>
							</div>
							{% endfor %}
						</div>
					</div>
					{% else %}
					<div class="date-time">
						<div class="date">
								Saturday
						</div>
						<div class="hour">
							{{ post.saturday.type_of_opening_hours_saturday.label }}
						</div>
					</div>
				{% endif %}
			<!-- 			End Saturday -->
			{% if (sunday == "enter_hours") %}
					<div class="date-time">
						<div class="date">
							Sunday
						</div>
						<div class="hour">
							{% for clone in post.sunday.choose_time_slots_sunday %}
							<div class="time-slot">
								<p class="starting-hour">
									{{ clone.start_time_sunday | date( 'h:i A' ) }}
								</p>
								<p class="ending-hour">
									{{ clone.end_time_sunday | date( 'h:i A' ) }}
								</p>
							</div>
							{% endfor %}
						</div>
					</div>
					{% else %}
					<div class="date-time">
						<div class="date">
								Sunday
						</div>
						<div class="hour">
							{{ post.sunday.type_of_opening_hours_sunday.label }}
						</div>
					</div>
				{% endif %}
			<!-- 			End Sunday -->
			{% endif %}
		
		</div>
	</div>

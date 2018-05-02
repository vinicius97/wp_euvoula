<?php

/**************************************
Custom Post Meta Boxes
***************************************/

	add_action('add_meta_boxes', 'register_schedule_settings');
	function register_schedule_settings () {
		add_meta_box('themesdojo_schedule', 'Program', 'display_schedule','day');
	}

	function display_schedule ($post) { 

		$program_item = get_post_meta($post->ID, 'day-program', true);

	?>
		
	<input type="hidden" name="cmb_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>" />

	<style>
		#options-popup {
			display: block;
		}

		#post-body #normal-sortables {
			display: none;
		}

		#options-popup .option-item {
			background: #FFF;
			margin: 0 -10px 0 -10px;
			border-bottom: 1px solid #EEE;
			padding: 14px 10px 14px 10px;
			width: 100%;
		}

		#options-popup .option-item span.text {
			float: left;
			display: block;
			width: 150px;
			margin-top: 5px;
		}

		#options-popup .option-item .criteria-name {
			float: left;
			margin-right: 36px;
			width: 400px;
		}

		#options-popup .option-item span.text {
			width: 150px;
			margin-right: 10px;
		}

		#options-popup .option-item input {
			float: left;
			margin-right: 20px;
		}

		.full {
			width: 100%;
			display: inline-block;
		}

		.info-text {
			font-style: italic;
			float: left;
			margin-top: 10px;
			width: 70%;
			margin-left: 113px;
		}

		.criteria-image {
			max-width: 590px;
			height: auto;
		}

	</style>

	<div id='options-popup'>

		<div id="day-program">
			<?php 
				for ($i = 0; $i < (count($program_item)); $i++) {
			?>
				
			<div class="option-item" id="<?php echo $i; ?>">
					
				<span class='text'>Program Item <?php echo ($i+1); ?></span>

				<div class="full full-criteria-hour">
					<span class='text'>Hour</span>
					<input type='text' id='day-program[<?php echo $i; ?>][0]' name='day-program[<?php echo $i; ?>][0]' value='<?php if (!empty($program_item[$i][0])) echo $program_item[$i][0]; ?>' class='criteria-hour' placeholder="10:30">
				</div>

				<div class="full full-criteria-name">
					<span class='text'>Title</span>
					<input type='text' id='day-program[<?php echo $i; ?>][1]' name='day-program[<?php echo $i; ?>][1]' value='<?php if (!empty($program_item[$i][1])) echo $program_item[$i][1]; ?>' class='criteria-name' placeholder="Title">
				</div>

				<div class="full full-criteria-desc">
					<span class='text'>Description</span>
					<textarea class="criteria-desc" name="day-program[<?php echo $i; ?>][2]" id='day-program[<?php echo $i; ?>][2]' cols="70" rows="7" ><?php if (!empty($program_item[$i][2])) { echo $program_item[$i][2]; } ?></textarea>
				</div>

				<button name="delete-submit-day-program-item" type="button" class="button-secondary delete-submit-day-program-item">delete</button>
					
			</div>
				
			<?php 
				}
			?>


		</div>

		<div id="day-program-criterion">
				
			<div class="option-item" id="<?php echo $i; ?>">
					
				<span class='text'>Program Item 999</span>

				<div class="full full-criteria-hour">
					<span class='text'>Hour</span>
					<input type='text' id='' name='' value='' class='criteria-hour' placeholder="10:30">
				</div>

				<div class="full full-criteria-name">
					<span class='text'>Title</span>
					<input type='text' id='' name='' value='' class='criteria-name' placeholder="Title">
				</div>

				<div class="full full-criteria-desc">
					<span class='text'>Description</span>
					<textarea class="criteria-desc" name='' id='' cols="70" rows="7" ></textarea>
				</div>

				<button name="delete-submit-day-program-item" type="button" class="button-secondary delete-submit-day-program-item">delete</button>
					
			</div>

		</div>

		<div class="option-item">
			<button type="button" name="submit-day-program-item" id='submit-day-program-item' value="add" class="button-secondary">Add new program item</button>
		</div>


	</div>	<!-- end review_options_pop -->


	<?php

	}

	
	add_action ('save_post', 'update_schedule_settings');
	function update_schedule_settings ( $post_id ) {
	// verify nonce.  

	if (!isset($_POST['cmb_nonce'])) {
			return false;		
	}

	if (!wp_verify_nonce($_POST['cmb_nonce'], basename(__FILE__))) {
		return false;
	}

	global  $allowed;

	//regular update		
	update_post_meta($post_id, 'day-program', $_POST['day-program']);

}

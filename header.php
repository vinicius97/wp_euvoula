<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<!--
===========================================================================
 Event WordPress Theme by ThemesDojo (http://www.themesdojo.com)
===========================================================================
-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    
    <?php td_meta_hook(); //action hook, see inc/td-theme-hooks.php ?>

    <!-- Title -->
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <meta name="description" content="<?php bloginfo('description'); ?>"> 
    
    <!-- RSS & Pingbacks -->
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <?php

		global $redux_demo; 
		if(isset($redux_demo['favicon-image']['url'])) {
		$favicon_image = $redux_demo['favicon-image']['url'];
		if(!empty($favicon_image)) {

	?>

    <link rel="icon" href="<?php echo $favicon_image; ?>">

    <?php } } ?>

    <!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php td_before_header_hook(); // action hook, see inc/ts-theme-hooks.php ?>

	<div id="scroll-top-anchor"></div>

	<?php

		global $redux_demo;
		if(isset($redux_demo['hide-sidebar-menu'])) {
		$sidebar_menu = $redux_demo['hide-sidebar-menu'];
		if($sidebar_menu == 1 && !is_page_template('templates/home-euvoula.php')) {

	?>

	<section class="side_menu right" tabindex="5000" style="overflow-y: hidden; outline: none; right: 0px; visibility: hidden;">

		<a href="#" target="_self" class="close_side_menu"></a>

		<?php get_sidebar( 'navigation' ); ?>

	</section>

	<?php } } ?>

	<div class="wrapper">

		<div id="pageloader"><i class="fa fa-spinner fa-spin"></i></div>

		<?php

			global $redux_demo; 
			if(isset($redux_demo['header_type'])) { $header_type = $redux_demo['header_type']; }

			if(!empty($header_type) && !is_page_template('templates/home-euvoula.php')) {

				if($header_type == 1) {
					
					get_template_part( 'partials/part-header-one' );

				} elseif($header_type == 2) {
					
					get_template_part( 'partials/part-header-two' );

				} 

			} else {

				get_template_part( 'partials/part-header-one' );

			} ?>

		<?php

			if ( is_page() AND !is_404() ) {

	        	get_template_part( 'partials/part-sliders' );

	        } elseif(is_tax('event_place')) { 

				$queried_object = get_queried_object();
				$cat_queried_term_id = $queried_object->term_id;
				$cat_queried_term_name = $queried_object->name;
				$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
				$loc_cover_top_bg = $tag_extra_fields[$cat_queried_term_id]['your_image_url'];
				$cat_paces_event_location = $tag_extra_fields[$cat_queried_term_id]['cat_paces_event_location'];

	        	?>
	        	<?php if(!empty($loc_cover_top_bg)) { ?>
			    	<div id="page-title" class="event-page-title">

						<div class="content page-title-container">

							<div class="cat-palce-width-cont">

								<div class="cat-palce-width">

									<div class="cat-place-box">
												
										<h3><?php echo esc_html($cat_queried_term_name); ?></h3>

										<h5> <i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo esc_html($cat_paces_event_location); ?></h5>

									</div>

								</div>

							</div>

						</div>

						<div class="page-title-bg" style="background-image: url(<?php echo esc_url($loc_cover_top_bg) ?>); background-position: 50% 50%;"></div>
					</div>

				<?php } ?>

		<?php
	        }

	    ?>


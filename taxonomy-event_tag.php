<?php
/**
 * Template for event taxonomy
 */

get_header();

themesdojo_load_map_scripts();

global $redux_demo, $cat_id, $slug; 
if(isset($redux_demo['title-image-bg']['url'])) { $redux_default_img_bg = $redux_demo['title-image-bg']['url']; } 

$cat_id = get_cat_ID(single_cat_title('', false));
if(!empty($cat_id)) {
	$query_string = '&taxonomy=event_tag&tag_ID='.$cat_id;
}

global $redux_demo, $maximRange, $tag_slug; 
$max_range = $redux_demo['max_range'];
if(!empty($max_range)) {
	$maximRange = $max_range;
} else {
	$maximRange = 1000;
}

$tag = get_queried_object();
$tag_slug = $tag->slug;

$custom_posts = new WP_Query();
$custom_posts->query(array(
    'post_type'      => 'event',
    'posts_per_page' => '-1',
    'post_status'    => 'publish',
    'event_tag'      => $tag_slug,
    'meta_query' => array(
            array(
                'key'     => 'event_status',
                'value'   => 'upcoming',
            ),
        ),
    )
);
$total_items = $custom_posts->post_count;

?>

		<div id="main-wrapper" class="content grey-bg" style="padding: 30px 0">

			<div class="container box">

				<!--===============================-->
				<!--== Section ====================-->
				<!--===============================-->
				<section class="row">

					<div class="col-sm-12">

						<div class="item-block-title widget-container widget_search">

							<div class="row">

								<div class="col-sm-8">

									<div class="full">

										<i class="fa fa-folder-open"></i><h4><?php esc_html_e("Tags", "themesdojo"); ?>: <?php printf( __( ' %s', '' ), '' . single_cat_title( '', false ) . '' );	?></h4>

										<span class="page-title-aright">
											<span><?php echo esc_attr($total_items); ?></span> <?php if($total_items == 1) { _e( 'Result Found', 'themesdojo' ); } elseif($total_items == 0) { _e( 'No Results Found', 'themesdojo' ); } else { _e( 'Results Found', 'themesdojo' ); } ?>
										</span>

									</div>

								</div>

								<div class="col-sm-4">

									<div class="full">

										<span id="show-map-button" class="td-buttom" data-rel="tooltip" rel="top" title="<?php _e( "Show Map", "themesdojo" ); ?>"><i class="fa fa-map-marker"></i></span>

										<span id="show-list-button" class="td-buttom" data-rel="tooltip" rel="top" title="<?php _e( "List View", "themesdojo" ); ?>"><i class="fa fa-th-list"></i></span>

										<span id="show-grid-button" class="td-buttom" data-rel="tooltip" rel="top" title="<?php _e( "Grid View", "themesdojo" ); ?>"><i class="fa fa-th-large"></i></span>

										<script type="text/javascript">

											jQuery(document).ready(function($) {

												jQuery(document).on('click','#show-map-button', function(e) {

													e.preventDefault();

													jQuery('#map-canvas-holder').css('display', 'block');
													jQuery('#map-canvas-holder').removeClass('hide-map');
													jQuery('#map-canvas-holder').css('opacity', '1');
													jQuery('#map-canvas-holder').css('margin-bottom', '30');
													jQuery('#map-canvas-holder').css('height', '660');
													jQuery('#cat-listing-holder').css('display', 'none');
													jQuery('#cat-listing-list-holder').css('display', 'none');
																				
												});

												jQuery(document).on('click','#show-grid-button', function(e) {

													e.preventDefault();

													jQuery('#map-canvas-holder').css('display', 'none');
													jQuery('#map-canvas-holder').addClass('hide-map');
													jQuery('#map-canvas-holder').css('opacity', '0');
													jQuery('#map-canvas-holder').css('height', '0');
													jQuery('#map-canvas-holder').css('margin-bottom', '0');
													jQuery('#cat-listing-holder').css('display', 'inline-block');
													jQuery('#cat-listing-list-holder').css('display', 'none');
																				
												});

												jQuery(document).on('click','#show-list-button', function(e) {

													e.preventDefault();

													jQuery('#map-canvas-holder').css('display', 'none');
													jQuery('#map-canvas-holder').addClass('hide-map');
													jQuery('#map-canvas-holder').css('opacity', '0');
													jQuery('#map-canvas-holder').css('height', '0');
													jQuery('#map-canvas-holder').css('margin-bottom', '0');
													jQuery('#cat-listing-holder').css('display', 'none');
													jQuery('#cat-listing-list-holder').css('display', 'inline-block');
																				
												});

											});

										</script>

									</div>

								</div>

							</div>

						</div>

					</div>

					<div class="col-sm-8">

						<div id="map-canvas-holder" style="height: 0; opacity: 0;">

							<div id="map-canvas" style="height: 660px;"></div>

						</div>

						<div class="row">

							<div class="col-sm-12"><noscript><?php _e( 'Your browser does not support JavaScript, or it is disabled. JavaScript must be enabled in order to view listings.', 'themesdojo' ); ?></noscript></div>

							<div class="col-sm-12"><div class="listing-loading"><h3><i class="fa fa-spinner fa-spin"></i></h3></div></div>

							<div id="cat-listing-list-holder" style="display: none;">

								<?php

									global $custom_posts2;
									$custom_posts2 = new WP_Query();
									$custom_posts2->query(array(
									    'post_type'      => 'event',
									    'posts_per_page' => '30',
									    'post_status'    => 'publish',
									    'meta_key'       => 'event_start_date_number',
									    'orderby'        => 'meta_value',
									    'order'          => 'ASC',
									    'event_tag'      => $tag_slug,
									    'meta_query' => array(
									            array(
									                'key'     => 'event_status',
									                'value'   => 'upcoming',
									            ),
									        ),
									    )
									);

									if ( $custom_posts2->have_posts() ) {

								?>

									<?php while ($custom_posts2->have_posts()) : $custom_posts2->the_post(); ?>

									<div class="col-sm-12">

										<div class="listing-list-container">

											<?php 

												if(has_post_thumbnail()) { 

													$image_src_all = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), false, '' );

													$image_src = $image_src_all[0];

												} elseif(!empty($redux_default_img_bg)) { 

													$image_src = esc_url($redux_default_img_bg); 

												} else { 

													$image_src = esc_url(get_template_directory_uri())."/images/title-bg.jpg";

												} 

											?> 

											<div class="list-view-image" style="background-image: url(<?php echo esc_url($image_src); ?>);"></div>

											<div class="row">

												<div class="col-sm-4">

													

												</div>

												<div class="col-sm-8" style="background-color: #fff;">

													<div class="listing-list-content-block">

														<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

														<span class="listing-container-tagline">

															<?php 

																$event_address_country = get_post_meta(get_the_ID(), 'event_address_country', true);
																$event_address_state = get_post_meta(get_the_ID(), 'event_address_state', true);
																$event_address_city = get_post_meta(get_the_ID(), 'event_address_city', true);
																$event_address_address = get_post_meta(get_the_ID(), 'event_address_address', true);
																$event_address_zip = get_post_meta(get_the_ID(), 'event_address_zip', true);
																$event_location = get_post_meta(get_the_ID(), 'event_location', true);

															?> 

															<i class="fa fa-map-marker"></i>

															<?php if(!empty($event_location)) { ?>
																<?php echo esc_attr($event_location); ?><?php _e( ' - ', 'themesdojo' ); ?>
															<?php } ?>

															<?php if(!empty($event_address_address)) { ?>
																<?php echo esc_attr($event_address_address); ?><?php _e( ', ', 'themesdojo' ); ?>
															<?php } ?>

															<?php if(!empty($event_address_city)) { ?>
																<?php echo esc_attr($event_address_city); ?><?php _e( ', ', 'themesdojo' ); ?>
															<?php } ?>

															<?php if(!empty($event_address_state)) { ?>
																<?php echo esc_attr($event_address_state); ?><?php _e( ' ', 'themesdojo' ); ?>
															<?php } ?>

															<?php if(!empty($event_address_zip)) { ?>
																<?php echo esc_attr($event_address_zip); ?><?php _e( ', ', 'themesdojo' ); ?>
															<?php } ?>

															<?php if(!empty($event_address_country)) { ?>
																<?php echo esc_attr($event_address_country); ?>
															<?php } ?>

															<?php $event_phone = get_post_meta(get_the_ID(), 'event_phone', true); if(!empty($event_phone)) { ?>
															<span><i class="fa fa-phone"></i><?php echo esc_attr($event_phone); ?></span><?php } ?>

														</span>

														<div class="listing-container-block-body">

															<?php

																global $wpdb, $all_reviews_media;
																$post_id = get_the_ID();
																$table_name = "td_reviews";

																if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {

																	$all_reviews = $wpdb->get_var( "SELECT COUNT(*) FROM `td_reviews` WHERE listing_id = '".$post_id."' ORDER BY `ID` DESC");

																	if(!empty($all_reviews) && $all_reviews != 0) {

																		$all_reviews_media = $wpdb->get_results( "SELECT * FROM `td_reviews` WHERE listing_id = '".$post_id."' ORDER BY `ID` DESC");

																		$review_media_total = 0;

																		foreach ($all_reviews_media as $key) {

																			$review_media = $key->listing_review_values_med;

																			$review_media_total = $review_media_total + $review_media;

																		}

																		$review_overall = $review_media_total/$all_reviews;

																	}

																}

															?>

															<div class="listing-container-rating">

																<i class="fa fa-calendar"></i>

														        <?php $event_start_date = get_post_meta(get_the_ID(), 'event_start_date', true); $event_start_time = get_post_meta(get_the_ID(), 'event_start_time', true); if(!empty($event_start_date)) { ?>

														        <?php

																	global $redux_demo; 
																	if(isset($redux_demo['events-date-format'])) {
																		$time_format = $redux_demo['events-date-format'];
																		if($time_format == 1) {

																?>

																	<?php $start_unix_time = strtotime($event_start_date); $start_date = date("m/d/Y",$start_unix_time); ?>

																	<?php } elseif($time_format == 2) { ?>

																	<?php $start_unix_time = strtotime($event_start_date); $start_date = date("d/m/Y",$start_unix_time); ?>

																	<?php } } else { ?>

																	<?php $start_unix_time = strtotime($event_start_date); $start_date = date("m/d/Y",$start_unix_time); ?>

																<?php } ?>

																<?php

																	global $redux_demo; 
																	if(isset($redux_demo['events-time-format'])) {
																		$time_format = $redux_demo['events-time-format'];
																		if($time_format == 1) {

																?>

																	<?php $start_time = esc_attr($event_start_time); ?>

																	<?php } elseif($time_format == 2) { ?>

																	<?php $start_time = date("H:i", strtotime($event_start_time)); ?>

																	<?php } } else { ?>

																	<?php $start_time = esc_attr($event_start_time); ?>

																<?php } ?>

														        <span><?php echo esc_attr($start_date); ?> <?php echo esc_attr($start_time); ?></span>

														        <?php } ?>

															</div>

															<div class="listing-container-views">

																<i class="fa fa-eye"></i><span><?php echo esc_attr( themesdojo_getPostViews(get_the_ID()) ); ?></span>

															</div>

															<?php 

																$this_post_id = get_the_ID();

												      			$allFav = $wpdb->get_var( 'SELECT COUNT(*) FROM td_favorites WHERE listing_id = "'.$this_post_id.'" ' );

												      			if(empty($allFav)) {
												      				$allFav = 0;
												      			}

												      		?>

															<div class="listing-container-bookmarks">

																<i class="fa fa-heart"></i><span><?php echo esc_attr($allFav); ?></span>

															</div>

														</div>

													</div>

												</div>

											</div>

										</div>

									</div>

									<?php endwhile; ?>

									<div class="col-sm-12">

										<?php 

											global $wp_rewrite;			
											$custom_posts2->query_vars['paged'] > 1 ? $current = $custom_posts2->query_vars['paged'] : $current = 1;

											$td_pagination = array(
												'base' => esc_url_raw(@add_query_arg('page','%#%')),
												'format' => '',
												'total' => $custom_posts2->max_num_pages,
												'current' => $current,
												'show_all' => false,
												'type' => 'plain',
												);

											if( $wp_rewrite->using_permalinks() )
												$td_pagination['base'] = '#%#%';

											if( !empty($custom_posts2->query_vars['s']) )
												$td_pagination['add_args'] = array('s'=>get_query_var('s'));

											$total_pages = $custom_posts2->max_num_pages;

											if($total_pages > 1) {
												echo '<div class="pagination">' . paginate_links($td_pagination) . '</div>'; 
											}

										?>

									</div>

									<?php } else { ?>

										<div class="col-sm-12"><?php _e( 'No listings found.', 'themesdojo' ); ?></div>

									<?php } ?>

							</div>

							<div id="cat-listing-holder">

								<?php

									global $custom_posts2;
									$custom_posts2 = new WP_Query();
									$custom_posts2->query(array(
									    'post_type'      => 'event',
									    'posts_per_page' => '30',
									    'post_status'    => 'publish',
									    'meta_key'       => 'event_start_date_number',
									    'orderby'        => 'meta_value',
									    'order'          => 'ASC',
									    'event_tag'      => $tag_slug,
									    'meta_query' => array(
									            array(
									                'key'     => 'event_status',
									                'value'   => 'upcoming',
									            ),
									        ),
									    )
									);

									if ( $custom_posts2->have_posts() ) {

								?>

									<?php while ($custom_posts2->have_posts()) : $custom_posts2->the_post(); ?>

									<div class="col-sm-6">

										<?php 

										if(has_post_thumbnail()) { 

											$image_src_all = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), false, '' );

											$image_src = $image_src_all[0];

										} elseif(!empty($redux_default_img_bg)) { 

											$image_src = esc_url($redux_default_img_bg); 

										} else { 

											$image_src = esc_url(get_template_directory_uri())."/images/title-bg.jpg";

										} 

										?> 

										<div class="listing-container">

											<a class="listing-container-big-button" href="<?php the_permalink(); ?>"></a>
											
											<div class="listing-container-block" >

												<div class="listing-container-block-title">
													
													<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

													<span class="listing-container-tagline">

														<?php 

															$event_address_country = get_post_meta(get_the_ID(), 'event_address_country', true);
															$event_address_state = get_post_meta(get_the_ID(), 'event_address_state', true);
															$event_address_city = get_post_meta(get_the_ID(), 'event_address_city', true);
															$event_address_address = get_post_meta(get_the_ID(), 'event_address_address', true);
															$event_address_zip = get_post_meta(get_the_ID(), 'event_address_zip', true);
															$event_location = get_post_meta(get_the_ID(), 'event_location', true);

														?> 

														<i class="fa fa-map-marker"></i> 

														<?php if(!empty($event_location)) { ?>
															<?php echo esc_attr($event_location); ?><?php _e( ' - ', 'themesdojo' ); ?>
														<?php } ?>

														<?php if(!empty($event_address_address)) { ?>
															<?php echo esc_attr($event_address_address); ?><?php _e( ', ', 'themesdojo' ); ?>
														<?php } ?>

														<?php if(!empty($event_address_city)) { ?>
															<?php echo esc_attr($event_address_city); ?><?php _e( ', ', 'themesdojo' ); ?>
														<?php } ?>

														<?php if(!empty($event_address_state)) { ?>
															<?php echo esc_attr($event_address_state); ?><?php _e( ' ', 'themesdojo' ); ?>
														<?php } ?>

														<?php if(!empty($event_address_zip)) { ?>
															<?php echo esc_attr($event_address_zip); ?><?php _e( ', ', 'themesdojo' ); ?>
														<?php } ?>

														<?php if(!empty($event_address_country)) { ?>
															<?php echo esc_attr($event_address_country); ?>
														<?php } ?>

														<?php $event_phone = get_post_meta(get_the_ID(), 'event_phone', true); if(!empty($event_phone)) { ?>
														<span><i class="fa fa-phone"></i><?php echo esc_attr($event_phone); ?></span><?php } ?>

													</span>

												</div>

												<div class="listing-container-block-body">

													<div class="listing-container-views">

														<i class="fa fa-eye"></i><span><?php echo esc_attr( themesdojo_getPostViews(get_the_ID()) ); ?></span>

													</div>

													<?php

														global $wpdb, $all_reviews_media;
														$post_id = get_the_ID();
														$table_name = "td_reviews";

														if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {

															$all_reviews = $wpdb->get_var( "SELECT COUNT(*) FROM `td_reviews` WHERE listing_id = '".$post_id."' ORDER BY `ID` DESC");

															if(!empty($all_reviews) && $all_reviews != 0) {

																$all_reviews_media = $wpdb->get_results( "SELECT * FROM `td_reviews` WHERE listing_id = '".$post_id."' ORDER BY `ID` DESC");

																$review_media_total = 0;

																foreach ($all_reviews_media as $key) {

																	$review_media = $key->listing_review_values_med;

																	$review_media_total = $review_media_total + $review_media;

																}

																$review_overall = $review_media_total/$all_reviews;

															}

														}

													?>

													<div class="listing-container-rating">

														<i class="fa fa-calendar"></i>

														<?php $event_start_date = get_post_meta(get_the_ID(), 'event_start_date', true); $event_start_time = get_post_meta(get_the_ID(), 'event_start_time', true); $event_location = get_post_meta(get_the_ID(), 'event_location', true); if(!empty($event_start_date)) { ?>

														<?php

																	global $redux_demo; 
																	if(isset($redux_demo['events-date-format'])) {
																		$time_format = $redux_demo['events-date-format'];
																		if($time_format == 1) {

																?>

																	<?php $start_unix_time = strtotime($event_start_date); $start_date = date("m/d/Y",$start_unix_time); ?>

																	<?php } elseif($time_format == 2) { ?>

																	<?php $start_unix_time = strtotime($event_start_date); $start_date = date("d/m/Y",$start_unix_time); ?>

																	<?php } } else { ?>

																	<?php $start_unix_time = strtotime($event_start_date); $start_date = date("m/d/Y",$start_unix_time); ?>

																<?php } ?>

																<?php

																	global $redux_demo; 
																	if(isset($redux_demo['events-time-format'])) {
																		$time_format = $redux_demo['events-time-format'];
																		if($time_format == 1) {

																?>

																	<?php $start_time = esc_attr($event_start_time); ?>

																	<?php } elseif($time_format == 2) { ?>

																	<?php $start_time = date("H:i", strtotime($event_start_time)); ?>

																	<?php } } else { ?>

																	<?php $start_time = esc_attr($event_start_time); ?>

																<?php } ?>

														        <span><?php echo esc_attr($start_date); ?> <?php echo esc_attr($start_time); ?></span>

														<?php } ?>

													</div>

													<?php 

														$this_post_id = get_the_ID();

										      			$allFav = $wpdb->get_var( 'SELECT COUNT(*) FROM td_favorites WHERE listing_id = "'.$this_post_id.'" ' );

										      			if(empty($allFav)) {
										      				$allFav = 0;
										      			}

										      		?>

													<div class="listing-container-bookmarks">

														<i class="fa fa-heart"></i><span><?php echo esc_attr($allFav); ?></span>

													</div>

												</div>

											</div>

											<div class="listing-container-black-shadow"></div>

											<div class="listing-container-image-bg" style="background: #fff url(<?php echo esc_url($image_src); ?>) no-repeat center center;"></div>

										</div>

									</div>

									<?php endwhile; ?>

									<div class="col-sm-12">

										<?php 

											global $wp_rewrite;			
											$custom_posts2->query_vars['paged'] > 1 ? $current = $custom_posts2->query_vars['paged'] : $current = 1;

											$td_pagination = array(
												'base' => esc_url_raw(@add_query_arg('page','%#%')),
												'format' => '',
												'total' => $custom_posts2->max_num_pages,
												'current' => $current,
												'show_all' => false,
												'type' => 'plain',
												);

											if( $wp_rewrite->using_permalinks() )
												$td_pagination['base'] = '#%#%';

											if( !empty($custom_posts2->query_vars['s']) )
												$td_pagination['add_args'] = array('s'=>get_query_var('s'));

											$total_pages = $custom_posts2->max_num_pages;

											if($total_pages > 1) {
												echo '<div class="pagination">' . paginate_links($td_pagination) . '</div>'; 
											}

										?>

									</div>

									<?php } else { ?>

										<div class="col-sm-12"><?php _e( 'No listings found.', 'themesdojo' ); ?></div>

									<?php } ?>

							</div>

						</div>

					</div>

					<div class="col-sm-4">

						<div class="widget-container widget_search">

							<form id="td-filter-listings" type="post" action="" >

										<div class="row">

											<div class="col-sm-12">

												<input type="text" name="filterKeywords" id="filterKeywords" value="" class="input-textarea" placeholder='<?php _e( "Keywords", "themesdojo" ); ?>' />

											</div>

											<div class="col-sm-12">

												<select id="listingFormTime" name="listingFormTime">

													<option value=""><?php _e( "Any Time", "themesdojo" ); ?></option>
													<option value="1"><?php _e( "Today", "themesdojo" ); ?></option>
													<option value="2"><?php _e( "This Week", "themesdojo" ); ?></option>
													<option value="3"><?php _e( "This Month", "themesdojo" ); ?></option>

												</select>

											</div>

											<div class="col-sm-12">

												<select id="listingFormCat" name="category">

													<option value=""><?php _e( "Any Category", "themesdojo" ); ?></option>

													<?php

														$categories = get_categories( array('taxonomy' => 'event_cat', 'hide_empty' => false,  'parent' => 0) );

														foreach ($categories as $category) {
															$option = '<option value="'.$category->slug.'">';
															$option .= $category->cat_name;
															$option .= '</option>';

															$catID = $category->term_id;

															$categories_child = get_categories( array('taxonomy' => 'event_cat', 'hide_empty' => false,  'parent' => $catID) );

															foreach ($categories_child as $category_child) {
																$option .= '<option value="'.$category_child->slug.'"> - ';
																$option .= $category_child->cat_name;
																$option .= '</option>';

															}

															echo $option;
														}

													?>

												</select>

											</div>

											<div class="col-sm-12">

												<select id="listingFormLoc" name="listingFormLoc">

													<option value=""><?php _e( "Any Location", "themesdojo" ); ?></option>

													<?php

														$categories = get_categories( array('taxonomy' => 'event_loc', 'hide_empty' => false,  'parent' => 0) );

														foreach ($categories as $category) {
															$option = '<option value="'.$category->slug.'">';
															$option .= $category->cat_name;
															$option .= '</option>';

															$catID = $category->term_id;

															$categories_child = get_categories( array('taxonomy' => 'event_loc', 'hide_empty' => false,  'parent' => $catID) );

															foreach ($categories_child as $category_child) {
																$option .= '<option value="'.$category_child->slug.'"> - ';
																$option .= $category_child->cat_name;
																$option .= '</option>';

															}

															echo $option;
														}

													?>

												</select>

												<input type="hidden" id="latitude" name="event_address_latitude" value="<?php if(!empty($event_address_latitude)) { echo esc_attr($event_address_latitude); } ?>" size="12" class="form-text required">
												<input type="hidden" id="longitude" name="event_address_longitude" value="<?php if(!empty($event_address_longitude)) { echo esc_attr($event_address_longitude); } ?>" size="12" class="form-text required">

												<div id="advance-search-slider" class="value-slider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false">
													<a class="ui-slider-handle ui-state-default ui-corner-all" href="#">
														<span class="range-pin">
															<input type="text" name="geo-radius" id="geo-radius" value="100" data-default-value="100">
														</span>
													</a>
												</div>

												<div id="map-script-holder">

													<script type="text/javascript">

														jQuery(document).ready(function($) {

															var geocoder;
															var map;
															var marker;
															var markers = [];

															var geocoder = new google.maps.Geocoder();

															function geocodePosition(pos) {
																geocoder.geocode({
																latLng: pos
																}, function(responses) {
																	if (responses && responses.length > 0) {
																		updateMarkerAddress(responses[0].formatted_address);
																	} else {
																		updateMarkerAddress('Cannot determine address at this location.');
																	}
																});

																jQuery('.locate-me').removeClass('loading');
																jQuery('.locate-me').removeClass('fa-spin');
															}

															function updateMarkerPosition(latLng) {
																jQuery('#latitude').val(latLng.lat());
																jQuery('#longitude').val(latLng.lng());
																jQuery( "#advance-search-slider" ).css("display", "inline-block");
															}

															function updateMarkerAddress(str) {
																jQuery('#filterLocation').val(str);
															}

															function initialize() {

																var latlng = new google.maps.LatLng(<?php if(empty($event_address_latitude)) { ?>40.7127837<?php } else { echo esc_attr($event_address_latitude); } ?>, <?php if(empty($event_address_longitude)) { ?>-74.00594130000002<?php } else { echo esc_attr($event_address_longitude); } ?>);
																	var mapOptions = {
																		zoom: 16,
																		scrollwheel: false,
																		<?php global $redux_demo; $map_style = $redux_demo['map-style']; if(!empty($map_style)) { ?>styles: <?php echo $map_style; ?>, <?php } ?>
																		center: latlng
																}

																map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

																var oms = new OverlappingMarkerSpiderfier(map);

														      	oms.addListener('spiderfy', function(markers) {
														      	});
														      	oms.addListener('unspiderfy', function(markers) {
														     	});

																geocoder = new google.maps.Geocoder();

																var infowindow = new google.maps.InfoWindow(); 
															    //var marker, i;
															    var bounds = new google.maps.LatLngBounds();

																<?php

																	if ( $custom_posts->have_posts() ) {

																		while ($custom_posts->have_posts()) : $custom_posts->the_post();

																		$event_address_latitude = get_post_meta(get_the_ID(), 'event_address_latitude', true);
																		$event_address_longitude = get_post_meta(get_the_ID(), 'event_address_longitude', true);

																		$theTitle = get_the_title(); $theTitle = (strlen($theTitle) > 40) ? substr($theTitle,0,37).'...' : $theTitle;

																		if(!empty($event_address_latitude) AND $event_address_latitude != 0) {

																			$post_id = get_the_ID();

																			$terms = get_the_terms($post_id, 'event_cat' );
																			if ($terms && ! is_wp_error($terms)) :
																				$term_slugs_arr = array();
																				foreach ($terms as $term) {
																					$term_id_arr = $term->term_id;
																					$parent      = $term->parent;
																				}
																			endif;

															        		$cat_id = $term_id_arr;

																			if($parent == 0) {

																				$tag = $cat_id;

																				$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
																				$your_image_url = isset( $tag_extra_fields[$tag]['your_image_url'] ) ? esc_attr( $tag_extra_fields[$tag]['your_image_url'] ) : '';

																			} else {

																				$term_id = $cat_id; //Get ID of current term
																				$ancestors = get_ancestors( $term_id, 'event_cat' ); // Get a list of ancestors
																				$ancestors = array_reverse($ancestors); //Reverse the array to put the top level ancestor first
																				$ancestors[0] ? $top_term_id = $ancestors[0] : $top_term_id = $term_id; //Check if there is an ancestor, else use id of current term
																				$term = get_term( $top_term_id, 'event_cat' ); //Get the term
																				$tag = $term->term_id;

																				$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
																				$your_image_url = isset( $tag_extra_fields[$tag]['your_image_url'] ) ? esc_attr( $tag_extra_fields[$tag]['your_image_url'] ) : '';

																			}

																			if(!empty($your_image_url)) {

																				$iconPath = $your_image_url;

																			} else {

																				$iconPath = get_template_directory_uri() .'/images/icon-services.png';

																			} 

																			$terms = get_the_terms(get_the_ID(), 'event_cat' );
																			if ($terms && ! is_wp_error($terms)) :
																				$term_slugs_arr = array();
																				foreach ($terms as $term) {
																				    $term_slugs_arr[] = $term->name;
																				}
																				$terms_slug_str_cat = join( " ", $term_slugs_arr);
																			endif;

																
																?> 

																<?php $event_start_date = get_post_meta(get_the_ID(), 'event_start_date', true); $event_start_time = get_post_meta(get_the_ID(), 'event_start_time', true); $event_location = get_post_meta(get_the_ID(), 'event_location', true); ?>

																<?php

																	global $redux_demo; 
																	if(isset($redux_demo['events-date-format'])) {
																		$time_format = $redux_demo['events-date-format'];
																		if($time_format == 1) {

																?>

																	<?php $start_unix_time = strtotime($event_start_date); $start_date = date("m/d/Y",$start_unix_time); ?>

																	<?php } elseif($time_format == 2) { ?>

																	<?php $start_unix_time = strtotime($event_start_date); $start_date = date("d/m/Y",$start_unix_time); ?>

																	<?php } } else { ?>

																	<?php $start_unix_time = strtotime($event_start_date); $start_date = date("m/d/Y",$start_unix_time); ?>

																<?php } ?>

																<?php

																	global $redux_demo; 
																	if(isset($redux_demo['events-time-format'])) {
																		$time_format = $redux_demo['events-time-format'];
																		if($time_format == 1) {

																?>

																	<?php $start_time = esc_attr($event_start_time); ?>

																	<?php } elseif($time_format == 2) { ?>

																	<?php $start_time = date("H:i", strtotime($event_start_time)); ?>

																	<?php } } else { ?>

																	<?php $start_time = esc_attr($event_start_time); ?>

																<?php } ?>

																<?php

																	if(has_post_thumbnail()) { 

																		$image_src_all = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), false, '' );

																		$image_src = $image_src_all[0];

																	} elseif(!empty($redux_default_img_bg)) { 

																		$image_src = esc_url($redux_default_img_bg); 

																	} else { 

																		$image_src = esc_url(get_template_directory_uri())."/images/title-bg.jpg";

																	}

																?>

																<?php get_template_part( 'inc/BFI_Thumb' ); ?>
																<?php $params = array( "width" => 100, "height" => 100, "crop" => true ); ?>

															        var siteLatLng = new google.maps.LatLng(<?php echo esc_attr($event_address_latitude); ?>, <?php echo esc_attr($event_address_longitude); ?>);
														            var marker = new google.maps.Marker({
														                position: siteLatLng,
														                map: map,
														                title: '<?php echo esc_attr($theTitle); ?>',
														                html: '<div class="marker-holder"><div class="marker-content"><div class="marker-image"><img src="<?php echo bfi_thumb( "$image_src", $params ) ?>" /></div><div class="marker-info-holder"><div class="marker-info"><div class="marker-info-title"><a href="<?php the_permalink(); ?>"><?php echo esc_attr($theTitle); ?></a><span class="marker-meta"><?php echo esc_attr($event_location); ?> - <?php echo esc_attr($start_date); ?> <?php echo esc_attr($start_time); ?></span><span class="marker-meta"><i class="fa fa-folder-o"></i><?php echo esc_attr($terms_slug_str_cat); ?></span></div></div></div><div class="close"></div></div></div>',
														                icon: '<?php echo esc_url($iconPath); ?>'
														            });

														            var contentString = "...";

														            google.maps.event.addListener(marker, "click", function () {
														                infowindow.setContent(this.html);
														                infowindow.open(map, this);
														            });
														            bounds.extend(siteLatLng);
														            markers.push(marker);
														            oms.addMarker(marker);
																<?php } endwhile; } ?>	
																map.fitBounds(bounds);
																jQuery(".only-map-page #map-canvas-shadow").css("display","none");
																var markerCluster = new MarkerClusterer(map, markers, { maxZoom: 9 });

															}

															$.fn.tdClearMap = function() {
														        //Loop through all the markers and remove
														        for (var i = 0; i < markers.length; i++) {
														            markers[i].setMap(null);
														        }
														        markers = [];
														    };

															//google.maps.event.addDomListener(window, 'load', initialize);

															jQuery(document).ready(function() { 
																						         
																initialize();
																						          
																jQuery(function() {
																	jQuery("#filterLocation").autocomplete({
																	//This bit uses the geocoder to fetch address values
																	source: function(request, response) {
																		geocoder.geocode( {'address': request.term }, function(results, status) {
																			response(jQuery.map(results, function(item) {
																				return {
																					label:  item.formatted_address,
																					value: item.formatted_address,
																					latitude: item.geometry.location.lat(),
																					longitude: item.geometry.location.lng()
																				}
																			}));
																		})
																	},
																	//This bit is executed upon selection of an address
																	select: function(event, ui) {
																		jQuery("#latitude").val(ui.item.latitude);
																		jQuery("#longitude").val(ui.item.longitude);
																		jQuery( "#advance-search-slider" ).css("display", "inline-block");

																		var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);

																	}
																});
															});

															jQuery(document).on('click','.locate-me', function() {

																jQuery(this).addClass('loading');
																jQuery(this).addClass('fa-spin');

																navigator.geolocation.getCurrentPosition(function(position) {
															      	var pos = new google.maps.LatLng(position.coords.latitude,  position.coords.longitude);
															      	geocodePosition(pos);
																	jQuery('#latitude').val(position.coords.latitude);
																	jQuery('#longitude').val(position.coords.longitude);
																	jQuery( "#advance-search-slider" ).css("display", "inline-block");
															    });
																				
															});

														});

														jQuery( "#advance-search-slider" ).slider({
													      	range: "min",
													      	value: 100,
													      	min: 1,
													      	max: <?php echo esc_attr($maximRange); ?>,
													      	slide: function( event, ui ) {
													       		jQuery( "#geo-radius" ).val( ui.value );
													       		jQuery( "#geo-radius-search" ).val( ui.value );
													      	}
													    });
													    jQuery( "#geo-radius" ).val( jQuery( "#advance-search-slider" ).slider( "value" ) );
													    jQuery( "#geo-radius-search" ).val( jQuery( "#advance-search-slider" ).slider( "value" ) );

														});

													</script>

												</div>

											</div>

											<div class="col-sm-12">

												<div class="filter-by-tag-holder">

													<div class="row">

														<div class="col-sm-12">

															<span id="tags-block-expand" class="td-buttom collapsed"  data-toggle="collapse" data-target="#main-settings-block" style="float: left; width: 100%; margin-bottom: 30px; text-align: center;">

																<i class="fa fa-filter"></i>
																<span><?php _e( 'Advanced Filters', 'themesdojo' ); ?></span>

															</span>

														</div>

														<div class="col-sm-12">

															<div id="main-settings-block" class="collapse">

																<div class="row filter-by-tag">

																	<?php $tags = get_terms('event_tag'); if(!empty($tags)) { ?>

																		<?php

																			$term = $wp_query->get_queried_object(); 
																			$term_id = $term->term_id;
																			$term_slug = $term->slug;

																			foreach ( (array) $tags as $tag ) {

																				$current_slug = $tag->slug;

																		?>

																			<div class="col-sm-12 tag-filter-item">

																				<a id="tag-id-<?php echo esc_attr($current_slug); ?>" href="#" class="tag-filter <?php if($current_slug == $term_slug) { ?>active<?php } ?>" title="<?php echo esc_attr($tag->slug); ?>" name="<?php echo esc_attr($tag->slug); ?>" ><span class="tag-filter-icon"></span><span class="tag-filter-title"><?php echo esc_attr($tag->name); ?></span></a>

																			</div>

																		<?php
																			}

																		?>

																	<?php } ?>

																	<div id="filter-tags-holder">

																		<?php

																			$term = $wp_query->get_queried_object();
																			$term_slug = $term->slug;

																		?>
																		<input class="tag-name-<?php echo esc_attr($term_slug); ?>" type="hidden" name="cat_tag[]" value="<?php echo esc_attr($term_slug); ?>">
																	</div>

																	<script type="text/javascript">

																		jQuery(document).ready(function($) {

																			jQuery(document).on('click','a.tag-filter', function(e) {

																				e.preventDefault();

																				var tag_name = jQuery(this).attr('title');
																				var tag_slug = jQuery(this).attr('name');

																				if ( jQuery(this).hasClass('active') ) {

																	                jQuery(this).removeClass('active');

																	                jQuery('#filter-tags-holder .tag-name-'+tag_slug).remove();

																	            } else {

																	                jQuery(this).addClass('active');

																	                jQuery("#filter-tags-holder").append('<input class="tag-name-'+tag_slug+'" type="hidden" name="cat_tag[]" value="'+tag_name+'">');

																	            }

																	            $.fn.tdSubmitFilter();

																				$.fn.tdSubmitFilterList();

																				$.fn.tdSubmitFilterMap();
																							
																			});

																		});

																	</script>

																</div>

															</div>

														</div>

													</div>

												</div>

											</div>

											<div class="full-width-buttons col-sm-12">

												<button class="td-buttom" id="submit-filter" name="submit" type="submit"><i class="fa fa-check"></i><?php _e( 'Update Listings', 'themesdojo' ); ?></button>

												<button class="td-buttom" id="reset-filter" name="submit" type="submit" style="margin-bottom: 0!important"><i class="fa fa-times"></i><?php _e( 'Reset', 'themesdojo' ); ?></button>

											</div>

										</div>

										<?php

											$term = $wp_query->get_queried_object(); 
											$term_id = $term->slug;

										?>

										<input type="hidden" id="my_listings_current_page" name="my_listings_current_page" value="1" />
										<input type="hidden" id="content_type" name="content_type" value="" />

										<?php

											$term = $wp_query->get_queried_object();
											$term_slug = $term->slug;

										?>

										<input type="hidden" id="current_tag_slug" name="current_tag_slug" value="<?php echo esc_attr($term_slug); ?>" />

										<input type="hidden" name="action" value="tdEventsFilterForm" />
										<?php wp_nonce_field( 'tdEventsFilter_html', 'tdEventsFilter_nonce' ); ?>

							</form>

							<script type="text/javascript">

										jQuery(function($) {

											jQuery(document).on('click','#reset-filter', function(e) {

												jQuery('#my_listings_current_page').val('1');
												jQuery('#filterKeywords').val('');
												jQuery('#filterLocation').val('');
												jQuery('#listingFormLoc').val('');
												jQuery('#listingFormCat').val('');
												jQuery('#latitude').val('');
												jQuery('#longitude').val('');
												jQuery('.tag-filter').removeClass('active');
												jQuery('#filter-tags-holder input').remove();
												jQuery( "#advance-search-slider" ).css("display", "none");

												var current_tag = jQuery("#current_tag_slug").val();
												jQuery("#filter-tags-holder").append('<input class="tag-name-'+current_tag+'" type="hidden" name="cat_tag[]" value="'+current_tag+'">');
												jQuery("#tag-id-"+current_tag+"").addClass("active");

												$.fn.tdSubmitFilter();

												$.fn.tdSubmitFilterList();

												$.fn.tdSubmitFilterMap();

												e.preventDefault();

											});

											jQuery(document).on('click','#submit-filter', function(e) {

												$.fn.tdSubmitFilter();

												$.fn.tdSubmitFilterList();

												$.fn.tdSubmitFilterMap();

												e.preventDefault();

											});

											jQuery(document).on("click",".pagination a.page-numbers",function(e){

												var hrefprim = jQuery(this).attr('href');
												var href = hrefprim.replace("#", "");

								                jQuery('#my_listings_current_page').val(href);

												$.fn.tdSubmitFilter();

												$.fn.tdSubmitFilterList();

												$.fn.tdSubmitFilterMap();

												e.preventDefault();
												return false;

											});

											$.fn.tdSubmitFilter = function() {

												jQuery('#content_type').val('grid-sidebar');

												jQuery('#td-filter-listings').ajaxSubmit({
													type: "POST",
													data: jQuery('#td-filter-listings').serialize(),
													url: '<?php echo admin_url('admin-ajax.php'); ?>',
													beforeSend: function() { 
														jQuery("#cat-listing-holder").css("opacity", "0");
														jQuery(".listing-loading").fadeIn(200);
													},	 
													success: function(response) {
														jQuery("#cat-listing-holder").html(response);
														jQuery("#cat-listing-holder").css("opacity", "1");
														jQuery(".listing-loading").css("display", "none");
														var total_items = jQuery("#total_items").val();
														jQuery(".page-title-aright span").html(total_items);
													}
												});

											}

											$.fn.tdSubmitFilterList = function() {

												jQuery('#content_type').val('list-sidebar');

												jQuery('#td-filter-listings').ajaxSubmit({
													type: "POST",
													data: jQuery('#td-filter-listings').serialize(),
													url: '<?php echo admin_url('admin-ajax.php'); ?>',
													beforeSend: function() { 
														jQuery("#cat-listing-list-holder").css("opacity", "0");
														jQuery(".listing-loading").fadeIn(200);
													},	 
													success: function(response) {
														jQuery("#cat-listing-list-holder").html(response);
														jQuery("#cat-listing-list-holder").css("opacity", "1");
														jQuery(".listing-loading").css("display", "none");
														var total_items = jQuery("#total_items").val();
														jQuery(".page-title-aright span").html(total_items);
													}
												});

											}

											$.fn.tdSubmitFilterMap = function() {

												$.fn.tdClearMap();

												jQuery('#content_type').val('map');

												jQuery('#td-filter-listings').ajaxSubmit({
													type: "POST",
													data: jQuery('#td-filter-listings').serialize(),
													url: '<?php echo admin_url('admin-ajax.php'); ?>',
													beforeSend: function() { 
														jQuery("#map-script-holder").html("");
													},	 
													success: function(response) {
														jQuery('#map-canvas-holder').css('display', 'block');
														jQuery("#map-script-holder").html(response);
														if (jQuery("#map-canvas-holder").hasClass("hide-map")) {
															jQuery('#map-canvas-holder').css('display', 'none');
														}
													}
												});

											}


										});

							</script>

						</div>

						<?php get_sidebar('event'); ?>

					</div>

				</section>

			</div>

		</div>

<?php get_footer(); ?>
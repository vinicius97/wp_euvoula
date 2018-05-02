<?php
/**
 * Template for event location category
 */

global $main_cat_id;
$term = $wp_query->get_queried_object(); 
$parent = $term->parent;
$main_cat_id = $term->term_id;

if($parent == 0) {

	$tag = $main_cat_id;

	$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
	$category_page_template = isset( $tag_extra_fields[$tag]['category_page_template'] ) ? esc_attr( $tag_extra_fields[$tag]['category_page_template'] ) : '';

} else {

	$term_id = $main_cat_id; //Get ID of current term
	$ancestors = get_ancestors( $term_id, 'event_place' ); // Get a list of ancestors
	$ancestors = array_reverse($ancestors); //Reverse the array to put the top level ancestor first
	$ancestors[0] ? $top_term_id = $ancestors[0] : $top_term_id = $term_id; //Check if there is an ancestor, else use id of current term
	$term = get_term( $top_term_id, 'event_place' ); //Get the term
	$tag = $term->term_id;

	$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
	$category_page_template = isset( $tag_extra_fields[$tag]['category_page_template'] ) ? esc_attr( $tag_extra_fields[$tag]['category_page_template'] ) : '';

}

get_header();

themesdojo_load_map_scripts();

global $redux_demo, $main_cat_id; 
if(isset($redux_demo['title-image-bg']['url'])) { $redux_default_img_bg = $redux_demo['title-image-bg']['url']; } 

global $redux_demo, $maximRange; 
$max_range = $redux_demo['max_range'];
if(!empty($max_range)) {
	$maximRange = $max_range;
} else {
	$maximRange = 1000;
}

$term = $wp_query->get_queried_object(); 
$main_cat_id = $term->slug;

$custom_posts = new WP_Query();
$custom_posts->query(array(
    'post_type'      => 'event',
    'posts_per_page' => '-1',
    'post_status'    => 'publish',
    'event_place'      => $main_cat_id,
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

						<div class="item-block-title-events">

							<div class="row">

								<div class="col-sm-12">

									<div class="full title-pl">

										<h4><i class="fa fa-calendar-check-o" aria-hidden="true"></i><?php esc_html_e("Upcoming events at ", "themesdojo"); ?> <?php printf( __( ' %s', '' ), '' . single_cat_title( '', false ) . '' );	?></h4>

									</div>

								</div>

							</div>

						</div>

					</div>

					<div class="col-sm-12">

						<div id="map-canvas-holder" style="height: 0; opacity: 0;">

							<div id="map-canvas" style="height: 660px;"></div>

						</div>

						<div class="row">

							<div class="col-sm-12"><noscript><?php _e( 'Your browser does not support JavaScript, or it is disabled. JavaScript must be enabled in order to view listings.', 'themesdojo' ); ?></noscript></div>

							<div class="col-sm-12"><div class="listing-loading"><h3><i class="fa fa-spinner fa-spin"></i></h3></div></div>

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
									    'event_place'      => $main_cat_id,
									    'meta_query' => array(
									            array(
									                'key'     => 'event_status',
									                'value'   => 'upcoming',
									            ),
									        ),
									    )
									);

									$currentEvent = 0;

									if ( $custom_posts2->have_posts() ) {

								?>

									<?php while ($custom_posts2->have_posts()) : $custom_posts2->the_post(); $currentEvent++; ?>

									<div class="col-sm-12 event-block id-<?php echo get_the_ID(); ?>">

								                <div class="upcoming-events-v2">

								                    <a class="upcoming-events-big-button" href="<?php the_permalink(); ?>"></a>

								                    <div class="row">

								                        <div class="col-sm-2 upcoming-events-number">

								                            <h2><?php if($currentEvent <= 9) { ?>0<?php } ?><?php echo $currentEvent; ?></h2>

								                        </div>

								                        <div class="col-sm-5 upcoming-events-title">

								                            <div class="upcoming-events-avatar">

								                                <?php 

								                                    if(has_post_thumbnail()) { 

								                                      $image_src_all = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), false, '' );

								                                      $image_src = $image_src_all[0];

								                                    } elseif(!empty($redux_default_img_bg)) { 

								                                      $image_src = esc_url($redux_default_img_bg); 

								                                    } else { 

								                                      $image_src = esc_url(get_template_directory_uri())."/images/title-bg.jpg";

								                                    } 

								                                    get_template_part( 'inc/BFI_Thumb' );
								                                    $params = array( 'width' => 71, 'height' => 71, 'crop' => true );

								                                ?> 

								                                <img src="<?php echo bfi_thumb( $image_src, $params ); ?>" alt="" />  

								                            </div>

								                            <div class="upcoming-events-title-cont">

								                                <h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>

								                                <?php 

								                                    $postID = get_the_ID();

								                                    $terms = get_the_terms($postID, 'event_cat' );
								                                    if ($terms && ! is_wp_error($terms)) :
								                                        $term_slugs_arr = array();
								                                        foreach ($terms as $term) {
								                                            $term_slugs_arr[] = $term->name;
								                                        }
								                                        $terms_slug_str = join( " ", $term_slugs_arr);
								                                    endif; 

								                                ?>

								                                <span><i class="fa fa-folder-open"></i><?php echo esc_attr($terms_slug_str); ?></span>

								                            </div>

								                        </div>

								                        <div class="col-sm-5 upcoming-events-details">

								                            <div class="full">

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

								                            <?php if(!empty($event_address_city)) { ?>
								                                <?php echo esc_attr($event_address_city); ?><?php _e( ', ', 'themesdojo' ); ?>
								                            <?php } ?>

								                            <?php if(!empty($event_address_country)) { ?>
								                                <?php echo esc_attr($event_address_country); ?>
								                            <?php } ?>

								                            </div>

								                            <div class="full">

								                            <?php $event_phone = get_post_meta(get_the_ID(), 'event_phone', true); if(!empty($event_phone)) { ?>
								                            <span><i class="fa fa-phone"></i><?php echo esc_attr($event_phone); ?></span><?php } ?>

								                            </div>

								                            <div class="full">

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

									<?php
										$queried_object = get_queried_object();
										$cat_queried_term_id = $queried_object->term_id;
										$cat_queried_term_name = $queried_object->name;
										$cat_queried_term_desc = $queried_object->description;

									?>
									<div class="col-sm-12 cat-block-cont-place">

										<div class="item-block-title">

											<h4><i class="fa fa-bookmark"></i><?php echo esc_html($cat_queried_term_name) ?> <?php esc_html_e('Description', 'eventbuilder') ?></h4>

										</div>

										<div class="item-block-content">

											<div class="row desc-cont">

												<?php echo esc_html($cat_queried_term_desc); ?>

											</div>

										</div>

									</div>

									<?php
										$queried_object = get_queried_object();
										$cat_queried_term_id = $queried_object->term_id;
										$cat_queried_term_name = $queried_object->name;
										$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
										$cat_paces_event_location = $tag_extra_fields[$cat_queried_term_id]['cat_paces_event_location'];
										$cat_paces_event_location_address = $tag_extra_fields[$cat_queried_term_id]['cat_paces_event_location_address'];
										$cat_paces_event_location_phone = $tag_extra_fields[$cat_queried_term_id]['cat_paces_event_location_phone'];
										$cat_paces_event_location_site = $tag_extra_fields[$cat_queried_term_id]['cat_paces_event_location_site'];
										$cat_paces_event_location_facebook = $tag_extra_fields[$cat_queried_term_id]['cat_paces_event_location_facebook'];
										$cat_paces_event_location_instagram = $tag_extra_fields[$cat_queried_term_id]['cat_paces_event_location_instagram'];
										$cat_paces_event_location_dribbble = $tag_extra_fields[$cat_queried_term_id]['cat_paces_event_location_dribbble'];
										$cat_paces_event_location_c_btn = $tag_extra_fields[$cat_queried_term_id]['cat_paces_event_location_c_btn'];
										$cat_paces_event_location_maps_lat = $tag_extra_fields[$cat_queried_term_id]['cat_paces_event_location_maps_lat'];
										$cat_paces_event_location_maps_long = $tag_extra_fields[$cat_queried_term_id]['cat_paces_event_location_maps_long'];
										$cat_paces_event_location_maps_zoom = $tag_extra_fields[$cat_queried_term_id]['cat_paces_event_location_maps_zoom'];

									?>

									<div class="col-sm-12 cat-block-cont-place">

										<div class="item-block-title">

											<h4><i class="fa fa-bookmark"></i><?php echo esc_html($cat_queried_term_name) ?> <?php esc_html_e('& Contact Information', 'eventbuilder') ?></h4>

										</div>

										<div class="item-block-content">

											<div class="row desc-cont">

												<div class="col-md-6">
													<div class="row">
														<div class="col-md-6 loc-info-block-left">
															<?php if(!empty($cat_paces_event_location_address) OR !empty($cat_paces_event_location)) { ?>
																<div class="loc-info-block-left">
																	<i class="fa fa-map-marker" aria-hidden="true"></i>
																	<p><?php echo esc_html($cat_paces_event_location_address); ?></p>
																	<p><?php echo esc_html($cat_paces_event_location); ?></p>
																</div>
															<?php } ?>
															<?php if(!empty($cat_paces_event_location_phone) OR !empty($cat_paces_event_location_site)) { ?>
																<div class="loc-info-block-left">
																	<i class="fa fa-phone" aria-hidden="true"></i>
																	<p><a href="tell:<?php echo esc_html($cat_paces_event_location_phone); ?>"><?php echo esc_html($cat_paces_event_location_phone); ?></p></a>
																	<i class="fa fa-link" aria-hidden="true"></i>
																	<p style="margin-left:15px"><a href="<?php echo esc_url($cat_paces_event_location_site); ?>"><?php echo esc_html($cat_paces_event_location_site); ?></a></p>
																</div>
															<?php } ?>
															<?php if(!empty($cat_paces_event_location_c_btn)) { ?>
																<a href="<?php echo esc_url($cat_paces_event_location_c_btn) ?>">
																	<span id="contact-owner" class="td-buttom loc-info-block-left-bt">
																		<i class="fa fa-paper-plane"></i><?php esc_html_e("Contact for reservation", "eventbuilder"); ?>
																	</span>
																</a>
															<?php } ?>
														</div>
														<div class="col-md-6">
															<ul class="item-social-links">
																<?php if(!empty($cat_paces_event_location_facebook)) { ?>
																	<li class="pull-right item-social-facebook" style="float:right !important;">
																		<a rel="external" href="<?php echo esc_url($cat_paces_event_location_facebook) ?>" target="_blank"><i class="fa fa-facebook"></i></a>
																	</li>
																<?php } ?>
																<?php if(!empty($cat_paces_event_location_instagram)) { ?>
																	<li class="pull-right item-social-twitter" style="float:right !important;">
																		<a rel="external" href="<?php echo esc_url($cat_paces_event_location_instagram) ?>" target="_blank"><i class="fa fa-instagram"></i></a>
																	</li>
																<?php } ?>
																<?php if(!empty($cat_paces_event_location_dribbble)) { ?>
																	<li class="pull-right item-social-dribbble" style="float:right !important;">
																		<a rel="external" href="<?php echo esc_url($cat_paces_event_location_dribbble) ?>" target="_blank"><i class="fa fa-dribbble"></i></a>
																	</li>
																<?php } ?>
															</ul>
														</div>
													</div>
												</div>
												<?php if(!empty($cat_paces_event_location_maps_lat) AND !empty($cat_paces_event_location_maps_lat)) { ?>
													<div class="col-md-6">
														<div id="places-map-holder"></div>
													</div>
												<?php } ?>
											</div>

										</div>

									</div>

							</div>

						</div>

					</div>

					<div class="col-sm-12">

						<div class="item-block-title-events">

							<div class="row">

								<div class="col-sm-12">

									<div class="full title-pl">

										<h4><i class="fa fa-map-signs" aria-hidden="true"></i><?php esc_html_e("Other Places near at ", "themesdojo"); ?> <?php printf( __( ' %s', '' ), '' . single_cat_title( '', false ) . '' );	?></h4>

									</div>

								</div>

							</div>

						</div>

					</div>



				</section>

			</div>
			<div class="map-full-width-cat-place-container" id="map2"> maps</div>
		</div>

		<script> 

						var mapDiv,
							map,
							infobox;
						jQuery(document).ready(function($) {

							var fenway = new google.maps.LatLng(<?php echo esc_attr($cat_paces_event_location_maps_lat); ?>,<?php echo esc_attr($cat_paces_event_location_maps_long); ?>);

							mapDiv = $("#places-map-holder");
							mapDiv.height(400).gmap3({
								map: {
									options: {
										"center": [<?php echo esc_attr($cat_paces_event_location_maps_lat); ?>,<?php echo esc_attr($cat_paces_event_location_maps_long); ?>]
										,"zoom": <?php echo esc_attr($cat_paces_event_location_maps_zoom) ?>
										,"draggable": true
										,"mapTypeControl": true
										,"mapTypeId": google.maps.MapTypeId.ROADMAP
										,"scrollwheel": false
										,"panControl": true
										,"rotateControl": false
										,"scaleControl": true
										,"streetViewControl": true
										,"zoomControl": true
										<?php global $redux_demo; $map_style = $redux_demo['map-style']; if(!empty($map_style)) { ?>,"styles": <?php echo $map_style; ?> <?php } ?>
									}
								}
								,marker: {
									values: [

									<?php $iconPath = get_template_directory_uri() .'/images/icon-services.png'; ?>

									{
										<?php get_template_part( 'inc/BFI_Thumb' ); ?>
										<?php $params = array( "width" => 230, "height" => 150, "crop" => true ); $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "single-post-thumbnail" ); ?>

										latLng: [<?php echo esc_attr($cat_paces_event_location_maps_lat); ?>,<?php echo esc_attr($cat_paces_event_location_maps_long); ?>],
										options: {
											icon: "<?php echo esc_url($iconPath); ?>",
											shadow: "<?php echo get_template_directory_uri() ?>/images/shadow.png",
										}
									},
									{
										<?php get_template_part( 'inc/BFI_Thumb' ); ?>
										<?php $params = array( "width" => 230, "height" => 150, "crop" => true ); $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "single-post-thumbnail" ); ?>

										latLng: [47.177350, 27.594863],
										options: {
											icon: "<?php echo esc_url($iconPath); ?>",
											shadow: "<?php echo get_template_directory_uri() ?>/images/shadow.png",
										}
									}	
										
									],
									options:{
										draggable: false
									}
								},
								marker: {
									values: [

									<?php $iconPath = get_template_directory_uri() .'/images/icon-services.png'; ?>

									{
										<?php get_template_part( 'inc/BFI_Thumb' ); ?>
										<?php $params = array( "width" => 230, "height" => 150, "crop" => true ); $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "single-post-thumbnail" ); ?>

										latLng: [47.177350, 27.594863],
										options: {
											icon: "<?php echo esc_url($iconPath); ?>",
											shadow: "<?php echo get_template_directory_uri() ?>/images/shadow.png",
										}
									}	
										
									],
									options:{
										draggable: false
									}
								}
							});

							map = mapDiv.gmap3("get");

						    infobox = new InfoBox({
						    	pixelOffset: new google.maps.Size(-50, -65),
						    	closeBoxURL: '',
						    	enableEventPropagation: true
						    });
						    mapDiv.delegate('.infoBox .close','click',function () {
						    	infobox.close();
						    });

						    if (Modernizr.touch){
						    	map.setOptions({ draggable : false });
						        var draggableClass = 'inactive';
						        var draggableTitle = "Activate map";
						        var draggableButton = $('<div class="draggable-toggle-button '+draggableClass+'">'+draggableTitle+'</div>').appendTo(mapDiv);
						        draggableButton.click(function () {
						        	if($(this).hasClass('active')){
						        		$(this).removeClass('active').addClass('inactive').text("Activate map");
						        		map.setOptions({ draggable : false });
						        	} else {
						        		$(this).removeClass('inactive').addClass('active').text("Deactivate map");
						        		map.setOptions({ draggable : true });
						        	}
						        });
						    }

						});

						
					</script>
				<!-- /.Map script -->

				<?php 
					$event_map_place_loop = get_categories( array( 'taxonomy' => 'event_place') );
					foreach($event_map_place_loop as $event_map_place_loop_item) {
						
						$event_map_place_loop_item_term_id = $event_map_place_loop_item->term_id;
						$event_map_place_loop_item_name = $event_map_place_loop_item->name;

						$event_map_place_loop_item_lat = $tag_extra_fields[$event_map_place_loop_item_term_id]['cat_paces_event_location_maps_lat'];
						$event_map_place_loop_item_long = $tag_extra_fields[$event_map_place_loop_item_term_id]['cat_paces_event_location_maps_long'];
						
						$event_place_tax_data[] = array(
							'0' => $event_map_place_loop_item_term_id, 
							'1' => $event_map_place_loop_item_name,
							'2' => $event_map_place_loop_item_lat,
							'3' => $event_map_place_loop_item_long,
						);
					}	
									
				?>

				<script type="text/javascript">
					jQuery(document).ready(function($) {
							// When the window has finished loading create our google map below
							google.maps.event.addDomListener(window, 'load', initMap1);

							function initMap1() {
								// Basic options for a simple Google Map
								// For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
								var mapOptions = {
								// How zoomed in you want the map to start at (always required)
								zoom: <?php echo esc_attr($cat_paces_event_location_maps_zoom); ?>,
								scrollwheel: false,
								zoomControl: true,
								mapTypeControl: false,
								scaleControl: false,
								streetViewControl: false,
								// The latitude and longitude to center the map (always required)
								center: new google.maps.LatLng(<?php echo esc_attr($cat_paces_event_location_maps_lat); ?>,<?php echo esc_attr($cat_paces_event_location_maps_long); ?>), // map center
								// How you would like to style the map.
								// This is where you would paste any style found on Snazzy Maps.
								<?php 
									global $redux_demo; 
									$map_style = $redux_demo['map-style']; 
									if(!empty($map_style)) { ?>
										,"styles": <?php echo $map_style; ?> 
									<?php } ?>
							};
							// Get the HTML DOM element that will contain your map
							// We are using a div with id="map" seen below in the <body>
								var mapElement = document.getElementById('map2');
								// Create the Google Map using our element and options defined above
								var map = new google.maps.Map(mapElement, mapOptions);
								// Let's also add a marker while we're at it
								var image = '<?php echo get_template_directory_uri() .'/images/icon-services.png'; ?>';

								<?php 
									$i = 0;
									foreach($event_place_tax_data as $event_place_tax_data_item) {
										$i++;
										if(!empty($event_place_tax_data_item[2]) AND !empty($event_place_tax_data_item[3])) {
								?>
									

									var marker<?php echo $i; ?> = new google.maps.Marker({
										icon: image,
										animation: google.maps.Animation.DROP,
										position: new google.maps.LatLng(<?php echo $event_place_tax_data_item[2]; ?>, <?php echo $event_place_tax_data_item[3]; ?>),
										map: map,
										title: '<?php $event_place_tax_data_item[1] ?>'
									});

									
									var contentString<?php echo $i; ?> = "<div class='map_box'><a href='<?php echo get_term_link($event_place_tax_data_item[0]); ?>'><?php echo $event_place_tax_data_item[1] ?></a></div>";

									var infowindow<?php echo $i; ?> = new google.maps.InfoWindow({
									          content: contentString<?php echo $i; ?>
									        });


									marker<?php echo $i; ?>.addListener('click', function() {
							          infowindow<?php echo $i; ?>.open(map, marker<?php echo $i; ?>);
							        });

							        google.maps.event.addListener(map, "click", function(event) {
									    infowindow<?php echo $i; ?>.close();
									});

								<?php } } ?>
							} 
						});
						</script>

<?php get_footer(); ?>
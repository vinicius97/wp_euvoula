<?php 

function eventbuilder_custom_styles() {

	wp_enqueue_style(
		'custom-style',
		get_template_directory_uri() . '/css/custom-styles.css'
	);

	global $redux_demo; 
    $themesdojo_main_color = $redux_demo['main-color'];
    $themesdojo_hover_color = $redux_demo['main-color-hover'];
    $measure_system = $redux_demo['measure-system'];

    // Main Color
    if(!empty($themesdojo_main_color)) {

        $custom_css_main_color = "
                input[type='submit'],
                .nav li.current a,
                .nav li.current-menu-item a,
                .nav li.current_page_item a,
                .speaker-contacts > .contact:hover,
                .social-icons li a:hover,
                .form-notification,
                .table-price,
                .gotop:hover,
                .preloader div,
                .owl-btn.prev:hover,
                .owl-btn.next:hover,
                .flex-control-paging li a.flex-active,
                .flex-control-paging li a.flex-active:hover,
                .owl-page.active span,
                .owl-page.active span:hover,
                .preloader,
                .preloader:before,
                .preloader:after,
                #register-event-loading,
                #subscribe-event-loading,
                #header-register-button,
                .submit-loading,
                .td-buttom,
                button,
                input[type='button'],
                input[type='submit'],
                .dark button,
                .dark input[type='button'],
                .dark input[type='submit'],
                .item-image-gallery li a .fa,
                #my-account-content #tabs li a:hover,
                #my-account-content #tabs li.active a,
                .my-listings-item-edit,
                .my-listings-item-delete,
                .my-listings-item-publish,
                .my-listings-item-unpublish,
                .my-listings-item-loading,
                #submit_add_portfolio:hover,
                #submit_add_speakers:hover,
                #submit_add_partnesrs:hover,
                #social-block-expand:hover,
                #cover-image-block-expand:hover,
                #gallery-block-expand:hover,
                #speakers-block-expand:hover,
                #partners-block-expand:hover,
                #address-block-expand:hover,
                #contact-block-expand:hover,
                #wh-block-expand:hover,
                #video-block-expand:hover,
                #map-block-expand:hover,
                #header-block-expand:hover,
                #amenities-block-expand:hover,
                #booking-block-expand:hover,
                #main-settings-block-expand:hover,
                .overall-number,
                .category-shortcode-block a.cat-link:hover,
                .event-header-block,
                .event-stats-percent,
                .open .schedule-time { 
                    background-color: {$themesdojo_main_color};
                }

                a,
                .accordion-heading span,
                .speaker-contacts > .contact,
                .table-features li.fa-check-circle,
                .owl-btn.prev,
                .owl-btn.next,
                div.fancy-select ul.options li.hover,
                .main-color,
                .back-to-top:hover .fa,
                #breadcrumbs li a:hover,
                #page-title.page-title-content #breadcrumbs li a:hover,
                .author-name a:hover,
                #page-title.page-title-content .author-name a:hover,
                .item-block-title .fa,
                .item-block-title .package-price,
                .amenities-item .fa,
                .transaction-block-header h5 span,
                .star-rating .fa,
                .star-rating-nb .fa,
                .star-rating-nb,
                .aright .fa,
                #reviews-flexslider .flex-direction-nav a:hover,
                .review-item-author-value,
                .listing-container-views .fa,
                #show-map-button .fa,
                #show-grid-button .fa,
                #show-list-button .fa. .speakers-list-link-button { 
                    color: {$themesdojo_main_color};
                }

                #pageinval44 > span.seconds,
                
                #pageinval44 > span.seconds span { 
                    color: {$themesdojo_main_color} !important;
                }

                .speaker:hover .speaker-photo,
                .speaker-contacts > .contact,
                
                .social-icons li a:hover,
                
                .gotop:hover,
                
                .speaker-contacts > .contact:hover,
                
                div.fancy-select div.trigger.open,
                
                .quote-post,
                
                .link-post,
                
                .speakers-list-link-button,
                
                .speakers-list-link-button:hover { 
                    border-color: {$themesdojo_main_color} !important;
                }

                .transaction-block-header { 
                    border-color: {$themesdojo_main_color};
                }

                .event-summery-icon { 
                    background: {$themesdojo_main_color};
                }

                .speakers-list-avatar img { 
                    box-shadow: 0 0 0 1px {$themesdojo_main_color},
                0 0 0 2px {$themesdojo_main_color},
                0 0 0 3px {$themesdojo_main_color},
                0 0 0 4px {$themesdojo_main_color},
                0 0 0 5px {$themesdojo_main_color} !important; 
                }

                ";
        wp_add_inline_style( 'custom-style',
               $custom_css_main_color );

    }

    // Main Hover Color
    if(!empty($themesdojo_hover_color)) {

        $custom_css_main_hover_color = "
                a:hover,
                a:active,
                a:focus,
                .post-info a:hover,
                .widget-container a:hover,
                #footer .widget-container a:hover,
                header ul a:hover,
                .main-menu ul li a:hover,
                .main-menu ul li.current-menu-item a,
                .main-menu ul li:hover > a,
                .main-menu .menu li.current_page_item a,
                .main-menu .menu li.current-menu-item a,
                .main-menu .menu li.current_page_item a .fa,
                .main-menu .menu li.current-menu-item a .fa,
                .main-menu .menu li a:hover .fa,
                .main-menu ul li.current-menu-item .sub-menu a:hover,
                .main-menu ul li.current_page_item .sub-menu a:hover,
                .tag-filter:hover,
                .main-menu ul li ul.sub-menu li a:hover { 
                    color: {$themesdojo_hover_color};
                }

                #my-account-content #tabs li a:hover,
                #my-account-content #tabs li.active a,
                #my-account-content #tabs li a:hover .fa,
                #my-account-content #tabs li.active a .fa { 
                    border-color: {$themesdojo_hover_color};
                }

                .td-buttom:hover,
                .td-buttom:active,
                .td-buttom:focus,
                button:hover,
                input[type='submit']:hover,
                input[type='button']:hover,
                button:focus,
                input[type='submit']:focus,
                input[type='button']:focus,
                .dark button:hover,
                .dark input[type='submit']:hover,
                .dark input[type='button']:hover,
                .dark button:focus,
                .dark input[type='submit']:focus,
                .dark input[type='button']:focus,
                .flex-direction-nav a:hover,
                #maps-holder .maps-buttons span:hover,
                #big-maps-holder .maps-buttons span:hover,
                .my-listings-item-edit:hover,
                .my-listings-item-delete:hover,
                .my-listings-item-publish:hover,
                .my-listings-item-unpublish:hover,
                .my-listings-item-edit:active,
                .my-listings-item-delete:active,
                .my-listings-item-publish:active,
                .my-listings-item-unpublish:active,
                .my-listings-item-loading:hover,
                .ui-slider-horizontal .ui-slider-range-min,
                .speakers-list-link-button:hover { 
                    background-color: {$themesdojo_hover_color};
                }

                ";
        wp_add_inline_style( 'custom-style',
               $custom_css_main_hover_color );

    }

    if(!empty($measure_system)) {

        if($measure_system == "1") {

            $template_url = get_template_directory_uri();

            $custom_css_second_color = "
                    .range-pin { background: transparent url({$template_url}/images/range-mi.png) no-repeat top left;

                    ";
            wp_add_inline_style( 'custom-style',
                   $custom_css_second_color );

        }

    }

}
add_action( 'wp_enqueue_scripts',
               'eventbuilder_custom_styles' );

